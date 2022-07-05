<?php
require __DIR__ . '/../vendor/autoload.php';

require __DIR__ . '/../config.php';
require __DIR__ . '/lib.php';
require __DIR__ . '/telegram.php';
require __DIR__ . '/../db.php';

function exception_handler($ex) {
  ob_end_clean();
  http_response_code(500);
  echo "Internal Server Error\n";
  echo("Uncaught exception class=" . get_class($ex) . " message=" . $ex->getMessage() . " file=" . $ex->getFile() .  " line=" . $ex->getLine());

  $sessionVars = var_export($_SESSION, true);
  $requestVars = var_export($_REQUEST, true);
  error_log($ex->getMessage());
  error_log($ex->getTraceAsString());
  telegram_send_html("Uncaught exception: <b>" . $ex->getMessage() . "</b>\n<pre>" . $ex->getTraceAsString() . "</pre>\n<b>URI:</b> " . $_SERVER['REQUEST_URI'] . "\n<b>Session:</b> " . $sessionVars . "\n<b>Request:</b> " . $requestVars);
}

set_exception_handler('exception_handler');

$filename = __DIR__ . preg_replace('#(\?.*)$#', '', $_SERVER['REQUEST_URI']);
if (php_sapi_name() === 'cli-server' && is_file($filename)) {
  return false;
}

session_name('SID');
session_start(['cookie_lifetime' => 24*7*3600,'cookie_secure' => false,'cookie_httponly' => true]);

if(!isset($_SESSION['csrf_token'])) {
  $_SESSION["csrf_token"] = bin2hex(random_bytes(32));
}

$router = new \Bramus\Router\Router();
$router->set404(fn() => require __DIR__ . '/404.php');

// require all POST requests to have valid CSRF token
$router->before('POST', '/.*', function() {
  /*
  if(!isset($_REQUEST['csrf_token']) || $_REQUEST['csrf_token'] != $_SESSION['csrf_token']) {
    header('HTTP/1.0 400 Bad Request');
    exit();
  }
  */
});

$router->get('/', fn() => require __DIR__ . '/landing.php');
$router->get('/h/landing-tabs', fn() => require __DIR__ . '/landing-tabs.php');
$router->get('/pricing', fn() => require __DIR__ . '/pricing.php');
$router->get('/guides', function() {
  $UI = 'content';
  $title = 'Guides';
  require __DIR__ . '/app.php';
});
$router->get('/guides/login-with-ethereum', fn() => require __DIR__ . '/guides/login-with-ethereum.php');

$router->get('/login', function() {
  if(isset($_SESSION['user_id'])) {
    header('Location: /app');
    exit();
  }

  require __DIR__ . '/login.php';
});

$router->get('/login-rsvp', function() {
  global $dbh;

  if(isset($_REQUEST['check'])) {
    $sth = $dbh->prepare("SELECT email, response, expires FROM magic_links WHERE id=?");
    $sth->execute([$_REQUEST['id']]);
    [$email, $response, $expires] = $sth->fetch();

    if($expires < time()) {
      $sth = $dbh->prepare("UPDATE magic_links SET response=2 WHERE id=?");
      $sth->execute([$_REQUEST['id']]);
      $response = 2;
    }

    if($response == 1) {
      unset($_SESSION['login_rsvp_id']);

      try {
        $user = user_auth('email', $email);
        if(!$user) {
          $user_id = user_create_email($email);
          $user = user_get($user_id);
        }

        telegram_send('Someone logged in using email: ' . $email);

        if(!$user) throw new Exception('unable to create user account');

        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user'] = $email;
      } catch(Exception $e) {
        $_SESSION['flash'] = $e->getMessage();
        $_SESSION['flash_type'] = 'error';
        header("Location: /login");
        exit();
      }

      echo '<script>window.top.location.replace("/app")</script>';
    } elseif($response == 2) {
      unset($_SESSION['login_rsvp_id']);
      $_SESSION['flash'] = "The login attempt was rejected.";
      $_SESSION['flash_type'] = 'error';
      echo '<script>window.top.location.replace("/login")</script>';
    } else{ 
      echo '<meta http-equiv="refresh" content="3">';
    }

    exit();
  }

  require __DIR__ . '/login-rsvp.php';
});

$router->post('/login-rsvp', function() {
  global $dbh;

  $sth = $dbh->prepare("UPDATE magic_links SET response=? WHERE id=?");

  if($_REQUEST['rsvp'] == 'approve') {
    $sth->execute([1, $_REQUEST['id']]);
  } else {
    $sth->execute([2, $_REQUEST['id']]);
  }

  require __DIR__ . '/login-rsvp.php';
});

function clearSession() {
  session_destroy();
}

$router->get('/logout', function() {
  clearSession();
  header('Location: /');
});

function verifyLWT($lwt, $domain) {
  $opts = ['http' => [
    'ignore_errors' => true,
    'method' => 'POST',
    'header' => 'Content-Type: application/x-www-form-urlencoded',
    'content' => http_build_query(['ticket' => $lwt, 'domain' => $domain])
  ]];
  $context = stream_context_create($opts);
  $result = file_get_contents('https://api.loginwith.xyz/v1/verify', false, $context);
  return json_decode($result, true);
}

function isLWTExpired($lwt) {
  return time() - $lwt['expires_at'] > 0;
}

$router->post('/login', function() {
  if(isset($_REQUEST['lwt'])) {
    $lwt = verifyLWT($_REQUEST['lwt'], $_SERVER['HTTP_HOST']);

    if($lwt['valid']) {
      // [] style
      //[$id1, $name1] = $data[0];

      try {
        $user = user_auth($lwt['network'], $lwt['account']);
        if(!$user) {
          $user_id = user_create_lwt($lwt['network'], $lwt['account']);
          $user = user_get($user_id);
        }

        telegram_send('Someone logged in using ' . $lwt['network'] . ': ' . $lwt['display_name']);

        if(!$user) throw new Exception('unable to create user account');

        $_SESSION['lwt'] = $lwt;
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user'] = $lwt['display_name'];
      } catch(Exception $e) {
        $_SESSION['flash'] = $e->getMessage();
        $_SESSION['flash_type'] = 'error';
        header("Location: /login");
        exit();
      }
    } else {
      $_SESSION['flash'] = $lwt['error'];
      $_SESSION['flash_type'] = 'error';
    }
  } else {
    $email = $_REQUEST['email'];

    try {
      $rsvp_id = user_auth_send_magic_link($_REQUEST['email']);
    } catch(Exception $e) {
      $_SESSION['flash'] = $e->getMessage();
      $_SESSION['flash_type'] = 'error';
      header("Location: /login");
      exit();
    }

    $_SESSION['login_rsvp_id'] = $rsvp_id;

    require __DIR__ . '/login.php';
    exit();

    /*
    $_SESSION['flash'] = "We just sent you an email with a login link. Click the Approve button to continue.";
    $_SESSION['flash_type'] = 'success';
    $_SESSION['login_email_wait'] = 'success';
    */
  }

  if(isset($_SESSION['user_id'])) {
    header("Location: /app");
    unset($_SESSION['flash']);
    unset($_SESSION['flash_type']);
    exit();
  }

  header("Location: /login");
});

$router->post("/sapi/tg", function() {
  telegram_process_webhook();
});

$router->options('/api/init', function() {
  header('Access-Control-Allow-Origin: ' . ($_SERVER['HTTP_ORIGIN'] ?? '*'));
  header('Access-Control-Allow-Methods: GET');
  header('Access-Control-Allow-Credentials: true');
  header('Access-Control-Allow-Headers: Authorization, Content-Type');
});

$router->get('/api/init', function() use ($router) {
  header('Content-Type: application/json');
  header('Access-Control-Allow-Origin: ' . ($_SERVER['HTTP_ORIGIN'] ?? '*'));
  header('Access-Control-Allow-Methods: GET');
  header('Access-Control-Allow-Credentials: true');
  header('Access-Control-Allow-Headers: Authorization, Content-Type');

  if(isset($_SERVER['HTTP_REFERER']) && !str_contains($_SERVER['HTTP_REFERER'], 'https://loginwith.xyz/') && !str_contains($_SERVER['HTTP_REFERER'], 'http://localhost')) {
    telegram_send('JS SDK loaded on: ' . $_SERVER['HTTP_REFERER']);
  }

  [$_, $key] = explode(' ', $_SERVER['HTTP_AUTHORIZATION'] ?? '', 2);
  $project = project_get_by_api_key($key);
  if(!$project) {
    throw new Exception('project not found');
  }

  $config = [];
  $config['valid'] = true;
  $config['domain'] = $project['domain'];
  $config['session_validity'] = $project['lwt_ttl'];
  $config['methods'] = json_decode($project['lwt_methods']);

  echo json_encode($config);
});

$router->before('GET|POST', '/app|/app/.*', authenticated(fn() => true));

$router->mount('/app', function () use ($router) {
  $router->get('/', function () {
    $UI = 'app';
    $title = "Dashboard";
    include __DIR__ . "/app.php";
  });

  $router->get('/projects', function () {
    $UI = 'app';
    $title = "Projects";
    include __DIR__ . "/app.php";
  });

  $router->post('/projects', function() {
    $project_id = project_create($_REQUEST['name']);
    header('Location: /app/projects');
    exit();
  });

  $router->get('/projects/new', function () {
    $UI = 'app';
    $title = "New Project";
    include __DIR__ . "/app.php";
  });

  $router->post('/projects', function () {
    require __DIR__ . '/projects-create.php';
  });

  $router->get('/projects/(.+)', function ($PROJECT_ID) use ($router) {
    $PROJECT = project_get($PROJECT_ID);
    if(!$PROJECT) {
      $router->trigger404();
      return;
    }

    $UI = 'app';
    $title = "New Project";
    include __DIR__ . "/app.php";
  });

  $router->post('/projects/(.+)', function ($project_id) {
    if($_REQUEST['action'] == 'delete') {
      project_delete($project_id);
      header('Location: /app/projects');
      exit();
    } elseif($_REQUEST['action'] == 'rollkey') {
      project_roll_api_key($project_id);
      header('Location: /app/projects/' . $project_id);
      exit();
    } else {
      try {
        project_update($project_id, [
          'name' => $_REQUEST['name'],
          'domain' => $_REQUEST['domain'],
          'methods' => $_REQUEST['methods'],
          'session_expiry' => $_REQUEST['session_expiry'],
        ]);
      } catch(Exception $ex) {
        $_SESSION['flash'] = $ex->getMessage();
        $_SESSION['flash_type'] = 'error';
      }
      header('Location: /app/projects/' . $project_id);
      exit();
    }
  });

  $router->delete('/projects/(\d+)', function ($id) {
      echo 'Update movie id ' . htmlentities($id);
  });
});
 
$router->run();

function authenticated(callable $fn): Closure {
  return (function() use ($fn) {
    error_log('AUTHENTICATED: ' . $_SERVER['REQUEST_URI'] . ' -> user_id: ' . ($_SESSION['user_id'] ?? '<undefined>'));

    if(isset($_SESSION['user_id'])) {
      if(isset($_SESSION['lwt']) && isLWTExpired($_SESSION['lwt'])) {
        clearSession();
        $_SESSION['next_url'] = $_SERVER['REQUEST_URI'];
        $_SESSION['flash'] = 'Your web3 login ticket has expired. Please sign-in again.';
        $_SESSION['flash_type'] = 'error';
        header('Location: /login');
        exit();
      }

      return $fn();
    } else {
      $_SESSION['next_url'] = $_SERVER['REQUEST_URI'];
      $_SESSION['flash'] = 'You need to login to continue.';
      $_SESSION['flash_type'] = 'error';
      header('Location: /login');
      exit();
    }
  });
}
