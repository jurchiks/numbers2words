<?php
namespace js\tools\numbers2words;

use js\tools\numbers2words\languages\Language;

/**
 * This class offers number spelling in various languages.
 *
 * @author Juris Sudmalis
 */
class Speller
{
	const LANGUAGE_ENGLISH = Language::ENGLISH;
	const LANGUAGE_ESTONIAN = Language::ESTONIAN;
	const LANGUAGE_LATVIAN = Language::LATVIAN;
	const LANGUAGE_LITHUANIAN = Language::LITHUANIAN;
	const LANGUAGE_RUSSIAN = Language::RUSSIAN;
	const LANGUAGE_SPANISH = Language::SPANISH;
	const LANGUAGE_POLISH = Language::POLISH;
	const LANGUAGE_ITALIAN = Language::ITALIAN;

	const CURRENCY_EURO = 'EUR';
	const CURRENCY_BRITISH_POUND = 'GBP';
	const CURRENCY_LATVIAN_LAT = 'LVL';
	const CURRENCY_LITHUANIAN_LIT = 'LTL';
	const CURRENCY_RUSSIAN_ROUBLE = 'RUR';
	const CURRENCY_US_DOLLAR = 'USD';
	const CURRENCY_PL_ZLOTY = 'PLN';
	const CURRENCY_TANZANIAN_SHILLING = 'TZS';
	
	private static $currencies = [
		self::CURRENCY_EURO,
		self::CURRENCY_BRITISH_POUND,
		self::CURRENCY_LATVIAN_LAT,
		self::CURRENCY_LITHUANIAN_LIT,
		self::CURRENCY_RUSSIAN_ROUBLE,
		self::CURRENCY_US_DOLLAR,
		self::CURRENCY_PL_ZLOTY,
		self::CURRENCY_TANZANIAN_SHILLING,
	];
	
	/** @var Language */
	private $language;
	
	/**
	 * @param string $language A two-letter, ISO 639-1 code of the language.
	 * @throws exceptions\UnsupportedLanguageException If the specified language is not supported.
	 */
	private final function __construct(string $language)
	{
		$this->language = Language::from($language);
	}
	
	public static function getAcceptedLanguages(): array
	{
		return Language::supportedLanguages();
	}
	
	public static function getAcceptedCurrencies(): array
	{
		return self::$currencies;
	}
	
	/**
	 * Convert a number into its linguistic representation.
	 *
	 * @param int $number The number to spell in the specified language.
	 * @param string $language A two-letter, ISO 639-1 code of the language to spell the number in.
	 * @return string The number as written in words in the specified language.
	 * @throws exceptions\SpellerException If any parameter is invalid.
	 */
	public static function spellNumber(int $number, string $language): string
	{
		return (new self($language))->language->spellNumber($number, false);
	}
	
	/**
	 * Convert currency to its linguistic representation.
	 * The format is {whole part spelled} CODE {decimal part}/100.
	 *
	 * @param int|float $amount The amount to spell in the specified language.
	 * @param string $language A two-letter, ISO 639-1 code of the language to spell the amount in.
	 * @param string $currency A three-letter, ISO 4217 currency code.
	 * @return string The currency as written in words in the specified language.
	 * @throws exceptions\SpellerException If any parameter is invalid.
	 */
	public static function spellCurrencyShort($amount, string $language, string $currency): string
	{
		self::validateNumber($amount);
		self::validateCurrency($currency);
		
		$amount = number_format($amount, 2, '.', ''); // ensure decimal is always 2 digits
		[$wholeAmount, $decimalAmount] = array_map('intval', explode('.', $amount));
		
		$speller = new self($language);
		
		return trim($speller->language->spellNumber($wholeAmount, false, $currency))
			. ' '
			. $currency
			. ' '
			. $decimalAmount
			. '/100';
	}
	
	/**
	 * Convert currency to its linguistic representation.
	 *
	 * @param int|float $amount The amount to spell in the specified language.
	 * @param string $language A two-letter, ISO 639-1 code of the language to spell the amount in.
	 * @param string $currency A three-letter, ISO 4217 currency code.
	 * @param bool $requireDecimal If true, output decimals even if the value is 0.
	 * @param bool $spellDecimal If true, spell the decimal part out same as the whole part;
	 * otherwise, spell only the whole part and output the decimal part as integer.
	 * @return string The currency as written in words in the specified language.
	 * @throws exceptions\SpellerException If any parameter is invalid.
	 */
	public static function spellCurrency($amount, string $language, string $currency, bool $requireDecimal = true, bool $spellDecimal = false): string
	{
		self::validateNumber($amount);
		self::validateCurrency($currency);
		
		$amount = number_format($amount, 2, '.', ''); // ensure decimal is always 2 digits
		[$wholeAmount, $decimalAmount] = array_map('intval', explode('.', $amount));
		
		$speller = new self($language);
		
		$text = trim($speller->language->spellNumber($wholeAmount, false, $currency))
			. ' '
			. $speller->language->getCurrencyNameMajor($wholeAmount, $currency);
		
		if ($requireDecimal || ($decimalAmount > 0))
		{
			$text .= ' '
				. $speller->language->spellMinorUnitSeparator()
				. ' '
				. ($spellDecimal
					? trim($speller->language->spellNumber($decimalAmount, true, $currency))
					: $decimalAmount)
				. ' '
				. $speller->language->getCurrencyNameMinor($decimalAmount, $currency);
		}
		
		return $text;
	}
	
	/**
	 * @param mixed $number
	 * @throws exceptions\InvalidArgumentException
	 */
	private static function validateNumber($number): void
	{
		if (!is_numeric($number))
		{
			throw new exceptions\InvalidArgumentException('Invalid number specified.');
		}
	}
	
	/**
	 * @param string $currency
	 * @throws exceptions\UnsupportedCurrencyException
	 */
	private static function validateCurrency(string $currency): void
	{
		if (!in_array($currency, self::$currencies))
		{
			throw new exceptions\UnsupportedCurrencyException($currency);
		}
	}
}
