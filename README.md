numbers2words
=============
This library is meant for general-purpose number spelling for use in, e.g. legal documents and bills.

Currently the supported languages are Latvian ('lv'), Russian ('ru'), English ('en'), Lithuanian ('lt') and Spanish ('es'),
and supported currencies are EUR, LTL, LVL, RUR, USD.

Report issues if you find any!

Usage:
```php
use js\tools\numbers2words\Speller;

Speller::spellNumber(123, 'ru');
// output: сто двадцать три
Speller::spellCurrency(123.45, 'en', 'USD', true, true);
// output: one hundred and twenty three dollars and forty five cents
```
