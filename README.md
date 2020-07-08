numbers2words
=============
This library is meant for general-purpose number spelling for use in, e.g. legal documents and bills.

[![License](https://poser.pugx.org/jurchiks/numbers2words/license)](https://packagist.org/packages/jurchiks/numbers2words)
[![Downloads](https://poser.pugx.org/jurchiks/numbers2words/downloads)](https://packagist.org/packages/jurchiks/numbers2words)

Supported languages (ISO 639-1 language codes):
* English (`en`)
* Estonian (`et`)
* Latvian (`lv`)
* Lithuanian (`lt`)
* Russian (`ru`)
* Spanish (`es`)
* Polish (`pl`)

Supported currencies (ISO 4217 currency codes):
* British Pounds (`GBP`)
* Euro (`EUR`)
* Latvian Lats (`LVL`)
* Lithuanian Lits (`LTL`)
* Russian Roubles (`RUR`)
* U.S. Dollars (`USD`)
* Polish Zloty (`PLN`)

#### Installation:

```
composer require jurchiks/numbers2words
```

#### Usage:
```php
use js\tools\numbers2words\Speller;

Speller::spellNumber(123, Speller::LANGUAGE_RUSSIAN);
// output: сто двадцать три
Speller::spellCurrency(123, Speller::LANGUAGE_ENGLISH, Speller::CURRENCY_EURO, false);
// output: one hundred and twenty three euro
Speller::spellCurrency(123, Speller::LANGUAGE_ENGLISH, Speller::CURRENCY_EURO);
// output: one hundred and twenty three euro and 0 cents
Speller::spellCurrency(123.45, Speller::LANGUAGE_ENGLISH, Speller::CURRENCY_EURO, true, true);
// output: one hundred and twenty three euro and forty five cents
Speller::spellCurrencyShort(123.45, Speller::LANGUAGE_ENGLISH, Speller::CURRENCY_EURO);
// output: one hundred and twenty three EUR 45/100
```

##### Twig:

There is also a Twig extension available, which implements filters with names identical to the aforementioned methods:
```
{{ 123 | spellNumber('ru') }}
{{ 123.45 | spellCurrency('en', 'EUR') }}
{{ 123.45 | spellCurrencyShort('en', 'EUR') }}
```

To enable the Twig extension in Symfony, add it in `config/services.yaml` (or its equivalent):
```
services:
    js\tools\numbers2words\Twig\Spell:
        tags: [twig.extension]
```
