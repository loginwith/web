<?php

use Postmark\PostmarkClient;

function base64url_encode($data) {
  return str_replace(['+','/','='], ['-','_',''], base64_encode($data));
}

function base64url_decode($data) {
  return base64_decode(str_replace(['-','_'], ['+','/'], $data));
}

function generate_hmac_token($email, $expires) {
  $data = $expires . "," . $email;
  $hmac = hash_hmac('sha1', $data, HMAC_SECRET);
  return base64url_encode($data . "," . hex2bin($hmac));
}

function verify_hmac_token($token) {
  [$exp, $email, $hmac] = explode(',', base64url_decode($token));
  $hmac = bin2hex($hmac);
  if(intval($exp) < time()) return false;
  return hash_equals(hash_hmac('sha1', "$exp,$email", HMAC_SECRET), $hmac);
}

function user_auth_send_magic_link($email) {
  global $dbh;

  $expires = time() + 60*10;

  $token = generate_hmac_token($email, $expires);

  $baseURL = (strpos($_SERVER['HTTP_HOST'], 'localhost') == 0 ? 'http://' : 'https://') . $_SERVER['HTTP_HOST'];
  $url = $baseURL . '/login-rsvp?id=' . urlencode($token);

  $sth = $dbh->prepare("INSERT INTO magic_links (email, id, expires) VALUES (?, ?, ?)");
  $sth->execute([$email, $token, $expires]);

  $client = new PostmarkClient(POSTMARK_API_TOKEN);
  $htmlBody = <<<_EOM
    <strong>LoginWith.xyz</strong><p>Please visit <a href="$url">$url</a> to approve this login attempt.
_EOM;
  $textBody = "Visit $url to approve this login attempt.";

  $sendResult = @$client->sendEmail(
    'LoginWith <no-reply@mail.loginwith.xyz>',
    $email,
    'Approve sign-in attempt to LoginWith.xyz',
    $htmlBody,
    $textBody,
    'login-link', // tag
    false, // track opens
    NULL, // Reply To
    NULL, // CC
    NULL, // BCC
    NULL, // Header array
    NULL, // Attachment array
    'None', // track links
    NULL, // Metadata array
    'outbound' // message stream
  );

  //var_dump($sendResult);

  return $token;
}

function user_auth($method, $account) {
  global $dbh;
  $sth = $dbh->prepare("SELECT * FROM users WHERE id=(SELECT user_id FROM login_identities WHERE method=? AND id=?)");
  $sth->execute([$method, $account]);
  $row = $sth->fetch();

  if(!$row) {
    return NULL;
  }

  return $row;
}

function user_create_email($email) {
  global $dbh;

  try {
    $id = randomId(16);

    $dbh->beginTransaction();

    $sth = $dbh->prepare("INSERT INTO users (id) VALUES (?)");
    $sth->execute([$id]);

    $sth = $dbh->prepare("INSERT INTO login_identities (type, method, id, user_id) VALUES (?, ?, ?, ?)");
    $sth->execute([1, 'email', $email, $id]);

    $dbh->commit();

    return $id;
  } catch(Exception $e) {
    $dbh->rollback();
    echo "create email user failed: " . $e->getMessage();
    throw $e;
  }
}

function user_create_lwt($method, $account) {
  global $dbh;

  try {
    $id = randomId(16);

    $dbh->beginTransaction();

    $sth = $dbh->prepare("INSERT INTO users (id) VALUES (?)");
    $sth->execute([$id]);

    $sth = $dbh->prepare("INSERT INTO login_identities (type, method, id, user_id) VALUES (?, ?, ?, ?)");
    $sth->execute([1, $method, $account, $id]);

    $dbh->commit();

    //echo "Last insert id: " . $dbh->lastInsertId() . "\n";

    return $id;
  } catch(Exception $e) {
    $dbh->rollback();
    echo "create lwt user failed: " . $e->getMessage();
    throw $e;
  }
}

function user_get($id) {
  global $dbh;

  $sth = $dbh->prepare("SELECT * FROM users WHERE id=?");
  $sth->execute([$id]);
  return $sth->fetch();
}

function project_create($name) {
  global $dbh;

  $id = randomId(16);

  $sth = $dbh->prepare("INSERT INTO projects (id, name, user_id) VALUES (?, ?, ?)");
  if($sth->execute([$id, $name, $_SESSION['user_id']])) {
    project_roll_api_key($id);
  }

  telegram_send('Project created: ' . $name);

  return $id;
}

function project_update($id, $data) {
  global $dbh;

  if($data['name']) {
    $sth = $dbh->prepare("UPDATE projects SET name=? WHERE id=? AND user_id=?");
    if(!$sth->execute([$data['name'], $id, $_SESSION['user_id']])) {
      throw new Exception('failed to update name');
    }
  }

  if($data['domain']) {
    $url = filter_var('http://'.$data['domain'], FILTER_VALIDATE_URL);
    if(!$url) throw new Exception('invalid hostname');
    $url = parse_url($url);

    $domain = $url['host'] . (isset($url['port']) ? ':' . $url['port'] : '');

    $sth = $dbh->prepare("UPDATE projects SET domain=? WHERE id=? AND user_id=?");
    if(!$sth->execute([$domain, $id, $_SESSION['user_id']])) {
      throw new Exception('failed to update domain');
    }
  }

  if($data['session_expiry']) {
    $sth = $dbh->prepare("UPDATE projects SET lwt_ttl=? WHERE id=? AND user_id=?");
    if(!$sth->execute([$data['session_expiry'], $id, $_SESSION['user_id']])) {
      throw new Exception('failed to update session expiry');
    }
  }

  if(isset($data['methods'])) {
    $methods = [];
    if(isset($data['methods']['ethereum'])) {
      $methods []= 'ethereum';
    }
    if(isset($data['methods']['solana'])) {
      $methods []= 'solana';
    }

    $sth = $dbh->prepare("UPDATE projects SET lwt_methods=? WHERE id=? AND user_id=?");
    if(!$sth->execute([json_encode($methods), $id, $_SESSION['user_id']])) {
      throw new Exception('failed to update methods');
    }
  }
}

function project_delete($id) {
  global $dbh;

  $sth = $dbh->prepare("DELETE FROM projects WHERE id=? AND user_id=?");
  $sth->execute([$id, $_SESSION['user_id']]);
}

function project_get($id) {
  global $dbh;

  $sth = $dbh->prepare("SELECT * FROM projects WHERE id=? AND user_id=?");
  $sth->execute([$id, $_SESSION['user_id']]);
  $row = $sth->fetch();
  return $row;
}

function project_get_api_keys($id) {
  global $dbh;

  $sth = $dbh->prepare("SELECT * FROM api_keys WHERE project_id=(SELECT id FROM projects WHERE id=? AND user_id=?)");
  $sth->execute([$id, $_SESSION['user_id']]);
  $rows = $sth->fetchAll();
  return $rows;
}

function project_get_by_api_key($apiKey) {
  global $dbh;

  $sth = $dbh->prepare("SELECT * FROM projects WHERE id=(SELECT project_id FROM api_keys WHERE key=?)");
  $sth->execute([$apiKey]);
  return $sth->fetch();
}

function project_roll_api_key($id) {
  global $dbh;

  if(!project_get($id)) {
    throw new Exception('not project owner');
  }

  $keys = project_get_api_keys($id);

  $dbh->beginTransaction();

  $sth = $dbh->prepare("DELETE FROM api_keys WHERE project_id=?");
  $sth->execute([$id]);

  $key = randomId(16);

  $sth = $dbh->prepare("INSERT INTO api_keys (key, project_id) VALUES (?, ?)");
  $sth->execute([$key, $id]);

  $dbh->commit();
}

//const ALPHABET = '_-0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
const ALPHABET = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ01';

function randomId(int $size) {
  $alphabetLength = strlen(ALPHABET);
  $mask = (2 << (int) (log($alphabetLength - 1) / M_LN2)) - 1;
  $step = (int) ceil(1.6 * $mask * $size / $alphabetLength);

  $id = '';

  while (true) {
    $bytes = unpack('C*', random_bytes($size));

    for ($i = 1; $i <= $step; $i++) {
      $byte = $bytes[$i] & $mask;

      if (isset(ALPHABET[$byte])) {
        $id .= ALPHABET[$byte];

        if (strlen($id) === $size) {
          return $id;
        }
      }
    }
  }
}
