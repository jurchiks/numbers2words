<?php
namespace js\tools\numbers2words\languages;

use js\tools\numbers2words\exceptions\UnsupportedCurrencyException;
use js\tools\numbers2words\Speller;

/**
 * @internal
 */
final class English extends Language
{
	public function spellMinus(): string
	{
		return 'minus';
	}
	
	public function spellMinorUnitSeparator(): string
	{
		return 'and';
	}
	
	public function spellHundred(int $number, int $groupOfThrees, bool $isDecimalPart, string $currency): string
	{
		static $tens = [
			1 => 'ten',
			2 => 'twenty',
			3 => 'thirty',
			4 => 'forty',
			5 => 'fifty',
			6 => 'sixty',
			7 => 'seventy',
			8 => 'eighty',
			9 => 'ninety',
		];
		static $teens = [
			11 => 'eleven',
			12 => 'twelve',
			13 => 'thirteen',
			14 => 'fourteen',
			15 => 'fifteen',
			16 => 'sixteen',
			17 => 'seventeen',
			18 => 'eighteen',
			19 => 'nineteen',
		];
		static $singles = [
			0 => 'zero',
			1 => 'one',
			2 => 'two',
			3 => 'three',
			4 => 'four',
			5 => 'five',
			6 => 'six',
			7 => 'seven',
			8 => 'eight',
			9 => 'nine',
		];
		
		$text = '';
		
		if ($number >= 100)
		{
			$text .= $singles[intval(substr("$number", 0, 1))] . ' hundred';
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
			return 'million';
		}
		
		if ($type === 'thousand')
		{
			return 'thousand';
		}
		
		return '';
	}
	
	public function getCurrencyNameMajor(int $amount, string $currency): string
	{
		static $names = [
			Speller::CURRENCY_EURO           => ['euro', 'euro'],
			Speller::CURRENCY_BRITISH_POUND  => ['pound', 'pounds'],
			Speller::CURRENCY_LATVIAN_LAT    => ['lat', 'lats'],
			Speller::CURRENCY_LITHUANIAN_LIT => ['litas', 'litai'],
			Speller::CURRENCY_RUSSIAN_ROUBLE => ['ruble', 'rubles'],
			Speller::CURRENCY_US_DOLLAR      => ['dollar', 'dollars'],
			Speller::CURRENCY_PL_ZLOTY       => ['zloty', 'zlote'],
		];
		
		return self::getCurrencyName($names, $amount, $currency);
	}
	
	public function getCurrencyNameMinor(int $amount, string $currency): string
	{
		static $names = [
			Speller::CURRENCY_EURO           => ['cent', 'cents'],
			Speller::CURRENCY_BRITISH_POUND  => ['penny', 'pennies'],
			Speller::CURRENCY_LATVIAN_LAT    => ['santim', 'santims'],
			Speller::CURRENCY_LITHUANIAN_LIT => ['centas', 'centai'],
			Speller::CURRENCY_RUSSIAN_ROUBLE => ['kopek', 'kopeks'],
			Speller::CURRENCY_US_DOLLAR      => ['cent', 'cents'],
			Speller::CURRENCY_PL_ZLOTY       => ['grosz', 'grosze'],
		];
		
		return self::getCurrencyName($names, $amount, $currency);
	}
	
	private static function getCurrencyName(array $names, int $amount, string $currency): string
	{
		$index = (($amount === 1) ? 0 : 1);
		
		return $names[$currency][$index] ?? self::throw(new UnsupportedCurrencyException($currency));
	}
}
