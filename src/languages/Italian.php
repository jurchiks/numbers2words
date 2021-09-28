<?php
namespace js\tools\numbers2words\languages;

use js\tools\numbers2words\exceptions\UnsupportedCurrencyException;
use js\tools\numbers2words\Speller;

/**
 * @internal
 */
final class Italian extends Language
{
	public function spellMinus(): string
	{
		return 'meno';
	}
	
	public function spellMinorUnitSeparator(): string
	{
		return 'e';
	}
	
	public function spellHundred(int $number, int $groupOfThrees, bool $isDecimalPart, string $currency): string
	{
		static $tens = [
			1 => 'dieci',
			2 => 'venti',
			3 => 'trenta',
			4 => 'quaranta',
			5 => 'cinquanta',
			6 => 'sessanta',
			7 => 'settanta',
			8 => 'ottonta',
			9 => 'novanta',
		];
		static $teens = [
			11 => 'undici',
			12 => 'dodici',
			13 => 'tredici',
			14 => 'quattordici',
			15 => 'quindici',
			16 => 'sedici',
			17 => 'diciassette',
			18 => 'diciotto',
			19 => 'diciannove',
		];
		static $singles = [
			0 => 'zero',
			1 => 'uno',
			2 => 'due',
			3 => 'tre',
			4 => 'quattro',
			5 => 'cinque',
			6 => 'sei',
			7 => 'sette',
			8 => 'otto',
			9 => 'nove',
		];
		
		$text = '';

		if ($number >= 100)
		{
		    $index_singles = intval(substr("$number", 0, 1));
		    if($index_singles == 1){
                $text .= 'cento';
            }
		    else {
                $text .= $singles[$index_singles] . ' cento';
            }

			$number = $number % 100;
			
			if ($number === 0) // exact hundreds
			{
				return $text;
			}
			
			$text .= ' ';
		}
		
		if ($number < 10)
		{
			$text .= $singles[$number];
		}
		else if (($number > 10) && ($number < 20))
		{
			$text .= $teens[$number];
		}
		else
		{
			$text .= $tens[intval(substr("$number", 0, 1))];
			
			if ($number % 10 > 0)
			{
				$text .= ' ' . $singles[$number % 10];
			}
		}
		
		return $text;
	}
	
	public function spellExponent(string $type, int $number, string $currency): string
	{
		if ($type === 'million')
		{
            if($number == 1) return '*milione*'; //for replacement purposes
            return 'milioni';
		}
		
		if ($type === 'thousand')
		{
		    if($number == 1) return '*mille*'; //for replacement purposes
			return 'mila';
		}
		
		return '';
	}
	
	public function getCurrencyNameMajor(int $amount, string $currency): string
	{
		static $names = [
			Speller::CURRENCY_EURO           => ['euro', 'euro'],
			//Speller::CURRENCY_BRITISH_POUND  => ['pound', 'pounds'],
			//Speller::CURRENCY_LATVIAN_LAT    => ['lat', 'lats'],
			//Speller::CURRENCY_LITHUANIAN_LIT => ['litas', 'litai'],
			//Speller::CURRENCY_RUSSIAN_ROUBLE => ['ruble', 'rubles'],
			//Speller::CURRENCY_US_DOLLAR      => ['dollar', 'dollars'],
			//Speller::CURRENCY_PL_ZLOTY       => ['zloty', 'zlote'],
		];
		
		return self::getCurrencyName($names, $amount, $currency);
	}
	
	public function getCurrencyNameMinor(int $amount, string $currency): string
	{
		static $names = [
			Speller::CURRENCY_EURO           => ['cent', 'cents'],
			//Speller::CURRENCY_BRITISH_POUND  => ['penny', 'pennies'],
			//Speller::CURRENCY_LATVIAN_LAT    => ['santim', 'santims'],
			//Speller::CURRENCY_LITHUANIAN_LIT => ['centas', 'centai'],
			//Speller::CURRENCY_RUSSIAN_ROUBLE => ['kopek', 'kopeks'],
			//Speller::CURRENCY_US_DOLLAR      => ['cent', 'cents'],
			//Speller::CURRENCY_PL_ZLOTY       => ['grosz', 'grosze'],
		];
		
		return self::getCurrencyName($names, $amount, $currency);
	}
	
	private static function getCurrencyName(array $names, int $amount, string $currency): string
	{
		$index = (($amount === 1) ? 0 : 1);
		
		return $names[$currency][$index] ?? self::throw(new UnsupportedCurrencyException($currency));
	}
}
