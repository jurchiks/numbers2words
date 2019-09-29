<?php
namespace js\tools\numbers2words\languages;

use js\tools\numbers2words\exceptions\InvalidArgumentException;
use js\tools\numbers2words\Speller;

final class English extends Speller
{
	protected $minus = 'minus';
	protected $decimalSeparator = ' and ';
	
	protected function spellHundred($number, $groupOfThrees, $isDecimalPart, $currency)
	{
		static $tens = array(
			1 => 'ten',
			2 => 'twenty',
			3 => 'thirty',
			4 => 'forty',
			5 => 'fifty',
			6 => 'sixty',
			7 => 'seventy',
			8 => 'eighty',
			9 => 'ninety',
		);
		static $teens = array(
			11 => 'eleven',
			12 => 'twelve',
			13 => 'thirteen',
			14 => 'fourteen',
			15 => 'fifteen',
			16 => 'sixteen',
			17 => 'seventeen',
			18 => 'eighteen',
			19 => 'nineteen',
		);
		static $singles = array(
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
				'decimal' => array('cent', 'cents'),
			),
			self::CURRENCY_BRITISH_POUND => array(
				'whole'   => array('pound', 'pounds'),
				'decimal' => array('penny', 'pennies'),
			),
			self::CURRENCY_LATVIAN_LAT => array(
				'whole'   => array('lat', 'lats'),
				'decimal' => array('santim', 'santims'),
			),
			self::CURRENCY_LITHUANIAN_LIT => array(
				'whole'   => array('litas', 'litai'),
				'decimal' => array('centas', 'centai'),
			),
			self::CURRENCY_RUSSIAN_ROUBLE => array(
				'whole'   => array('ruble', 'rubles'),
				'decimal' => array('kopek', 'kopeks'),
			),
			self::CURRENCY_US_DOLLAR => array(
				'whole'   => array('dollar', 'dollars'),
				'decimal' => array('cent', 'cents'),
			),
			self::CURRENCY_PL_ZLOTY => array(
				'whole'   => array('zloty', 'zlote'),
				'decimal' => array('grosz', 'grosze'),
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
