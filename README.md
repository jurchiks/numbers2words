numbers2words
=============
This class is meant for general-purpose number to word conversion for use in, e.g. some documents.
Currently the supported languages include Latvian ('lv'), Russian ('ru'), English ('ru'), Lithuanian ('lt') and Spanish ('es').

Usage:
```php
$amount = 123.45;
$language = 'en';
numbers2words::convert($amount, $language);
```
