<?php
namespace js\tools\numbers2words\languages;

use js\tools\numbers2words\exceptions\InvalidArgumentException;
use js\tools\numbers2words\Speller;

final class Estonian extends Speller
{
	protected $minus = 'miinus';
	protected $decimalSeparator = ' ja ';
	
	protected function spellHundred(int $number, int $groupOfThrees, bool $isDecimalPart, string $currency): string
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
	
	protected function spellExponent(string $type, int $number, string $currency): string
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
	
	protected function getCurrencyNameMajor(int $amount, string $currency): string
	{
		static $names = [
			self::CURRENCY_EURO           => ['euro', 'eurot'],
			self::CURRENCY_BRITISH_POUND  => ['nael', 'naela'],
			self::CURRENCY_LATVIAN_LAT    => ['latt', 'latti'],
			self::CURRENCY_LITHUANIAN_LIT => ['litt', 'litti'],
			self::CURRENCY_RUSSIAN_ROUBLE => ['rubla', 'rubla'],
			self::CURRENCY_US_DOLLAR      => ['dollar', 'dollarit'],
			self::CURRENCY_PL_ZLOTY       => ['zloty', 'zlote'],
		];
		
		return self::getCurrencyName($names, $amount, $currency);
	}
	
	protected function getCurrencyNameMinor(int $amount, string $currency): string
	{
		static $names = [
			self::CURRENCY_EURO           => ['sent', 'senti'],
			self::CURRENCY_BRITISH_POUND  => ['penn', 'penni'],
			self::CURRENCY_LATVIAN_LAT    => ['santiim', 'santiimi'],
			self::CURRENCY_LITHUANIAN_LIT => ['sent', 'senti'],
			self::CURRENCY_RUSSIAN_ROUBLE => ['kopikas', 'kopikat'],
			self::CURRENCY_US_DOLLAR      => ['sent', 'senti'],
			self::CURRENCY_PL_ZLOTY       => ['grosz', 'grosze'],
		];
		
		return self::getCurrencyName($names, $amount, $currency);
	}
	
	private static function getCurrencyName(array $names, int $amount, string $currency): string
	{
		$index = (($amount === 1) ? 0 : 1);
		
		return $names[$currency][$index] ?? self::throw(new InvalidArgumentException('Unsupported currency'));
	}
}
