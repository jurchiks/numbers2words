<?php
//# custom by: vafrcor <vafrcor2009@gmail.com>

namespace js\tools\numbers2words\languages;

use js\tools\numbers2words\exceptions\InvalidArgumentException;
use js\tools\numbers2words\Speller;

final class Indonesian extends Speller
{
	protected $minus = 'min';
	protected $decimalSeparator = ' dan ';
	
	protected function spellHundred($number, $groupOfThrees, $isDecimalPart, $currency)
	{
		static $tens = array(
			1 => 'sepuluh',
			2 => 'dua puluh',
			3 => 'tiga puluh',
			4 => 'empat puluh',
			5 => 'lima puluh',
			6 => 'enam puluh',
			7 => 'tujuh puluh',
			8 => 'delapan puluh',
			9 => 'sembilan puluh',
		);
		static $teens = array(
			11 => 'sebelas',
			12 => 'dua belas',
			13 => 'tiga belas',
			14 => 'empat belas',
			15 => 'lima belas',
			16 => 'enam belas',
			17 => 'tujuh belas',
			18 => 'delapan belas',
			19 => 'sembilan belas',
		);
		static $singles = array(
			0 => 'nol',
			1 => 'satu',
			2 => 'dua',
			3 => 'tiga',
			4 => 'empat',
			5 => 'lima',
			6 => 'enam',
			7 => 'tujuh',
			8 => 'delapan',
			9 => 'sembilan',
		);
		
		$text = '';
		
		if ($number >= 100)
		{	
			$text .= $singles[intval(substr("$number", 0, 1))] . ' ratus';

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
		if ($type === 'trillion')
		{
			return 'triliun';
		}

		if ($type === 'billion')
		{
			return 'milyar';
		}

		if ($type === 'million')
		{
			return 'juta';
		}
		
		if ($type === 'thousand')
		{
			return 'ribu';
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
			self::CURRENCY_IDR_RUPIAH => array(
				'whole'   => array('rupiah', 'rupiah'),
				'decimal' => array('sen', 'sen'),
			),
		);
		
		if (!isset($names[$currency]))
		{
			throw new InvalidArgumentException('Unsupported currency');
		}
		
		$index = (($number === 1) ? 0 : 1);
		
		return $names[$currency][$type][$index];
	}

	public function customTextFormater($text='')
	{
		$text=str_replace(["satu ratus","satu ribu"], ["seratus", "seribu"], $text);
		return $text;
	}
}
