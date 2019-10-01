<?php
namespace js\tools\numbers2words\Twig;

use js\tools\numbers2words\Speller;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class Spell extends AbstractExtension
{
    public function getFilters()
    {
        return [
            new TwigFilter('spellNumber', [$this, 'spellNumber']),
            new TwigFilter('spellCurrencyShort', [$this, 'spellCurrencyShort']),
            new TwigFilter('spellCurrency', [$this, 'spellCurrency']),
        ];
    }

    public function spellNumber($number, $language)
    {
        return Speller::spellNumber($number, $language);
    }

    public function spellCurrencyShort($amount, $language, $currency)
    {
        return Speller::spellCurrencyShort($amount, $language, $currency);
    }

    public function spellCurrency($amount, $language, $currency, $requireDecimal = true, $spellDecimal = false)
    {
        return Speller::spellCurrency($amount, $language, $currency, $requireDecimal, $spellDecimal);
    }
}
