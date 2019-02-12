<?php

require_once("geoip2.phar");
use GeoIp2\Database\Reader;

$reader = new Reader('GeoLite2-Country.mmdb');

$ips = array();
$countries = array();
$counter = 0;

$file = 'logfile';

$handle = fopen($file, 'r');

if ($handle) {

  while (($buffer = fgets($handle, 4096)) !== false) {
    $data = explode('|', $buffer);
    $ip = $data[1];


    if (strlen($ip)) {
      $record = $reader->country($ip);
      $country = $record->country->name;

      if (array_key_exists($country, $countries)) {
        $countries[$country]++;
      }
      else {
        $countries[$country] = 1;
      }
    }

    if (array_key_exists($ip, $ips)) {
      $ips[$ip]++;
    }
    else {
      $ips[$ip] = 1;
    }
  }

  if (!feof($handle)) {
    echo "Error: unexpected fgets() fail\n";
  }

  fclose($handle);

  asort($ips);
  asort($countries);

  foreach ($countries as $key => $val) echo $val .';'. $key.PHP_EOL;  

}
