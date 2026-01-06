<?php
$amount = 1000000; //元本
$rate = 0.01; //年利1%

for ($year = 0 ; $year < 20 ; $year++){
  $amount *= (1 + $rate); // $amount = $amount * (1 + $rate)
  echo "{$year}年目：".number_format(round($amount))."円<br>";
}