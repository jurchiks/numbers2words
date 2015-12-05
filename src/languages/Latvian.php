<?php
namespace js\tools\numbers2words\languages;

use js\tools\numbers2words\Speller;

final class Latvian extends Speller
{
	protected $minus = 'mīnus';
	protected $decimalSeparator = ' un ';
	
	protected function spellHundred($number, $groupOfThrees, $isDecimalPart, $currency)
	{
		static $hundreds = array(
			1 => 'viens simts',
			2 => 'divi simti',
			3 => 'trīs simti',
			4 => 'četri simti',
			5 => 'pieci simti',
			6 => 'seši simti',
			7 => 'septiņi simti',
			8 => 'astoņi simti',
			9 => 'deviņi simti',
		);
		static $teens = array(
			11 => 'vienpadsmit',
			12 => 'divpadsmit',
			13 => 'trīspadsmit',
			14 => 'četrpadsmit',
			15 => 'piecpadsmit',
			16 => 'sešpadsmit',
			17 => 'septiņpadsmit',
			18 => 'astoņpadsmit',
			19 => 'deviņpadsmit',
		);
		static $tens = array(
			1 => 'desmit',
			2 => 'divdesmit',
			3 => 'trīsdesmit',
			4 => 'četrdesmit',
			5 => 'piecdesmit',
			6 => 'sešdesmit',
			7 => 'septiņdesmit',
			8 => 'astoņdesmit',
			9 => 'deviņdesmit',
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
			$text .= $this->spellSingle($number, $isDecimalPart, $currency);
		}
		else if (($number > 10) && ($number < 20))
		{
			$text .= $teens[$number];
		}
		else
		{
			$text .= $tens[intval(substr($number, 0, 1))];
			
			if ($number % 10 > 0) // whole tens
			{
				$text .= ' ' . $this->spellSingle($number % 10, $isDecimalPart, $currency);
			}
		}
		
		return $text;
	}
	
	private function spellSingle($digit, $isDecimalPart, $currency)
	{
		static $singlesMasculine = array(
			0 => 'nulle',
			1 => 'viens',
			2 => 'divi',
			3 => 'trīs',
			4 => 'četri',
			5 => 'pieci',
			6 => 'seši',
			7 => 'septiņi',
			8 => 'astoņi',
			9 => 'deviņi',
		);
		static $singlesFeminine = array(
			1 => 'viena',
			2 => 'divas',
			3 => 'trīs',
			4 => 'četras',
			5 => 'piecas',
			6 => 'sešas',
			7 => 'septiņas',
			8 => 'astoņas',
			9 => 'deviņas',
		);
		
		if ($isDecimalPart && ($currency === self::CURRENCY_RUSSIAN_ROUBLE))
		{
			// russian kopek nouns are feminine gender in Latvian
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
			if (($singles === 1) && ($tens !== 11))
			{
				return 'miljons';
			}
			
			return 'miljoni';
		}
		
		if ($type === 'thousand')
		{
			if (($singles === 1) && ($tens !== 11))
			{
				return 'tūkstotis';
			}
			
			return 'tūkstoši';
		}
		
		return '';
	}
	
	protected function getCurrencyName($type, $number, $currency)
	{
		static $names = array(
			self::CURRENCY_EURO => array(
				'whole'   => array('eiro', 'eiro', 'eiro'),
				'decimal' => array('cents', 'centi', 'centu'),
			),
			self::CURRENCY_BRITISH_POUND => array(
				'whole'   => array('mārciņa', 'mārciņas', 'mārciņu'),
				'decimal' => array('penijs', 'peniji', 'peniju'),
			),
			self::CURRENCY_LATVIAN_LAT => array(
				'whole'   => array('lats', 'lati', 'latu'),
				'decimal' => array('santīms', 'santīmi', 'santīmu'),
			),
			self::CURRENCY_LITHUANIAN_LIT => array(
				'whole'   => array('lits', 'liti', 'litu'),
				'decimal' => array('cents', 'centi', 'centu'),
			),
			self::CURRENCY_RUSSIAN_ROUBLE => array(
				'whole'   => array('rublis', 'rubļi', 'rubļu'),
				'decimal' => array('kapeika', 'kapeikas', 'kapeiku'),
			),
			self::CURRENCY_US_DOLLAR => array(
				'whole'   => array('dolārs', 'dolāri', 'dolāru'),
				'decimal' => array('cents', 'centi', 'centu'),
			),
		);
		
		if (!isset($names[$currency]))
		{
			throw new \InvalidArgumentException('Unsupported currency');
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
