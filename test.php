<?php
require 'NumberConversion.php';

echo NumberConversion::currencyToWords(123.45, 'lv', 'EUR'), "\n";
echo NumberConversion::currencyToWords(234.56, 'lv', 'USD'), "\n";
echo NumberConversion::currencyToWords(345.67, 'lv', 'LVL'), "\n";
echo NumberConversion::currencyToWords(456.78, 'lv', 'LTL'), "\n";
echo NumberConversion::currencyToWords(567.89, 'lv', 'RUR'), "\n";

echo NumberConversion::currencyToWords(678.90, 'ru', 'EUR'), "\n";
echo NumberConversion::currencyToWords(789.01, 'ru', 'USD'), "\n";
echo NumberConversion::currencyToWords(890.12, 'ru', 'LVL'), "\n";
echo NumberConversion::currencyToWords(901.23, 'ru', 'LTL'), "\n";
echo NumberConversion::currencyToWords(12.34, 'ru', 'RUR'), "\n";
