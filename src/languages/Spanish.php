<?php
namespace js\tools\numbers2words\languages;

use js\tools\numbers2words\exceptions\UnsupportedCurrencyException;
use js\tools\numbers2words\Speller;

/**
 * @internal
 */
final class Spanish extends Language
{
	public function spellMinus(): string
	{
		return 'menos';
	}
	
	public function spellMinorUnitSeparator(): string
	{
		return 'con';
	}
	
	public function spellHundred(int $number, int $groupOfThrees, bool $isDecimalPart, string $currency): string
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
		
		if ($number === 100)
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
	
	public function spellExponent(string $type, int $number, string $currency): string
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
	
	public function getCurrencyNameMajor(int $amount, string $currency): string
	{
		// TODO some of these spellings are extremely hard to find and are probably incorrect
		static $names = [
			Speller::CURRENCY_EURO           => ['euro', 'euros'],
			Speller::CURRENCY_BRITISH_POUND  => ['libra esterlina', 'libras esterlinas'],
			Speller::CURRENCY_LATVIAN_LAT    => ['lat', 'lats'],
			Speller::CURRENCY_LITHUANIAN_LIT => ['litas', 'litas'],
			Speller::CURRENCY_RUSSIAN_ROUBLE => ['rublo ruso', 'rublos rusos'],
			Speller::CURRENCY_US_DOLLAR      => ['dólar estadounidense', 'dólares estadounidenses'],
			Speller::CURRENCY_PL_ZLOTY       => ['zloty', 'zlotys'],
		];
		
		return self::getCurrencyName($names, $amount, $currency);
	}
	
	public function getCurrencyNameMinor(int $amount, string $currency): string
	{
		static $names = [
			Speller::CURRENCY_EURO           => ['centime', 'centimes'],
			Speller::CURRENCY_BRITISH_POUND  => ['penique', 'peniques'],
			Speller::CURRENCY_LATVIAN_LAT    => ['sentim', 'sentims'],
			Speller::CURRENCY_LITHUANIAN_LIT => ['cent', 'cents'],
			Speller::CURRENCY_RUSSIAN_ROUBLE => ['kopek', 'kopeks'],
			Speller::CURRENCY_US_DOLLAR      => ['centavo', 'centavos'],
			Speller::CURRENCY_PL_ZLOTY       => ['grosz', 'grosze'],
		];
		
		return self::getCurrencyName($names, $amount, $currency);
	}
	
	private static function getCurrencyName(array $names, int $amount, string $currency): string
	{
		$tens = $amount % 100;
		$singles = $amount % 10;
		
		$index = ((($singles === 1) && ($tens !== 11)) ? 0 : 1);
		
		return $names[$currency][$index] ?? self::throw(new UnsupportedCurrencyException($currency));
	}
}
