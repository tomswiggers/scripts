<?php

$d = new DateTime('2019-05-13');

for ($i=0;$i<20;$i++) {
  $d1 = $d->format('d M Y');
  $d->add(new DateInterval('P11D'));
  $d2 = $d->format('d M Y');

  echo $d1 .' - '. $d2.PHP_EOL;

  $d->add(new DateInterval('P3D'));
}
