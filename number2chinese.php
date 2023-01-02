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

    /**
     * number2chinese description
     *
     * · 个，十，百，千，万，十万，百万，千万，亿，十亿，百亿，千亿，万亿，十万亿，
     *   百万亿，千万亿，兆；此函数亿乘以亿为兆
     *
     * · 以「十」开头，如十五，十万，十亿等。两位数以上，在数字中部出现，则用「一十几」，
     *   如一百一十，一千零一十，一万零一十等
     *
     * · 「二」和「两」的问题。两亿，两万，两千，两百，都可以，但是20只能是二十，
     *   200用二百也更好。22,2222,2222是「二十二亿两千二百二十二万两千二百二十二」
     *
     * · 关于「零」和「〇」的问题，数字中一律用「零」，只有页码、年代等编号中数的空位
     *   才能用「〇」。数位中间无论多少个0，都读成一个「零」。2014是「两千零一十四」，
     *   20014是「二十万零一十四」，201400是「二十万零一千四百」
     *
     * 参考：https://jingyan.baidu.com/article/636f38bb3cfc88d6b946104b.html
     *
     * 人民币写法参考：[正确填写票据和结算凭证的基本规定](http://bbs.chinaacc.com/forum-2-35/topic-1181907.html)
     *
     * @param  mixed  $number
     * @param  boolean $isRmb
     * @return string
     */
    function number2chinese($number, $isRmb = false)
    {
        // 判断正确数字
        if (!preg_match('/^-?\d+(\.\d+)?$/', $number)) {
            throw new Exception('number2chinese() wrong number', 1);
        }
        list($integer, $decimal) = explode('.', $number . '.0');

        // 检测是否为负数
        $symbol = '';
        if (substr($integer, 0, 1) == '-') {
            $symbol = '负';
            $integer = substr($integer, 1);
        }
        if (preg_match('/^-?\d+$/', $number)) {
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
                $n = $integer[$i];      // 位上的数
                $j = $count - $i - 1;   // 单位数组 $descArr 的第几位
                // 零零的读法
                $isLing = $i > 1                    // 去除首位
                    && $n !== '0'                   // 本位数字不是零
                    && $integer[$i - 1] === '0';    // 上一位是零
                $cnZero = $isLing ? '零': '';
                $cnNum  = $numArr[$n];
                // 单位读法
                $isEmptyDanwei = ($n == '0' && $j % 4 != 0)     // 是零且一断位上
                    || substr($integer, $i - 3, 4) === '0000';  // 四个连续0
                $descMark = isset($cnDesc) ? $cnDesc : '';
                $cnDesc = $isEmptyDanwei ? '' : $descArr[$j];
                // 第一位是一十
                if ($i == 0 && $cnNum == '一' && $cnDesc == '十') $cnNum = '';
                // 二两的读法
                $isChangeEr = $n > 1 && $cnNum == '二'       // 去除首位
                    && !in_array($cnDesc, ['', '十', '百'])  // 不读两\两十\两百
                    && $descMark !== '十';                   // 不读十两
                if ($isChangeEr ) $cnNum = '两';
                $integerRes .=  $cnZero . $cnNum . $cnDesc;
            }
        }

        // 小数部分拼接
        $decimalRes = '';
        $count = strlen($decimal);
        if ($decimal === null) {
            $decimalRes = $isRmb ? '整' : '';
        } else if ($decimal === '0') {
            $decimalRes = $isRmb ? '' : '零';
        } else if ($count > max(array_keys($descArr))) {
            throw new Exception('number2chinese() number too large.', 1);
        } else {
            for ($i = 0; $i < $count; $i++) {
                if ($isRmb && $i > count($rmbDescArr) - 1) break;
                $n = $decimal[$i];
                if (!$isRmb) {
                    $cnZero = $n === '0' ? '零' : '';
                    $cnNum  = $numArr[$n];
                    $cnDesc = '';
                    $decimalRes .=  $cnZero . $cnNum . $cnDesc;
                } else {
                    // 零零的读法
                    $isLing = $i > 0                        // 去除首位
                        && $n !== '0'                       // 本位数字不是零
                        && $decimal[$i - 1] === '0';        // 上一位是零
                    $cnZero = $isLing ? '零' : '';
                    $cnNum  = $numArr[$n];
                    $cnDesc = $cnNum ? $rmbDescArr[$i] : '';
                    $decimalRes .=  $cnZero . $cnNum . $cnDesc;
                }
            }
        }
        // 拼接结果
        $res = $symbol . (
            $isRmb
            ? $integerRes . ($decimalRes === '' ? '元整' : "元$decimalRes")
            : $integerRes . ($decimalRes ==='' ? '' : "点$decimalRes")
        );
        return $res;
    }
}
