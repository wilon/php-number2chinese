<?php

error_reporting(E_ALL);
require __DIR__ . '/number2chinese.php';

$br = PHP_SAPI == 'cli' ? "\r\n" : '<br>';

if (array_key_exists(1, $argv) && $num = $argv[1]) {
    echo $num, ' -> ', number2chinese($num), $br;
    echo "¥$num -> ", number2chinese($num, true), $br;
    die;
}

// 随机一些整数进行测试
$num = '';
echo '随机一些整数进行测试：', $br;
for ($i = 0; $i < 10; $i++) {
    $symbol = mt_rand(0, 9) < 5 ? '' : '-';
    $num = $symbol . randNum($i);
    echo $num, ' -> ', number2chinese($num), $br;
    echo "¥$num -> ", number2chinese($num, true), $br;
}

echo $br;

// 随机一些整数进行测试
$num = '';
echo '随机一些小数进行测试：', $br;
for ($i = 0; $i < 10; $i++) {
    $symbol = mt_rand(0, 9) < 5 ? '' : '-';
    $num = $symbol . randNum($i) . '.' . randNum($i);
    $num = $num == '.' ? 0 : $num;
    echo $num, ' -> ', number2chinese($num), $br;
    echo "¥$num -> ", number2chinese($num, true), $br;
}
echo $br;

// 验证测试
$verify = [
    '325.04' => [
        '三百二十五点零四',
        '叁佰贰拾伍元零肆分',
    ],
    '1409.50' => [
        '一千四百零九点五零',
        '壹仟肆佰零玖元伍角',
    ],
    '6007.14' => [
        '六千零七点一四',
        '陆仟零柒元壹角肆分',
    ],
    '16409.02' => [
        '一万六千四百零九点零二',
        '壹万陆仟肆佰零玖元零贰分',
    ],
    '107000.53' => [
        '十万零七千点五三',
        '壹拾万零柒仟元伍角叁分',
    ],
    '646743393.06' => [
        '六亿四千六百七十四万三千三百九十三点零六',
        '陆亿肆仟陆佰柒拾肆万叁仟叁佰玖拾叁元零陆分',
    ],
];

echo '验证测试：', $br;
foreach ($verify as $num => $res) {
    $cn = number2chinese($num);
    $cnRmb = number2chinese($num, true);
    if ($cn != $res[0]) {
        echo "$num -> $cn {$res[0]} 错误！$br";
        exit(1);
    }
    if ($cnRmb != $res[1]) {
        echo "¥$num -> $cnRmb {$res[1]} 错误！$br";
        exit(1);
    }
    echo "正确！ $num -> $cn $br";
    echo "正确！ ¥$num -> $cnRmb $br";
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
