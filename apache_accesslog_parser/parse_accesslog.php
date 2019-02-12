<?php

$requests = array();
$requests_per_minute = array();
$requests_per_user_agent = array();
$counter = 0;

$user_agent_check = FALSE;
$user_agent = 'xxxx';

$request_check = TRUE;
$request_label = 'xxxx';

$file = 'access.log';

$handle = fopen($file, 'r');

if ($handle) {

  while (($buffer = fgets($handle, 4096)) !== false) {
    $data = json_decode($buffer);

    if ($data == NULL) {
      $buffer = str_replace("\\", "", $buffer);
      $data = json_decode($buffer);
    }

    // Group requests
    if (isset($data->request)) {
      $request = $data->request;
    }
    else {
      $request = 'empty';
    }

    if (array_key_exists($request, $requests)) {
      $requests[$request] += 1;
    }
    else {
      $requests[$request] = 1;
    }
  
    // Group user agents

    if (isset($data->userAgent)) {
      $user_agent = $data->userAgent;
    }
    else {
      $user_agent = 'empty';
    }

    if (array_key_exists($user_agent, $requests_per_user_agent)) {
      $requests_per_user_agent[$user_agent] += 1;
    }
    else {
      $requests_per_user_agent[$user_agent] = 1;
    }

    // date time parsing
    // time format [07/Feb/2019:03:26:14 +0100]
    if (isset($data->time)) {
      $format = 'd/M/Y:H:i:s P';
      $date = DateTime::createFromFormat($format, trim($data->time, '[]'));
      $minute = $date->format('Y-m-d H:i');

      $add_to_requests_per_minute = TRUE;
      $user_agent_flag = (isset($data->userAgent) && $data->userAgent == $user_agent);
      $request_check_flag = (isset($data->request) && $data->request == $request_label);

      if ($request_check && !$request_check_flag) {
        $add_to_requests_per_minute = FALSE;
      }
      
      if ($user_agent_check && !$user_agent_flag) {
        $add_to_requests_per_minute = FALSE;
      }      

      if ($add_to_requests_per_minute) {
        $counter++;

        echo $data->userAgent.PHP_EOL;

        if (array_key_exists($minute, $requests_per_minute)) {
          $requests_per_minute[$minute]++;
        }
        else {
          $requests_per_minute[$minute] = 1;
        }
      }
    }

  }

  if (!feof($handle)) {
    echo "Error: unexpected fgets() fail\n";
  }

  fclose($handle);

  // Show requests per minute
  //foreach ($requests_per_minute as $key => $val) echo $key .';'. $val.PHP_EOL;

  //echo $counter.PHP_EOL;

  asort($requests);
  foreach ($requests as $key => $val) echo $val .';'. $key.PHP_EOL;

  //asort($requests_per_user_agent);
  //foreach ($requests_per_user_agent as $key => $val) echo $val .';'. $key.PHP_EOL;
}
