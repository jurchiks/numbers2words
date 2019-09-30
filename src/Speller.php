<?php
namespace js\tools\numbers2words;

use js\tools\numbers2words\exceptions\InvalidArgumentException;

/**
 * This class offers a number spelling in various languages.
 * It is a work-in-progress and more languages are to be added in future.
 * The main and only two public methods are spellNumber() and spellCurrency().
 * @author Juris Sudmalis
 */
abstract class Speller
{
	const LANGUAGE_ENGLISH = 'en';
	const LANGUAGE_ESTONIAN = 'et';
	const LANGUAGE_LATVIAN = 'lv';
	const LANGUAGE_LITHUANIAN = 'lt';
	const LANGUAGE_RUSSIAN = 'ru';
	const LANGUAGE_SPANISH = 'es';
	const LANGUAGE_POLISH = 'pl';
	
	const CURRENCY_EURO = 'EUR';
	const CURRENCY_BRITISH_POUND = 'GBP';
	const CURRENCY_LATVIAN_LAT = 'LVL';
	const CURRENCY_LITHUANIAN_LIT = 'LTL';
	const CURRENCY_RUSSIAN_ROUBLE = 'RUR';
	const CURRENCY_US_DOLLAR = 'USD';
	const CURRENCY_PL_ZLOTY = 'PLN';
	
	private static $languages = array(
		self::LANGUAGE_ENGLISH    => languages\English::class,
		self::LANGUAGE_ESTONIAN   => languages\Estonian::class,
		self::LANGUAGE_LATVIAN    => languages\Latvian::class,
		self::LANGUAGE_LITHUANIAN => languages\Lithuanian::class,
		self::LANGUAGE_RUSSIAN    => languages\Russian::class,
		self::LANGUAGE_SPANISH    => languages\Spanish::class,
		self::LANGUAGE_POLISH    => languages\Polish::class,
	);
	
	private static $currencies = array(
		self::CURRENCY_EURO,
		self::CURRENCY_BRITISH_POUND,
		self::CURRENCY_LATVIAN_LAT,
		self::CURRENCY_LITHUANIAN_LIT,
		self::CURRENCY_RUSSIAN_ROUBLE,
		self::CURRENCY_US_DOLLAR,
		self::CURRENCY_PL_ZLOTY,
	);
	
	protected $minus;
	protected $decimalSeparator;
	
	private final function __construct()
	{
	}
	
	/**
	 * @param string $language : a two-letter, ISO 639-1 code of the language
	 * @return Speller
	 */
	private static function get($language)
	{
		static $spellers = array();
		
		$language = strtolower(trim($language));
		
		if (strlen($language) != 2)
		{
			throw new InvalidArgumentException('Invalid language code specified, must follow ISO 639-1 format.');
		}
		
		if (!isset(self::$languages[$language]))
		{
			throw new InvalidArgumentException('That language is not implemented yet.');
		}
		
		if (!isset($spellers[$language]))
		{
			$spellers[$language] = new self::$languages[$language]();
		}
		
		return $spellers[$language];
	}
	
	public static function getAcceptedLanguages()
	{
		return array_keys(self::$languages);
	}
	
	public static function getAcceptedCurrencies()
	{
		return self::$currencies;
	}
	
	/**
	 * Convert a number into its linguistic representation.
	 * 
	 * @param int $number : the number to spell in the specified language
	 * @param string $language : a two-letter, ISO 639-1 code of the language to spell the number in
	 * @return string : the number as written in words in the specified language
	 * @throws InvalidArgumentException if any parameter is invalid
	 */
	public static function spellNumber($number, $language)
	{
		if (!is_numeric($number))
		{
			throw new InvalidArgumentException('Invalid number specified.');
		}
		
		return self::get($language)
			->parseInt(intval($number), false);
	}
	
	/**
	 * Convert currency to its linguistic short representation.
	 *
	 * @param int|float $amount : the amount to spell in the specified language
	 * @param string $language : a two-letter, ISO 639-1 code of the language to spell the amount in
	 * @param string $currency : a three-letter, ISO 4217 currency code
	 * @return string : the currency as written in words in the specified language with ISO 4217 currency code
	 * @throws InvalidArgumentException if any parameter is invalid
	 */
	public static function spellShort($amount, $language, $currency)
	{
		$amount = is_numeric($amount) ? $amount : 0;
		$amount = number_format($amount, 2, '.', ''); // ensure decimal is always 2 digits
		$currency = strtoupper(trim($currency));
		$parts = explode('.', $amount);
		$speller = self::get($language);
		
		return = trim($speller->parseInt($wholeAmount, false, $currency))
			. ' '
			. $currency 
			. ' '
			. $decimalAmount 
			. '/100';
	}
	
	/**
	 * Convert currency to its linguistic representation.
	 *
	 * @param int|float $amount : the amount to spell in the specified language
	 * @param string $language : a two-letter, ISO 639-1 code of the language to spell the amount in
	 * @param string $currency : a three-letter, ISO 4217 currency code
	 * @param bool $requireDecimal : if true, output decimals even if the value is 0
	 * @param bool $spellDecimal : if true, spell decimals out same as whole numbers;
	 * otherwise, output decimals as numbers
	 * @return string : the currency as written in words in the specified language
	 * @throws InvalidArgumentException if any parameter is invalid
	 */
	public static function spellCurrency($amount, $language, $currency, $requireDecimal = true, $spellDecimal = false)
	{
		if (!is_numeric($amount))
		{
			throw new InvalidArgumentException('Invalid number specified.');
		}
		
		if (!is_string($currency))
		{
			throw new InvalidArgumentException('Invalid currency code specified.');
		}
		
		$currency = strtoupper(trim($currency));
		
		if (!in_array($currency, self::$currencies))
		{
			throw new InvalidArgumentException('That currency is not implemented yet.');
		}
		
		$amount = number_format($amount, 2, '.', ''); // ensure decimal is always 2 digits
		$parts = explode('.', $amount);
		$speller = self::get($language);
		$wholeAmount = intval($parts[0]);
		$decimalAmount = intval($parts[1]);
		
		$text = trim($speller->parseInt($wholeAmount, false, $currency))
			. ' '
			. $speller->getCurrencyName('whole', $wholeAmount, $currency);
		
		if ($requireDecimal || ($decimalAmount > 0))
		{
			$text .= $speller->decimalSeparator
				. ($spellDecimal
					? trim($speller->parseInt($decimalAmount, true, $currency))
					: $decimalAmount)
				. ' '
				. $speller->getCurrencyName('decimal', $decimalAmount, $currency);
		}
		
		return $text;
	}
	
	private function parseInt($number, $isDecimalPart, $currency = '')
	{
		$text = '';
		
		if ($number < 0)
		{
			$text = $this->minus . ' ';
			$number = abs($number);
		}
		
		if (($number >= 1000000)
			&& ($number < 1000000000)) // 1'000'000-999'999'999
		{
			$millions = intval(substr("$number", 0, -6));
			$text .= $this->spellHundred($millions, 3, $isDecimalPart, $currency)
				. ' ' . $this->spellExponent('million', $millions, $currency);
			
			$number = intval(substr("$number", -6));
			
			if ($number === 0)
			{
				// exact millions
				return $text;
			}
			else
			{
				$text .= ' ';
			}
		}
		
		if (($number >= 1000)
			&& ($number < 1000000)) // 1'000-999'999
		{
			$thousands = intval(substr("$number", 0, -3));
			$text .= $this->spellHundred($thousands, 2, $isDecimalPart, $currency)
				. ' ' . $this->spellExponent('thousand', $thousands, $currency);
			
			$number = intval(substr("$number", -3));
			
			if ($number === 0)
			{
				// exact thousands
				return $text;
			}
			else
			{
				$text .= ' ';
			}
		}
		
		if ($number < 1000)
		{
			$text .= $this->spellHundred($number, 1, $isDecimalPart, $currency);
		}
		
		return $text;
	}
	
	protected abstract function spellHundred($number, $groupOfThrees, $isDecimalPart, $currency);
	protected abstract function spellExponent($type, $number, $currency);
	protected abstract function getCurrencyName($type, $number, $currency);
}
