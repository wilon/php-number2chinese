<?php

/**
 *
 * Number to chinese function.
 *
 * @license MIT License (MIT)
 *
 * @author Weilong Wang  <wilonx@163.com> https://github.com/wilon
 *
 */

if (! function_exists('number2chinese')) {

    function number2chinese($number, $isRmb = false)
    {
        // 判断正确数字
        list($integer, $decimal) = explode('.', $number . '.0');
        if (!preg_match('/^(\d+)?$/', $integer . $decimal)) {
            throw new Exception('number2chinese() wrong number', 1);
        }
        if (preg_match('/^\d+$/', $number)) {
            $decimal = null;
        }
        $integer = ltrim($integer, '0');
        // 准备参数
        $numArr  = ['', '一', '二', '三', '四', '五', '六', '七', '八', '九', '.' => '点'];
        $descArr = ['', '十', '百', '千', '万', '十', '百', '千', '亿', '十', '百', '千', '万亿', '十', '百', '千', '兆', '十', '百', '千'];
        if ($isRmb) {
            $number = substr(sprintf("%.5f", $number), 0, -1);
            $numArr  = ['', '壹', '贰', '叁', '肆', '伍', '陆', '柒', '捌', '玖', '.' => '点'];
            $descArr = ['', '拾', '佰', '仟', '万', '拾', '佰', '仟', '亿', '拾', '佰', '仟', '万亿', '拾', '佰', '仟', '兆', '拾', '佰', '仟'];
            $rmbDescArr = ['角', '分', '厘', '毫'];
        }
        // 整数部分拼接
        $integerRes = '';
        $count = strlen($integer);
        if ($count > max(array_keys($descArr))) {
            throw new Exception('number2chinese() number too large.', 1);
        } else if ($count == 0) {
            $integerRes = '零';
        } else {
            for ($i = 0; $i < $count; $i++) {
                $n = $integer[$i];
                $j = $count - $i - 1;
                $cnZero = $i > 1 && $n !== '0' && $integer[$i - 1] === '0' ? '零' : '';
                $cnNum  = $numArr[$n];
                $cnDesc = ($n == '0' && $j % 4 != 0) || substr($integer, $i - 3, 4) === '0000' ? '' : $descArr[$j];
                if ($i == 0 && $cnNum == '一' && $cnDesc == '十') $cnNum = '';

                $integerRes .=  $cnZero . $cnNum . $cnDesc;
            }
        }
        // 小数部分拼接
        $decimalRes = '';
        $count = strlen($decimal);
        if ($decimal === null) {
            $decimalRes = $isRmb ? '整' : '';
        } else if ($decimal === '0') {
            $decimalRes = '零';
        } else if ($count > max(array_keys($descArr))) {
            throw new Exception('number2chinese() number too large.', 1);
        } else {
            for ($i = 0; $i < $count; $i++) {
                if ($isRmb && $i > count($rmbDescArr) - 1) break;
                $n = $decimal[$i];
                $cnZero = $n === '0' ? '零' : '';
                $cnNum  = $numArr[$n];
                $cnDesc = $rmbDescArr[$i];
                $decimalRes .=  $cnZero . $cnNum . $cnDesc;
            }
        }
        // 拼接结果
        $res = $isRmb ?
            $integerRes . ($decimalRes === '零' ? '元整' : "元$decimalRes"):
            $integerRes . ($decimalRes ==='' ? '' : "点$decimalRes");
        return $res;
    }
}