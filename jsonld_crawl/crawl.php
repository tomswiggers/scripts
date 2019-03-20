<?php
$counter = 1;
$url = '';

while ($content = file_get_contents($url)) {
  printf('[%s] Fetched [%s] %s'.PHP_EOL, date('Y-d-m H:i:s'), $counter, $url);

  $dom = new DOMDocument();
  @$dom->loadHTML($content);

  foreach ($dom->getElementsByTagName('*') as $node) {

    if ($node->getNodePath() == '/html/head/script[1]') {
      $jsonld = $node->nodeValue;
      $ld = json_decode($jsonld);
      $links = end($ld);

      $next = $links->next;
      $previous = $links->previous;
    }
  }

  $url = $previous;
  $url = $next;
  $counter++;
}

