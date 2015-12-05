numbers2words
=============
This library is meant for general-purpose number spelling for use in, e.g. legal documents and bills.

Supported languages (ISO 639-1 language codes):
* English ('en')
* Estonian ('et')
* Latvian ('lv')
* Lithuanian ('lt')
* Russian ('ru')
* Spanish ('es')

Supported currencies (ISO 4217 currency codes):
* British Pounds ('GBP')
* Euro ('EUR')
* Latvian Lats ('LVL')
* Lithuanian Lits ('LTL')
* Russian Roubles ('RUR')
* U.S. Dollars ('USD')

Report issues if you find any!

Usage:
```php
use js\tools\numbers2words\Speller;

Speller::spellNumber(123, Speller::LANGUAGE_RU);
// output: сто двадцать три
Speller::spellCurrency(123.45, Speller::LANGUAGE_ENGLISH, Speller::CURRENCY_EURO, true, true);
// output: one hundred and twenty three euro and forty five cents
```
