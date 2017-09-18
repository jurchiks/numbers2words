<?php
namespace js\tools\numbers2words\languages;

use js\tools\numbers2words\exceptions\InvalidArgumentException;
use js\tools\numbers2words\Speller;

final class Russian extends Speller
{
	protected $minus = 'минус';
	protected $decimalSeparator = ' и ';
	
	protected function spellHundred($number, $groupOfThrees, $isDecimalPart, $currency)
	{
		static $hundreds = array(
			1 => 'сто',
			2 => 'двести',
			3 => 'триста',
			4 => 'четыреста',
			5 => 'пятьсот',
			6 => 'шестьсот',
			7 => 'семьсот',
			8 => 'восемьсот',
			9 => 'девятьсот',
		);
		static $tens = array(
			1 => 'десять',
			2 => 'двадцать',
			3 => 'тридцать',
			4 => 'сорок',
			5 => 'пятьдесят',
			6 => 'шестьдесят',
			7 => 'семьдесят',
			8 => 'восемьдесят',
			9 => 'девяносто',
		);
		static $teens = array(
			11 => 'одиннадцать',
			12 => 'двенадцать',
			13 => 'тринадцать',
			14 => 'четырнадцать',
			15 => 'пятнадцать',
			16 => 'шестнадцать',
			17 => 'семнадцать',
			18 => 'восемнадцать',
			19 => 'девятнадцать',
		);
		
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
		static $singlesMasculine = array(
			0 => 'ноль',
			1 => 'один',
			2 => 'два',
			3 => 'три',
			4 => 'четыре',
			5 => 'пять',
			6 => 'шесть',
			7 => 'семь',
			8 => 'восемь',
			9 => 'девять',
		);
		static $singlesFeminine = array(
			0 => 'ноль',
			1 => 'одна',
			2 => 'две',
			3 => 'три',
			4 => 'четыре',
			5 => 'пять',
			6 => 'шесть',
			7 => 'семь',
			8 => 'восемь',
			9 => 'девять',
		);
		
		if (($groupOfThrees === 2) // thousands
			|| ($isDecimalPart && ($currency === self::CURRENCY_RUSSIAN_ROUBLE))) // russian kopeks
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
				return 'миллион';
			}
			
			if ((($singles > 1) && ($singles < 5)) // 2-4, 22-24 ... 92-94
				&& (($tens - $singles) !== 10))
			{
				return 'миллиона';
			}
			
			return 'миллионов';
		}
		
		if ($type === 'thousand')
		{
			if (($singles === 1) && ($tens !== 11)) // 1, 21, ... 91
			{
				return 'тысяча';
			}
			
			if ((($singles > 1) && ($singles < 5)) // 2-4, 22-24 ... 92-94
				&& (($tens - $singles) !== 10))
			{
				return 'тысячи';
			}
			
			return 'тысяч';
		}
		
		return '';
	}
	
	protected function getCurrencyName($type, $number, $currency)
	{
		static $names = array(
			self::CURRENCY_EURO => array(
				'whole'   => array('евро', 'евро', 'евро'),
				'decimal' => array('цент', 'цента', 'центов'),
			),
			self::CURRENCY_BRITISH_POUND => array(
				'whole'   => array('фунт', 'фунта', 'фунтов'),
				'decimal' => array('пенни', 'пенса', 'пенсов'),
			),
			self::CURRENCY_LATVIAN_LAT => array(
				'whole'   => array('лат', 'лата', 'латов'),
				'decimal' => array('сантим', 'сантима', 'сантимов'),
			),
			self::CURRENCY_LITHUANIAN_LIT => array(
				'whole'   => array('лит', 'лита', 'литов'),
				'decimal' => array('цент', 'цента', 'центов'),
			),
			self::CURRENCY_RUSSIAN_ROUBLE => array(
				'whole'   => array('рубль', 'рубля', 'рублей'),
				'decimal' => array('копейка', 'копейки', 'копеек'),
			),
			self::CURRENCY_US_DOLLAR => array(
				'whole'   => array('доллар', 'доллара', 'долларов'),
				'decimal' => array('цент', 'цента', 'центов'),
			),
		);
		
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
