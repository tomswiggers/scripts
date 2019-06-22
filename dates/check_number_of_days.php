<?php

$startDate = $argv[1];

$start = new DateTime($startDate);
$end = new DateTime();

echo 'Start: '. $start->format('Y-m-d').PHP_EOL;;
echo 'End: '. $end->format('Y-m-d').PHP_EOL;

$diff = $end->diff($start)->format('%a');

echo 'Diff: '. $diff.PHP_EOL;
