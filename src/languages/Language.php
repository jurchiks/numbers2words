<?php
namespace js\tools\numbers2words\languages;

use Exception;
use js\tools\numbers2words\exceptions\UnsupportedLanguageException;

/**
 * @internal
 */
abstract class Language
{
	public const ENGLISH = 'en';
	public const ESTONIAN = 'et';
	public const LATVIAN = 'lv';
	public const LITHUANIAN = 'lt';
	public const RUSSIAN = 'ru';
	public const SPANISH = 'es';
	public const POLISH = 'pl';
	public const ITALIAN = 'it';

	private const SUPPORTED_LANGUAGE_CLASSES = [
		self::ENGLISH    => English::class,
		self::ESTONIAN   => Estonian::class,
		self::LATVIAN    => Latvian::class,
		self::LITHUANIAN => Lithuanian::class,
		self::RUSSIAN    => Russian::class,
		self::SPANISH    => Spanish::class,
		self::POLISH     => Polish::class,
		self::ITALIAN    => Italian::class,
	];
	
	/**
	 * @param string $code A two-letter, ISO 639-1 code of the language.
	 * @return Language
	 * @throws UnsupportedLanguageException If $code is invalid.
	 */
	public static function from(string $code): Language
	{
		static $languages = [];
		
		if (!isset(self::SUPPORTED_LANGUAGE_CLASSES[$code]))
		{
			throw new UnsupportedLanguageException($code);
		}
		
		if (!isset($languages[$code]))
		{
			$className = self::SUPPORTED_LANGUAGE_CLASSES[$code];
			$languages[$code] = new $className();
		}
		
		return $languages[$code];
	}
	
	public static final function supportedLanguages(): array
	{
		return array_keys(self::SUPPORTED_LANGUAGE_CLASSES);
	}
	
	public function spellNumber(int $number, bool $isDecimalPart, string $currency = ''): string
	{
		$text = '';
		
		if ($number < 0)
		{
			$text = $this->spellMinus() . ' ';
			$number = abs($number);
		}
		
		// TODO Write this using a loop instead of copy-pasta!
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
	
	public abstract function spellMinus(): string;
	
	public abstract function spellMinorUnitSeparator(): string;
	
	public abstract function spellHundred(int $number, int $groupOfThrees, bool $isDecimalPart, string $currency): string;
	
	public abstract function spellExponent(string $type, int $number, string $currency): string;
	
	public abstract function getCurrencyNameMajor(int $amount, string $currency): string;
	
	public abstract function getCurrencyNameMinor(int $amount, string $currency): string;
	
	/**
	 * @deprecated Unnecessary in PHP8: https://wiki.php.net/rfc/throw_expression
	 */
	protected static final function throw(Exception $exception): void
	{
		throw $exception;
	}
}
