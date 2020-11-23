<?php
namespace js\tools\numbers2words\languages;

use js\tools\numbers2words\exceptions\InvalidArgumentException;
use js\tools\numbers2words\Speller;

final class Polish extends Speller
{
	protected $minus = 'minus';
	protected $decimalSeparator = ' i ';
	
	protected function spellHundred($number, $groupOfThrees, $isDecimalPart, $currency)
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
			$text .= $this->spellSingle($number, $groupOfThrees, $isDecimalPart, $currency);
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
				$text .= ' ' . $this->spellSingle($number % 10, $groupOfThrees, $isDecimalPart, $currency);
			}
		}
		
		return $text;
	}
	
	private function spellSingle($digit, $groupOfThrees, $isDecimalPart, $currency)
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
		
		if ($isDecimalPart && ($currency === self::CURRENCY_RUSSIAN_ROUBLE)) // russian kopeks
		{
			return $singlesFeminine[intval($digit)];
		}
		
		return $singlesMasculine[intval($digit)];
	}
	
	protected function spellExponent($type, $number, $currency)
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
	
	protected function getCurrencyName($type, $number, $currency)
	{
		static $names = [
			self::CURRENCY_EURO           => [
				'whole'   => ['euro', 'euro', 'euro'],
				'decimal' => ['cent', 'centy', 'centów'],
			],
			self::CURRENCY_BRITISH_POUND  => [
				'whole'   => ['funt', 'funty', 'funtów'],
				'decimal' => ['pen', 'peny', 'penów'],
			],
			self::CURRENCY_LATVIAN_LAT    => [
				'whole'   => ['łat', 'łaty', 'łatów'],
				'decimal' => ['santim', 'santimy', 'santimów'],
			],
			self::CURRENCY_LITHUANIAN_LIT => [
				'whole'   => ['lit', 'lity', 'litów'],
				'decimal' => ['cent', 'centy', 'centów'],
			],
			self::CURRENCY_RUSSIAN_ROUBLE => [
				'whole'   => ['rubel', 'ruble', 'rubli'],
				'decimal' => ['kopiejka', 'kopiejki', 'kopiejek'],
			],
			self::CURRENCY_US_DOLLAR      => [
				'whole'   => ['dolar', 'dolary', 'dolarów'],
				'decimal' => ['cent', 'centy', 'centów'],
			],
			self::CURRENCY_PL_ZLOTY       => [
				'whole'   => ['złoty', 'złote', 'złotych'],
				'decimal' => ['grosz', 'grosze', 'groszy'],
			],
		];
		
		if (!isset($names[$currency]))
		{
			throw new InvalidArgumentException('Unsupported currency');
		}
		
		$tens = $number % 100;
		$singles = $number % 10;
		
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
		
		return $names[$currency][$type][$index];
	}
}
