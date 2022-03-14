<?php
namespace js\tools\numbers2words\languages;

use js\tools\numbers2words\exceptions\UnsupportedCurrencyException;
use js\tools\numbers2words\Speller;

/**
 * @internal
 */
final class Polish extends Language
{
	public function spellMinus(): string
	{
		return 'minus';
	}
	
	public function spellMinorUnitSeparator(): string
	{
		return 'i';
	}
	
	public function spellHundred(int $number, int $groupOfThrees, bool $isDecimalPart, string $currency): string
	{
		static $hundreds = [
			1 => 'sto',
			2 => 'dwieście',
			3 => 'trzysta',
			4 => 'czterysta',
			5 => 'pięćset',
			6 => 'sześćset',
			7 => 'siedemset',
			8 => 'osiemset',
			9 => 'dziewięćset',
		];
		static $tens = [
			1 => 'dziesięć',
			2 => 'dwadzieścia',
			3 => 'trzydzieści',
			4 => 'czterdzieści',
			5 => 'pięćdziesiąt',
			6 => 'sześćdziesiąt',
			7 => 'siedemdziesiąt',
			8 => 'osiemdziesiąt',
			9 => 'dziewięćdziesiąt',
		];
		static $teens = [
			11 => 'jedenaście',
			12 => 'dwanaście',
			13 => 'trzynaście',
			14 => 'czternaście',
			15 => 'pietnaście',
			16 => 'szesnaście',
			17 => 'siedemnaście',
			18 => 'osiemnaście',
			19 => 'dziewiętnaście',
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
			0 => 'zero',
			1 => 'jeden',
			2 => 'dwa',
			3 => 'trzy',
			4 => 'cztery',
			5 => 'pięć',
			6 => 'sześć',
			7 => 'siedem',
			8 => 'osiem',
			9 => 'dziewięć',
		];
		static $singlesFeminine = [
			0 => 'zero',
			1 => 'jedna',
			2 => 'dwie',
			3 => 'trzy',
			4 => 'cztery',
			5 => 'pięć',
			6 => 'sześć',
			7 => 'siedem',
			8 => 'osiem',
			9 => 'dziewięć',
		];
		
		if ($isDecimalPart && ($currency === Speller::CURRENCY_RUSSIAN_ROUBLE)) // russian kopeks
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
			if (($singles === 1) && ($tens !== 11)) // 1, 21, ... 91
			{
				return 'milion';
			}
			
			if ((($singles > 1) && ($singles < 5)) // 2-4, 22-24 ... 92-94
				&& (($tens - $singles) !== 10))
			{
				return 'miliony';
			}
			
			return 'milionów';
		}
		
		if ($type === 'thousand')
		{
			if (($singles === 1) && ($tens !== 11)) // 1, 21, ... 91
			{
				return 'tysiąc';
			}
			
			if ((($singles > 1) && ($singles < 5)) // 2-4, 22-24 ... 92-94
				&& (($tens - $singles) !== 10))
			{
				return 'tysiące';
			}
			
			return 'tysięcy';
		}
		
		return '';
	}
	
	public function getCurrencyNameMajor(int $amount, string $currency): string
	{
		static $names = [
			Speller::CURRENCY_EURO               => ['euro', 'euro', 'euro'],
			Speller::CURRENCY_BRITISH_POUND      => ['funt', 'funty', 'funtów'],
			Speller::CURRENCY_LATVIAN_LAT        => ['łat', 'łaty', 'łatów'],
			Speller::CURRENCY_LITHUANIAN_LIT     => ['lit', 'lity', 'litów'],
			Speller::CURRENCY_RUSSIAN_ROUBLE     => ['rubel', 'ruble', 'rubli'],
			Speller::CURRENCY_US_DOLLAR          => ['dolar', 'dolary', 'dolarów'],
			Speller::CURRENCY_PL_ZLOTY           => ['złoty', 'złote', 'złotych'],
			Speller::CURRENCY_TANZANIAN_SHILLING => ['zyling', 'szylingi', 'szylingów'],
		];
		
		return self::getCurrencyName($names, $amount, $currency);
	}
	
	public function getCurrencyNameMinor(int $amount, string $currency): string
	{
		static $names = [
			Speller::CURRENCY_EURO               => ['cent', 'centy', 'centów'],
			Speller::CURRENCY_BRITISH_POUND      => ['pen', 'peny', 'penów'],
			Speller::CURRENCY_LATVIAN_LAT        => ['santim', 'santimy', 'santimów'],
			Speller::CURRENCY_LITHUANIAN_LIT     => ['cent', 'centy', 'centów'],
			Speller::CURRENCY_RUSSIAN_ROUBLE     => ['kopiejka', 'kopiejki', 'kopiejek'],
			Speller::CURRENCY_US_DOLLAR          => ['cent', 'centy', 'centów'],
			Speller::CURRENCY_PL_ZLOTY           => ['grosz', 'grosze', 'groszy'],
			Speller::CURRENCY_TANZANIAN_SHILLING => ['cent', 'centy', 'centów'],
		];
		
		return self::getCurrencyName($names, $amount, $currency);
	}
	
	private static function getCurrencyName(array $names, int $amount, string $currency): string
	{
		$tens = $amount % 100;
		$singles = $amount % 10;
		
		if (($singles === 1) && ($tens !== 11)) // 1, 21, ... 91
		{
			$index = 0;
		}
		else if ((($singles > 1) && ($singles < 5)) // 2-4, 22-24, ... 92-94
			&& (($tens - $singles) !== 10))
		{
			$index = 1;
		}
		else // 0, 5, 6, 7, 8, 9, 11-19, 10, 20, 30...90
		{
			$index = 2;
		}
		
		return $names[$currency][$index] ?? self::throw(new UnsupportedCurrencyException($currency));
	}
}
