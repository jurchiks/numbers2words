<?php
namespace js\tools\numbers2words\languages;

use js\tools\numbers2words\exceptions\InvalidArgumentException;
use js\tools\numbers2words\Speller;

final class Spanish extends Speller
{
	protected $minus = 'menos';
	protected $decimalSeparator = ' con ';
	
	protected function spellHundred($number, $groupOfThrees, $isDecimalPart, $currency)
	{
		static $hundreds = [
			1 => 'ciento',
			2 => 'doscientos',
			3 => 'trescientos',
			4 => 'cuatrocientos',
			5 => 'quinientos',
			6 => 'seiscientos',
			7 => 'setecientos',
			8 => 'ochocientos',
			9 => 'novecientos',
		];
		static $tens = [
			1 => 'diez',
			2 => 'veinte',
			3 => 'treinta',
			4 => 'cuarenta',
			5 => 'cincuenta',
			6 => 'sesenta',
			7 => 'setenta',
			8 => 'ochenta',
			9 => 'noventa',
		];
		static $teens = [
			11 => 'once',
			12 => 'doce',
			13 => 'trece',
			14 => 'catorce',
			15 => 'quince',
			16 => 'dieciséis',
			17 => 'diecisiete',
			18 => 'dieciocho',
			19 => 'diecinueve',
		];
		static $singles = [
			0 => 'cero',
			1 => 'uno',
			2 => 'dos',
			3 => 'tres',
			4 => 'cuatro',
			5 => 'cinco',
			6 => 'seis',
			7 => 'siete',
			8 => 'ocho',
			9 => 'nueve',
		];
		
		if ($number % 100 === 0)
		{
			// just plain one hundred (100) is written differently in Spanish
			// than when used in conjunction with other numbers like 101
			return 'cien';
		}
		
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
			if ($number % 10 === 0) // whole tens
			{
				$text .= $tens[intval(substr($number, 0, 1))];
			}
			else if ($number < 30) // 21-29 is different in Spanish
			{
				$text .= 'veinti' . $singles[$number % 10];
			}
			else
			{
				$text .= $tens[intval(substr($number, 0, 1))]
					. ' y '
					. $singles[$number % 10];
			}
		}
		
		return $text;
	}
	
	protected function spellExponent($type, $number, $currency)
	{
		if ($type === 'million')
		{
			if ($number === 1)
			{
				return 'millón';
			}
			
			return 'millones';
		}
		
		if ($type === 'thousand')
		{
			return 'mil';
		}
		
		return '';
	}
	
	protected function getCurrencyName($type, $number, $currency)
	{
		// TODO some of these spellings are extremely hard to find and are probably incorrect
		static $names = [
			self::CURRENCY_EURO           => [
				'whole'   => ['euro', 'euros'],
				'decimal' => ['centime', 'centimes'],
			],
			self::CURRENCY_BRITISH_POUND  => [
				'whole'   => ['libra esterlina', 'libras esterlinas'],
				'decimal' => ['penique', 'peniques'],
			],
			self::CURRENCY_LATVIAN_LAT    => [
				'whole'   => ['lat', 'lats'],
				'decimal' => ['sentim', 'sentims'],
			],
			self::CURRENCY_LITHUANIAN_LIT => [
				'whole'   => ['litas', 'litas'],
				'decimal' => ['cent', 'cents'],
			],
			self::CURRENCY_RUSSIAN_ROUBLE => [
				'whole'   => ['rublo ruso', 'rublos rusos'],
				'decimal' => ['kopek', 'kopeks'],
			],
			self::CURRENCY_US_DOLLAR      => [
				'whole'   => ['dólar estadounidense', 'dólares estadounidenses'],
				'decimal' => ['centavo', 'centavos'],
			],
			self::CURRENCY_PL_ZLOTY       => [
				'whole'   => ['zloty', 'zlotys'],
				'decimal' => ['centavo', 'centavos'],
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
		else
		{
			$index = 1;
		}
		
		return $names[$currency][$type][$index];
	}
}
