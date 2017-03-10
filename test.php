<?php

// error_reporting(E_ALL ^ E_NOTICE);
require __DIR__ . '/number2chinese.php';



$num1 = 0.1234567890;
echo number2chinese($num1), '<br>';    // 零点一二三四五六七八九
echo number2chinese($num1, true), '<br>';    // 零元壹角贰分叁厘肆毫
// 若想精确小数点后两位，请先处理$num1
echo number2chinese(number_format($num1, 2)), '<br>';    // 零点一二
echo number2chinese(number_format($num1, 2), true), '<br>';    // 零元壹角贰分

$num = 0.1234567890;
echo $num, '<br>', number2chinese($num), '<br>', number2chinese($num, true), '<br>', '<br>';

$num = 2017.202200017;
echo $num, '<br>', number2chinese($num), '<br>', number2chinese($num, true), '<br>', '<br>';

$num = 2000000002000.200200002200017;
echo $num, '<br>', number2chinese($num), '<br>', number2chinese($num, true), '<br>', '<br>';

$num = 2017;
echo $num, '<br>', number2chinese($num), '<br>', number2chinese($num, true), '<br>', '<br>';


$num = 000010000.00010000;
echo $num, '<br>', number2chinese($num), '<br>', number2chinese($num, true), '<br>', '<br>';
