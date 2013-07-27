<?php
require 'NumberConversion.php';

$number = 123456.78;

echo NumberConversion::numberToWords($number, 'lv'), "\n";
echo NumberConversion::numberToWords($number, 'ru'), "\n";
echo NumberConversion::numberToWords($number, 'en'), "\n";
echo NumberConversion::numberToWords($number, 'lt'), "\n";
echo NumberConversion::numberToWords($number, 'es'), "\n";
