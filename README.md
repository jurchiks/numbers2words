numbers2words
=============
This class is meant for general-purpose number to word conversion for use in, e.g. legal documents, bills.
Currently the supported languages include Latvian ('lv'), Russian ('ru'), English ('en'), Lithuanian ('lt') and Spanish ('es').

Usage:
```php
NumberConversion::spellNumber(123, 'ru');
// output: сто двадцать три
NumberConversion::spellCurrency(123.45, 'en', 'USD', true, true);
// output: one hundred and twenty three dollars and forty five cents
```
