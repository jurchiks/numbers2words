<?php
namespace js\tools\numbers2words\languages;

use js\tools\numbers2words\exceptions\InvalidArgumentException;
use js\tools\numbers2words\Speller;

final class Lithuanian extends Speller
{
	protected $minus = 'minus';
	protected $decimalSeparator = ' ir ';
	
	protected function spellHundred($number, $groupOfThrees, $isDecimalPart, $currency)
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
		else if (($number > 10)
			&& ($number < 20))
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
	
	protected function spellExponent($type, $number, $currency)
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
	
	protected function getCurrencyName($type, $number, $currency)
	{
		static $names = [
			self::CURRENCY_EURO           => [
				'whole'   => ['euras', 'eurai', 'eurų'],
				'decimal' => ['centas', 'centai', 'centų'],
			],
			self::CURRENCY_BRITISH_POUND  => [
				'whole'   => ['svaras', 'svarai', 'svarų'],
				'decimal' => ['pensas', 'pensai', 'pensų'],
			],
			self::CURRENCY_LATVIAN_LAT    => [
				'whole'   => ['latas', 'latai', 'latų'],
				'decimal' => ['santimas', 'santimai', 'santimų'],
			],
			self::CURRENCY_LITHUANIAN_LIT => [
				'whole'   => ['litas', 'litai', 'litų'],
				'decimal' => ['centas', 'centai', 'centų'],
			],
			self::CURRENCY_RUSSIAN_ROUBLE => [
				'whole'   => ['rublis', 'rubliai', 'rublių'],
				'decimal' => ['kapeika', 'kapeikos', 'kapeikų'],
			],
			self::CURRENCY_US_DOLLAR      => [
				'whole'   => ['doleris', 'doleriai', 'dolerių'],
				'decimal' => ['centas', 'centai', 'centų'],
			],
			self::CURRENCY_PL_ZLOTY       => [
				'whole'   => ['zlotas', 'zlotai', 'zlotų'],
				'decimal' => ['grašis', 'grašiai', 'grašių'],
			],
		];
		
		if (!isset($names[$currency]))
		{
			throw new InvalidArgumentException('Unsupported currency');
		}
		
		$tens = $number % 100;
		$singles = $number % 10;
		
		if (($singles === 1) && ($tens !== 11)) // 1, 21, 31, ... 91
		{
			$index = 0;
		}
		else if ((($singles > 1) && ($singles < 10)) // 2-9, 22-29, ... 92-99
			&& (($tens - $singles) !== 10))
		{
			$index = 1;
		}
		else // 0, 10, 100, 1000
		{
			$index = 2;
		}
		
		return $names[$currency][$type][$index];
	}
}
