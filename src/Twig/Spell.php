<?php

namespace js\tools\numbers2words\Twig;

use Twig\TwigFilter;
use js\tools\numbers2words\Speller;
use Twig\Extension\AbstractExtension;

class Spell extends AbstractExtension
{
    public function getFilters()
    {
        return [
            new TwigFilter('spellCurrencyShort', [$this, 'spellCurrencyShort']),
        ];
    }

    public function spellCurrencyShort($amount, $language, $currency)
    {
        return Speller::spellCurrencyShort($amount, $language, $currency);
    }
}
