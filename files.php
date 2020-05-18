<?php

$f = fopen("time.txt", "a+");

//a+ дописывает в файл
//w - переписывает файл
//r - только читает

fwrite($f, date("d.m.Y H:i:s"));
fwrite($f, PHP_EOL);
fclose($f);

//

$f = fopen("time.txt", "r");
$s = fread($f, filesize("time.txt"));
fclose($f);

$a = explode(PHP_EOL, $s);

foreach ($a as $i => $item) {
  var_dump($i);
  var_dump($item);
}

//var_dump($a);