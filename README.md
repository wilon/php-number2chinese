# PHP number2chinese

[![Packagist][badge_package]][link-packagist]
[![Packagist Release][badge_release]][link-packagist]
[![Packagist Downloads][badge_downloads]][link-packagist]

[badge_package]:      https://img.shields.io/badge/package-wilon/php--number2chinese-blue.svg?style=flat-square
[badge_release]:      https://img.shields.io/packagist/v/wilon/php-number2chinese.svg?style=flat-square
[badge_downloads]:    https://img.shields.io/packagist/dt/wilon/php-number2chinese.svg?style=flat-square
[link-packagist]:     https://packagist.org/packages/wilon/php-number2chinese

PHP 数字转为汉字描述，人民币大写方法。

### 安装

> *php -v >= 5.4*

在 `composer.json` 文件中添加

```json
"wilon/php-number2chinese": "~1.0"
```

或者

```sh
composer require wilon/php-number2chinese
```

### 使用方法

> #string number2chinese ( mixed $number [, bollen $isRmb] )#

*将$number转为汉字念法*

* mixed $number

    输入数字或字符串。
    当数字过大或过小时，请输入string

* bollen $isRmb

    默认为false，当为true时返回人民币大写汉字
    人民币最大单位[仟兆]，最小单位[毫]

### 代码示例

```php
$num1 = 0.1234567890;
echo number2chinese($num1);    // 零点一二三四五六七八九
echo number2chinese($num1, true);    // 零元壹角贰分叁厘肆毫
$num2 = 20000000000000000;
echo number2chinese($num2);    // 二兆
echo number2chinese($num2, true);    // 贰兆元整
```

当数字过大时，请输入string
```php
$num2 = 1234567890.0123456789;
echo number2chinese($num2);    // 十二亿三千四百五十六万七千八百九十点零一二三
echo number2chinese($num2, true);    // 壹拾贰亿叁仟肆佰伍拾陆万柒仟捌佰玖拾元壹分贰厘叁毫
$num2 = '1234567890.0123456789';
echo number2chinese($num2);    // 十二亿三千四百五十六万七千八百九十点零一二三四五六七八九
echo number2chinese($num2, true);    // 壹拾贰亿叁仟肆佰伍拾陆万柒仟捌佰玖拾元壹分贰厘叁毫
```

 若想精确小数点后两位，请先处理$num1
```php
$num1 = 0.1234567890;
echo number2chinese(number_format($num1, 2));    // 零点一二
echo number2chinese(number_format($num1, 2), true);    // 零元壹角贰分
```

### 测试

```
php vendor/wilon/php-number2chinese/test.php    // 随机一些数据进行测试
php vendor/wilon/php-number2chinese/test.php 2000   // 指定数字
```

______
有问题？<a href="https://github.com/wilon/php-number2chinese/issues" target="_blank">发issues</a>
