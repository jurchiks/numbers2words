<?php
namespace js\tools\numbers2words\languages;

use js\tools\numbers2words\exceptions\UnsupportedCurrencyException;
use js\tools\numbers2words\Speller;

/**
 * @internal
 */
final class Estonian extends Language
{
	public function spellMinus(): string
	{
		return 'miinus';
	}
	
	public function spellMinorUnitSeparator(): string
	{
		return 'ja';
	}
	
	public function spellHundred(int $number, int $groupOfThrees, bool $isDecimalPart, string $currency): string
	{
		static $tens = [
			1 => 'kümme',
			2 => 'kakskümmend',
			3 => 'kolmkümmend',
			4 => 'nelikümmend',
			5 => 'viiskümmend',
			6 => 'kuuskümmend',
			7 => 'seitsekümmend',
			8 => 'kaheksakümmend',
			9 => 'üheksakümmend',
		];
		static $teens = [
			11 => 'üksteist',
			12 => 'kaksteist',
			13 => 'kolmteist',
			14 => 'neliteist',
			15 => 'viisteist',
			16 => 'kuusteist',
			17 => 'seitseteist',
			18 => 'kaheksateist',
			19 => 'üheksateist',
		];
		static $singles = [
			0 => 'null',
			1 => 'üks',
			2 => 'kaks',
			3 => 'kolm',
			4 => 'neli',
			5 => 'viis',
			6 => 'kuus',
			7 => 'seitse',
			8 => 'kaheksa',
			9 => 'üheksa',
		];
		
		$text = '';
		
		if ($number >= 100)
		{
			$text .= $singles[intval(substr("$number", 0, 1))] . 'sada';
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
			if ($number === 1)
			{
				return 'miljon';
			}
			
			return 'miljonit';
		}
		
		if ($type === 'thousand')
		{
			return 'tuhat';
		}
		
		return '';
	}
	
	public function getCurrencyNameMajor(int $amount, string $currency): string
	{
		static $names = [
			Speller::CURRENCY_EURO           => ['euro', 'eurot'],
			Speller::CURRENCY_BRITISH_POUND  => ['nael', 'naela'],
			Speller::CURRENCY_LATVIAN_LAT    => ['latt', 'latti'],
			Speller::CURRENCY_LITHUANIAN_LIT => ['litt', 'litti'],
			Speller::CURRENCY_RUSSIAN_ROUBLE => ['rubla', 'rubla'],
			Speller::CURRENCY_US_DOLLAR      => ['dollar', 'dollarit'],
			Speller::CURRENCY_PL_ZLOTY       => ['zloty', 'zlote'],
		];
		
		return self::getCurrencyName($names, $amount, $currency);
	}
	
	public function getCurrencyNameMinor(int $amount, string $currency): string
	{
		static $names = [
			Speller::CURRENCY_EURO           => ['sent', 'senti'],
			Speller::CURRENCY_BRITISH_POUND  => ['penn', 'penni'],
			Speller::CURRENCY_LATVIAN_LAT    => ['santiim', 'santiimi'],
			Speller::CURRENCY_LITHUANIAN_LIT => ['sent', 'senti'],
			Speller::CURRENCY_RUSSIAN_ROUBLE => ['kopikas', 'kopikat'],
			Speller::CURRENCY_US_DOLLAR      => ['sent', 'senti'],
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
