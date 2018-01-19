<?php

error_reporting(E_ALL);
require __DIR__ . '/number2chinese.php';

$br = PHP_SAPI == 'cli' ? "\r\n" : '<br>';

if (array_key_exists(1, $argv) && $num = $argv[1]) {
    echo $num, ' -> ', number2chinese($num), $br;
    echo $num, ' -> ', number2chinese($num, true), $br;
    die;
}

$num = '';
for ($i = 0; $i < 10; $i++) {
    $symbol = mt_rand(0, 9) < 5 ? '' : '-';
    $num = $symbol . randNum($i);
    echo $num, ' -> ', number2chinese($num), $br;
    echo $num, ' -> ', number2chinese($num, true), $br;
}

echo $br, $br;

$num = '';
for ($i = 0; $i < 10; $i++) {
    $symbol = mt_rand(0, 9) < 5 ? '' : '-';
    $num = $symbol . randNum($i) . '.' . randNum($i);
    $num = $num == '.' ? 0 : $num;
    echo $num, ' -> ', number2chinese($num), $br;
    echo $num, ' -> ', number2chinese($num, true), $br;
}

function randNum($i)
{
    $num = '';
    for ($j = 0; $j < $i; $j++) {
        $num .= mt_rand(0, 9) > 3 ? mt_rand(0, 9) : 0;
    }
    $num = ltrim($num, '0');
    return $num ?: 0;
}
