<?php
namespace js\tools\numbers2words\languages;
use js\tools\numbers2words\exceptions\InvalidArgumentException;
use js\tools\numbers2words\Speller;
final class English extends Speller
{
	protected $minus = 'minus';
	protected $decimalSeparator = ' i ';
	
	protected function spellHundred($number, $groupOfThrees, $isDecimalPart, $currency)
	{
		static $tens = array(
			1 => 'dziesięć',
			2 => 'dwadzieścia',
			3 => 'trzydzieści',
			4 => 'czterdzieści',
			5 => 'pięćdziesiąt',
			6 => 'sześćdziesiąt',
			7 => 'siedemdziesiąt',
			8 => 'osiemdziesiąt',
			9 => 'dziewięćdziesiąt',
		);
		static $teens = array(
			11 => 'jedenaście',
			12 => 'dwanaście',
			13 => 'trzynaście',
			14 => 'czternaście',
			15 => 'pietnaście',
			16 => 'szesnaście',
			17 => 'siedemnaście',
			18 => 'osiemnaście',
			19 => 'dziewiętnaście',
		);
		static $singles = array(
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
		);
		
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
			$text .= $singles[intval($number)];
		}
		else if (($number > 10) && ($number < 20))
		{
			$text .= $teens[intval($number)];
		}
		else
		{
			$text .= $tens[intval(substr("$number", 0, 1))];
			
			if ($number % 10 > 0) // twenty five
			{
				$text .= ' ' . $singles[$number % 10];
			}
		}
		
		return $text;
	}
	
	protected function spellExponent($type, $number, $currency)
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
	
	protected function getCurrencyName($type, $number, $currency)
	{
		static $names = array(
			self::CURRENCY_EURO => array(
				'whole'   => array('euro', 'euro'),
				'decimal' => array('cent', 'centy', 'centów'),
			),
			self::CURRENCY_BRITISH_POUND => array(
				'whole'   => array('funt', 'funty', 'funtów'),
				'decimal' => array('pen', 'peny', 'penów'),
			),
			self::CURRENCY_LATVIAN_LAT => array(
				'whole'   => array('łat', 'łaty', 'łatów'),
				'decimal' => array('santim', 'santimy', 'satimów'),
			),
			self::CURRENCY_LITHUANIAN_LIT => array(
				'whole'   => array('lit', 'lity', 'litów'),
				'decimal' => array('cent', 'centy', 'centów'),
			),
			self::CURRENCY_RUSSIAN_ROUBLE => array(
				'whole'   => array('rubel', 'ruble', 'rubli'),
				'decimal' => array('kopiejka', 'kopiejki', 'kopiejek'),
			),
			self::CURRENCY_US_DOLLAR => array(
				'whole'   => array('dolar', 'dolary', 'dolarów'),
				'decimal' => array('cent', 'centy', 'centów'),
			),
			self::CURRENCY_PL_ZLOTY => array(
				'whole'   => array('złoty', 'złote', 'złotych'),
				'decimal' => array('grosz', 'grosze', 'groszy'),
			),      
		);
		
		if (!isset($names[$currency]))
		{
			throw new InvalidArgumentException('Unsupported currency');
		}
		
		$index = (($number === 1) ? 0 : 1);
		
		return $names[$currency][$type][$index];
	}
}
