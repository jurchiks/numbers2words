<?php

namespace js\tools\numbers2words\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use js\tools\numbers2words\Speller;

class Spell extends \Twig\Extension\AbstractExtension
{
    public function getFilters()
    {
        return [
            new TwigFilter('spell', [$this, 'spellCurrency']),
        ];
    }

    public function spellCurrency($amount, $language, $currency, $requireDecimal = true, $spellDecimal = false, $currencyAsCode = false)
    {
        return Speller::spellCurrency($amount, $language, $currency, $requireDecimal, $spellDecimal, $currencyAsCode);
    }
}