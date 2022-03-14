<?php
namespace js\tools\numbers2words\languages;

use js\tools\numbers2words\exceptions\UnsupportedCurrencyException;
use js\tools\numbers2words\Speller;

/**
 * @internal
 */
final class Latvian extends Language
{
	public function spellMinus(): string
	{
		return 'mīnus';
	}
	
	public function spellMinorUnitSeparator(): string
	{
		return 'un';
	}
	
	public function spellHundred(int $number, int $groupOfThrees, bool $isDecimalPart, string $currency): string
	{
		static $hundreds = [
			1 => 'viens simts',
			2 => 'divi simti',
			3 => 'trīs simti',
			4 => 'četri simti',
			5 => 'pieci simti',
			6 => 'seši simti',
			7 => 'septiņi simti',
			8 => 'astoņi simti',
			9 => 'deviņi simti',
		];
		static $tens = [
			1 => 'desmit',
			2 => 'divdesmit',
			3 => 'trīsdesmit',
			4 => 'četrdesmit',
			5 => 'piecdesmit',
			6 => 'sešdesmit',
			7 => 'septiņdesmit',
			8 => 'astoņdesmit',
			9 => 'deviņdesmit',
		];
		static $teens = [
			11 => 'vienpadsmit',
			12 => 'divpadsmit',
			13 => 'trīspadsmit',
			14 => 'četrpadsmit',
			15 => 'piecpadsmit',
			16 => 'sešpadsmit',
			17 => 'septiņpadsmit',
			18 => 'astoņpadsmit',
			19 => 'deviņpadsmit',
		];
		
		$text = '';
		
		if ($number >= 100)
		{
			$text .= $hundreds[intval(substr("$number", 0, 1))];
			$number = $number % 100;
			
			if ($number === 0) // exact hundreds
			{
				return $text;
			}
			
			$text .= ' ';
		}
		
		if ($number < 10)
		{
			$text .= $this->spellSingle($number, $isDecimalPart, $currency);
		}
		else if (($number > 10) && ($number < 20))
		{
			$text .= $teens[$number];
		}
		else
		{
			$text .= $tens[intval(substr($number, 0, 1))];
			
			if ($number % 10 > 0)
			{
				$text .= ' ' . $this->spellSingle($number % 10, $isDecimalPart, $currency);
			}
		}
		
		return $text;
	}
	
	private function spellSingle(int $digit, bool $isDecimalPart, string $currency): string
	{
		static $singlesMasculine = [
			0 => 'nulle',
			1 => 'viens',
			2 => 'divi',
			3 => 'trīs',
			4 => 'četri',
			5 => 'pieci',
			6 => 'seši',
			7 => 'septiņi',
			8 => 'astoņi',
			9 => 'deviņi',
		];
		static $singlesFeminine = [
			0 => 'nulle',
			1 => 'viena',
			2 => 'divas',
			3 => 'trīs',
			4 => 'četras',
			5 => 'piecas',
			6 => 'sešas',
			7 => 'septiņas',
			8 => 'astoņas',
			9 => 'deviņas',
		];
		
		$feminineCurrencies = [
			Speller::CURRENCY_RUSSIAN_ROUBLE => $isDecimalPart, // Russian kopeks (but not rubles)
			Speller::CURRENCY_BRITISH_POUND  => !$isDecimalPart, // British pounds (but not pennies)
		];
		
		if (!empty($feminineCurrencies[$currency]))
		{
			return $singlesFeminine[$digit];
		}
		
		return $singlesMasculine[$digit];
	}
	
	public function spellExponent(string $type, int $number, string $currency): string
	{
		$tens = $number % 100;
		$singles = $number % 10;
		
		if ($type === 'million')
		{
			if (($singles === 1) && ($tens !== 11))
			{
				return 'miljons';
			}
			
			return 'miljoni';
		}
		
		if ($type === 'thousand')
		{
			if (($singles === 1) && ($tens !== 11))
			{
				return 'tūkstotis';
			}
			
			return 'tūkstoši';
		}
		
		return '';
	}
	
	public function getCurrencyNameMajor(int $amount, string $currency): string
	{
		static $names = [
			Speller::CURRENCY_EURO          	 => ['eiro', 'eiro', 'eiro'],
			Speller::CURRENCY_BRITISH_POUND 	 => ['mārciņa', 'mārciņas', 'mārciņu'],
			Speller::CURRENCY_LATVIAN_LAT   	 => ['lats', 'lati', 'latu'],
			Speller::CURRENCY_LITHUANIAN_LIT	 => ['lits', 'liti', 'litu'],
			Speller::CURRENCY_RUSSIAN_ROUBLE	 => ['rublis', 'rubļi', 'rubļu'],
			Speller::CURRENCY_US_DOLLAR     	 => ['dolārs', 'dolāri', 'dolāru'],
			Speller::CURRENCY_PL_ZLOTY      	 => ['zlots', 'zloti', 'zlotu'],
			Speller::CURRENCY_TANZANIAN_SHILLING => ['šiliņš', 'šiliņi', 'šiliņu'],
		];
		
		return self::getCurrencyName($names, $amount, $currency);
	}
	
	public function getCurrencyNameMinor(int $amount, string $currency): string
	{
		static $names = [
			Speller::CURRENCY_EURO               => ['cents', 'centi', 'centu'],
			Speller::CURRENCY_BRITISH_POUND      => ['penijs', 'peniji', 'peniju'],
			Speller::CURRENCY_LATVIAN_LAT        => ['santīms', 'santīmi', 'santīmu'],
			Speller::CURRENCY_LITHUANIAN_LIT     => ['cents', 'centi', 'centu'],
			Speller::CURRENCY_RUSSIAN_ROUBLE     => ['kapeika', 'kapeikas', 'kapeiku'],
			Speller::CURRENCY_US_DOLLAR          => ['cents', 'centi', 'centu'],
			Speller::CURRENCY_PL_ZLOTY           => ['grosis', 'groši', 'grošu'],
			Speller::CURRENCY_TANZANIAN_SHILLING => ['cents', 'centi', 'centu'],
		];
		
		return self::getCurrencyName($names, $amount, $currency);
	}
	
	private static function getCurrencyName(array $names, int $amount, string $currency): string
	{
		$tens = $amount % 100;
		$singles = $amount % 10;
		
		if (($singles === 1) && ($tens !== 11)) // 1, 21, 31, ... 91
		{
			$index = 0;
		}
		else if (($singles > 1) // 2-9, 22-29, ... 92-99
			&& (($tens - $singles) !== 10))
		{
			$index = 1;
		}
		else // 0, 10, 11-19, 20, 30, ... 90
		{
			$index = 2;
		}
		
		return $names[$currency][$index] ?? self::throw(new UnsupportedCurrencyException($currency));
	}
}
