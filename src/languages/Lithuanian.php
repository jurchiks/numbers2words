<?php
namespace js\tools\numbers2words\languages;

use js\tools\numbers2words\exceptions\InvalidArgumentException;
use js\tools\numbers2words\Speller;

final class Lithuanian extends Speller
{
	protected $minus = 'minus';
	protected $decimalSeparator = ' ir ';
	
	protected function spellHundred(int $number, int $groupOfThrees, bool $isDecimalPart, string $currency): string
	{
		static $hundreds = [
			1 => 'vienas šimtas',
			2 => 'du šimtai',
			3 => 'trys šimtai',
			4 => 'keturi šimtai',
			5 => 'penki šimtai',
			6 => 'šeši šimtai',
			7 => 'septyni šimtai',
			8 => 'aštuoni šimtai',
			9 => 'devyni šimtai',
		];
		static $tens = [
			1 => 'dešimt',
			2 => 'dvidešimt',
			3 => 'trisdešimt',
			4 => 'keturiasdešimt',
			5 => 'penkiasdešimt',
			6 => 'šešiasdešimt',
			7 => 'septyniasdešimt',
			8 => 'aštuoniasdešimt',
			9 => 'devyniasdešimt',
		];
		static $teens = [
			11 => 'vienuolika',
			12 => 'dvylika',
			13 => 'trylika',
			14 => 'keturiolika',
			15 => 'penkiolika',
			16 => 'šešiolika',
			17 => 'septyniolika',
			18 => 'aštuoniolika',
			19 => 'devyniolika',
		];
		static $singles = [
			0 => 'nulis',
			1 => 'vienas',
			2 => 'du',
			3 => 'trys',
			4 => 'keturi',
			5 => 'penki',
			6 => 'šeši',
			7 => 'septyni',
			8 => 'aštuoni',
			9 => 'devyni',
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
			$text .= $singles[$number];
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
				$text .= ' ' . $singles[$number % 10];
			}
		}
		
		return $text;
	}
	
	protected function spellExponent(string $type, int $number, string $currency): string
	{
		$tens = $number % 100;
		$singles = $number % 10;
		
		if ($type === 'million')
		{
			if (($singles === 1) && ($tens !== 11))
			{
				return 'milijonas';
			}
			
			return 'milijonai';
		}
		
		if ($type === 'thousand')
		{
			if (($singles === 1) && ($tens !== 11))
			{
				return 'tūkstantis';
			}
			
			return 'tūkstančiai';
		}
		
		return '';
	}
	
	protected function getCurrencyNameMajor(int $amount, string $currency): string
	{
		static $names = [
			self::CURRENCY_EURO           => ['euras', 'eurai', 'eurų'],
			self::CURRENCY_BRITISH_POUND  => ['svaras', 'svarai', 'svarų'],
			self::CURRENCY_LATVIAN_LAT    => ['latas', 'latai', 'latų'],
			self::CURRENCY_LITHUANIAN_LIT => ['litas', 'litai', 'litų'],
			self::CURRENCY_RUSSIAN_ROUBLE => ['rublis', 'rubliai', 'rublių'],
			self::CURRENCY_US_DOLLAR      => ['doleris', 'doleriai', 'dolerių'],
			self::CURRENCY_PL_ZLOTY       => ['zlotas', 'zlotai', 'zlotų'],
		];
		
		return self::getCurrencyName($names, $amount, $currency);
	}
	
	protected function getCurrencyNameMinor(int $amount, string $currency): string
	{
		static $names = [
			self::CURRENCY_EURO           => ['centas', 'centai', 'centų'],
			self::CURRENCY_BRITISH_POUND  => ['pensas', 'pensai', 'pensų'],
			self::CURRENCY_LATVIAN_LAT    => ['santimas', 'santimai', 'santimų'],
			self::CURRENCY_LITHUANIAN_LIT => ['centas', 'centai', 'centų'],
			self::CURRENCY_RUSSIAN_ROUBLE => ['kapeika', 'kapeikos', 'kapeikų'],
			self::CURRENCY_US_DOLLAR      => ['centas', 'centai', 'centų'],
			self::CURRENCY_PL_ZLOTY       => ['grašis', 'grašiai', 'grašių'],
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
		
		return $names[$currency][$index] ?? self::throw(new InvalidArgumentException('Unsupported currency'));
	}
}
