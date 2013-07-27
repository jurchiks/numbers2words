numbers2words
=============
This class is meant for general-purpose number to word conversion for use in, e.g. some documents.
Currently the supported languages include Latvian ('lv'), Russian ('ru'), English ('ru'), Lithuanian ('lt') and Spanish ('es').
The class doesn't have a method for outputting correct currency names, that's in the TODO list.

Usage:
```php
$amount = 123.45;
$language = 'en';
$currency = 'USD';
NumberConversion::numberToWords($amount, $language, $currency);
// output: one hundred and twenty three dollars and forty five cents
```
