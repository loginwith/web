<?php
// define BOT_TOKEN, WEBHOOK_URL, SEND_TO_USERIDS in config.php

function telegram_api_webhook_reply($method, $parameters) {
  if (!is_string($method)) {
    error_log("Method name must be a string\n");
    return false;
  }

  if (!$parameters) {
    $parameters = array();
  } else if (!is_array($parameters)) {
    error_log("Parameters must be an array\n");
    return false;
  }

  $parameters["method"] = $method;

  $payload = json_encode($parameters);
  header('Content-Type: application/json');
  header('Content-Length: '.strlen($payload));
  echo $payload;

  return true;
}

function exec_curl_request($handle) {
  $response = curl_exec($handle);

  if ($response === false) {
    $errno = curl_errno($handle);
    $error = curl_error($handle);
    error_log("Curl returned error $errno: $error\n");
    curl_close($handle);
    return false;
  }

  $http_code = intval(curl_getinfo($handle, CURLINFO_HTTP_CODE));
  curl_close($handle);

  if ($http_code >= 500) {
    // do not wat to DDOS server if something goes wrong
    sleep(10);
    return false;
  } else if ($http_code != 200) {
    $response = json_decode($response, true);
    error_log("Request has failed with error {$response['error_code']}: {$response['description']}\n");
    if ($http_code == 401) {
      throw new Exception('Invalid access token provided');
    }
    return false;
  } else {
    $response = json_decode($response, true);
    if (isset($response['description'])) {
      error_log("Request was successful: {$response['description']}\n");
    }
    $response = $response['result'];
  }

  return $response;
}

function telegram_api_request($method, $parameters) {
  if (!is_string($method)) {
    error_log("Method name must be a string\n");
    return false;
  }

  if (!$parameters) {
    $parameters = array();
  } else if (!is_array($parameters)) {
    error_log("Parameters must be an array\n");
    return false;
  }

  foreach ($parameters as $key => &$val) {
    // encoding to JSON array parameters, for example reply_markup
    if (!is_numeric($val) && !is_string($val)) {
      $val = json_encode($val);
    }
  }

  $url = 'https://api.telegram.org/bot'.BOT_TOKEN.'/'.$method.'?'.http_build_query($parameters);
  $handle = curl_init($url);
  curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($handle, CURLOPT_CONNECTTIMEOUT, 5);
  curl_setopt($handle, CURLOPT_TIMEOUT, 10);

  return exec_curl_request($handle);
}

function telegram_api_request_json($method, $parameters) {
  if (!is_string($method)) {
    error_log("Method name must be a string\n");
    return false;
  }

  if (!$parameters) {
    $parameters = array();
  } else if (!is_array($parameters)) {
    error_log("Parameters must be an array\n");
    return false;
  }

  $parameters["method"] = $method;

  $handle = curl_init('https://api.telegram.org/bot'.BOT_TOKEN.'/');
  curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($handle, CURLOPT_CONNECTTIMEOUT, 5);
  curl_setopt($handle, CURLOPT_TIMEOUT, 10);
  curl_setopt($handle, CURLOPT_POST, true);
  curl_setopt($handle, CURLOPT_POSTFIELDS, json_encode($parameters));
  curl_setopt($handle, CURLOPT_HTTPHEADER, array("Content-Type: application/json"));

  return exec_curl_request($handle);
}

function processMessage($message) {
  $debug = var_export($message, true);

  if(!in_array($message['from']['id'], SEND_TO_USERIDS)) return;

  // process incoming message
  $message_id = $message['message_id'];
  $chat_id = $message['chat']['id'];
  if (isset($message['text'])) {
    // incoming text message
    $text = $message['text'];

    if (strpos($text, "/start") === 0) {
      telegram_api_request_json("sendMessage", array('chat_id' => $chat_id, "text" => 'Hello', 'reply_markup' => array(
        'keyboard' => array(array('Hello', 'Hi')),
        'one_time_keyboard' => true,
        'resize_keyboard' => true)));
    } else if ($text === 'debug') {
      telegram_api_request("sendMessage", ['chat_id' => $chat_id, "text" => $debug]);
    } else if ($text === "Hello" || $text === "Hi") {
      telegram_api_request("sendMessage", array('chat_id' => $chat_id, "text" => 'Nice to meet you'));
    } else if (strpos($text, "/stop") === 0) {
      // stop now
    } else {
      telegram_api_webhook_reply("sendMessage", array('chat_id' => $chat_id, "reply_to_message_id" => $message_id, "text" => 'Cool'));
    }
  } else {
    telegram_api_request("sendMessage", array('chat_id' => $chat_id, "text" => 'I understand only text messages'));
  }
}

function telegram_send($text) {
  try {
    foreach(SEND_TO_USERIDS as $userId) {
      telegram_api_request("sendMessage", ['chat_id' => $userId, "text" => $text]);
    }
  } catch(Exception $e) {
    error_log($e);
  }
}

function telegram_send_html($html) {
  try {
    foreach(SEND_TO_USERIDS as $userId) {
      telegram_api_request("sendMessage", ['chat_id' => $userId, "text" => $html, 'parse_mode' => 'html']);
    }
  } catch(Exception $e) {
    error_log($e);
  }
}

if (php_sapi_name() == 'cli') {
  // if run from console, set or delete webhook
  telegram_api_request('setWebhook', array('url' => isset($argv[1]) && $argv[1] == 'delete' ? '' : WEBHOOK_URL));
  exit;
}

function telegram_process_webhook() {
  $content = file_get_contents("php://input");
  $update = json_decode($content, true);

  if (!$update) {
    // receive wrong update, must not happen
    exit;
  }

  if (isset($update["message"])) {
    processMessage($update["message"]);
  }
}
