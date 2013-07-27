numbers2words
=============
This class is meant for general-purpose number to word conversion for use in, e.g. some documents.
Currently the supported languages include Latvian ('lv'), Russian ('ru'), English ('ru'), Lithuanian ('lt') and Spanish ('es').
The class doesn't have a method for outputting correct currency names, that's in the TODO list.

Usage:
```php
NumberConversion::numberToWords(123, 'ru');
// output: сто двадцать три
NumberConversion::currencyToWords(123.45, 'en', 'USD');
// output: one hundred and twenty three dollars and forty five cents
```
