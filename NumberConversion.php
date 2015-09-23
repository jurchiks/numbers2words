<?php
/**
 * This class offers a number-to-word conversion to various languages.
 * It is a work-in-progress and more languages are to be added in future.
 * The main and only public method to call a conversion is NumberConversion::numberToWords().
 * @author Juris Sudmalis
 */
class NumberConversion
{
	private static $languages = array(
		'en' => true,
		'lv' => true,
		'ru' => true,
		'lt' => true,
		'es' => true,
	);
	
	private static $minus = array(
		'en' => 'minus',
		'lv' => 'mīnus',
		'ru' => 'минус',
		'lt' => 'minus',
		'es' => 'menos',
	);
	
	private static $singleDigits = array(
		'0' => array(
			'en' => 'zero',
			'lv' => 'nulle',
			'ru' => 'ноль',
			'lt' => 'nulis',
			'es' => 'cero',
		),
		'1' => array(
			'en' => 'one',
			'lv' => 'viens',
			'ru' => 'один',
			'lt' => 'vienas',
			'es' => 'uno',
		),
		'2' => array(
			'en' => 'two',
			'lv' => 'divi',
			'ru' => 'два',
			'lt' => 'du',
			'es' => 'dos',
		),
		'3' => array(
			'en' => 'three',
			'lv' => 'trīs',
			'ru' => 'три',
			'lt' => 'trys',
			'es' => 'tres',
		),
		'4' => array(
			'en' => 'four',
			'lv' => 'četri',
			'ru' => 'четыре',
			'lt' => 'keturi',
			'es' => 'cuatro',
		),
		'5' => array(
			'en' => 'five',
			'lv' => 'pieci',
			'ru' => 'пять',
			'lt' => 'penki',
			'es' => 'cinco',
		),
		'6' => array(
			'en' => 'six',
			'lv' => 'seši',
			'ru' => 'шесть',
			'lt' => 'šeši',
			'es' => 'seis',
		),
		'7' => array(
			'en' => 'seven',
			'lv' => 'septiņi',
			'ru' => 'семь',
			'lt' => 'septyni',
			'es' => 'siete',
		),
		'8' => array(
			'en' => 'eight',
			'lv' => 'astoņi',
			'ru' => 'восемь',
			'lt' => 'aštuoni',
			'es' => 'ocho',
		),
		'9' => array(
			'en' => 'nine',
			'lv' => 'deviņi',
			'ru' => 'девять',
			'lt' => 'devyni',
			'es' => 'nueve',
		),
	);
	
	private static $singleDigitsFeminine = array(
		'lv' => array(
			'1' => 'viena',
			'2' => 'divas',
			'3' => 'trīs',
			'4' => 'četras',
			'5' => 'piecas',
			'6' => 'sešas',
			'7' => 'septiņas',
			'8' => 'astoņas',
			'9' => 'deviņas',
		),
		'ru' => array(
			'1' => 'одна',
			'2' => 'две',
			'3' => 'три',
			'4' => 'четыре',
			'5' => 'пять',
			'6' => 'шесть',
			'7' => 'семь',
			'8' => 'восемь',
			'9' => 'девять',
		),
	);
	
	private static $teens = array(
		'11' => array(
			'en' => 'eleven',
			'lv' => 'vienpadsmit',
			'ru' => 'одиннадцать',
			'lt' => 'vienuolika',
			'es' => 'once',
		),
		'12' => array(
			'en' => 'twelve',
			'lv' => 'divpadsmit',
			'ru' => 'двенадцать',
			'lt' => 'dvylika',
			'es' => 'doce',
		),
		'13' => array(
			'en' => 'thirteen',
			'lv' => 'trīspadsmit',
			'ru' => 'тринадцать',
			'lt' => 'trylika',
			'es' => 'trece',
		),
		'14' => array(
			'en' => 'fourteen',
			'lv' => 'četrpadsmit',
			'ru' => 'четырнадцать',
			'lt' => 'keturiolika',
			'es' => 'catorce',
		),
		'15' => array(
			'en' => 'fifteen',
			'lv' => 'piecpadsmit',
			'ru' => 'пятнадцать',
			'lt' => 'penkiolika',
			'es' => 'quince',
		),
		'16' => array(
			'en' => 'sixteen',
			'lv' => 'sešpadsmit',
			'ru' => 'шестнадцать',
			'lt' => 'šešiolika',
			'es' => 'dieciséis',
		),
		'17' => array(
			'en' => 'seventeen',
			'lv' => 'septiņpadsmit',
			'ru' => 'семнадцать',
			'lt' => 'septyniolika',
			'es' => 'diecisiete',
		),
		'18' => array(
			'en' => 'eighteen',
			'lv' => 'astoņpadsmit',
			'ru' => 'восемнадцать',
			'lt' => 'aštuoniolika',
			'es' => 'dieciocho',
		),
		'19' => array(
			'en' => 'nineteen',
			'lv' => 'deviņpadsmit',
			'ru' => 'девятнадцать',
			'lt' => 'devyniolika',
			'es' => 'diecinueve',
		),
	);
	
	private static $tens = array(
		'1' => array(
			'en' => 'ten',
			'lv' => 'desmit',
			'ru' => 'десять',
			'lt' => 'dešimt',
			'es' => 'diez',
		),
		'2' => array(
			'en' => 'twenty',
			'lv' => 'divdesmit',
			'ru' => 'двадцать',
			'lt' => 'dvidešimt',
			'es' => 'veinte',
		),
		'3' => array(
			'en' => 'thirty',
			'lv' => 'trīsdesmit',
			'ru' => 'тридцать',
			'lt' => 'trisdešimt',
			'es' => 'treinta',
		),
		'4' => array(
			'en' => 'fourty',
			'lv' => 'četrdesmit',
			'ru' => 'сорок',
			'lt' => 'keturiasdešimt',
			'es' => 'cuarenta',
		),
		'5' => array(
			'en' => 'fifty',
			'lv' => 'piecdesmit',
			'ru' => 'пятьдесят',
			'lt' => 'penkiasdešimt',
			'es' => 'cincuenta',
		),
		'6' => array(
			'en' => 'sixty',
			'lv' => 'sešdesmit',
			'ru' => 'шестьдесят',
			'lt' => 'šešiasdešimt',
			'es' => 'sesenta',
		),
		'7' => array(
			'en' => 'seventy',
			'lv' => 'septiņdesmit',
			'ru' => 'семьдесят',
			'lt' => 'septyniasdešimt',
			'es' => 'setenta',
		),
		'8' => array(
			'en' => 'eighty',
			'lv' => 'astoņdesmit',
			'ru' => 'восемьдесят',
			'lt' => 'aštuoniasdešimt',
			'es' => 'ochenta',
		),
		'9' => array(
			'en' => 'ninety',
			'lv' => 'deviņdesmit',
			'ru' => 'девятьдесят',
			'lt' => 'devyniasdešimt',
			'es' => 'noventa',
		),
	);
	
	private static $hundreds = array(
		'1' => array(
			'en' => '',
			'lv' => 'simts',
			'ru' => 'сто',
			'lt' => 'šimtas',
			'es' => 'ciento',
		),
		'2' => array(
			'en' => '',
			'lv' => 'divsimt',
			'ru' => 'двести',
			'lt' => 'du šimtai',
			'es' => 'doscientos',
		),
		'3' => array(
			'en' => '',
			'lv' => 'trīssimt',
			'ru' => 'триста',
			'lt' => 'trys šimtai',
			'es' => 'trescientos',
		),
		'4' => array(
			'en' => '',
			'lv' => 'četrsimt',
			'ru' => 'четыреста',
			'lt' => 'keturi šimtai',
			'es' => 'cuatrocientos',
		),
		'5' => array(
			'en' => '',
			'lv' => 'piecsimt',
			'ru' => 'пятсот',
			'lt' => 'penki šimtai',
			'es' => 'quinientos',
		),
		'6' => array(
			'en' => '',
			'lv' => 'sešsimt',
			'ru' => 'шестьсот',
			'lt' => 'šeši šimtai',
			'es' => 'seiscientos',
		),
		'7' => array(
			'en' => '',
			'lv' => 'septiņsimt',
			'ru' => 'семьсот',
			'lt' => 'septyni šimtai',
			'es' => 'setecientos',
		),
		'8' => array(
			'en' => '',
			'lv' => 'astoņsimt',
			'ru' => 'восемьсот',
			'lt' => 'aštuoni šimtai',
			'es' => 'ochocientos',
		),
		'9' => array(
			'en' => '',
			'lv' => 'deviņsimt',
			'ru' => 'девятьсот',
			'lt' => 'devyni šimtai',
			'es' => 'novecientos',
		),
	);
	
	private static $thousands = array(
		'1' => array(
			'en' => 'thousand',
			'lv' => 'tūkstotis',
			'ru' => 'тысяча',
			'lt' => 'tūkstantis',
			'es' => 'mil',
		),
		'2' => array(
			'en' => 'thousand',
			'lv' => 'tūkstoši',
			'ru' => 'тысячи',
			'lt' => 'tūkstančiai',
			'es' => 'mil',
		),
	);
	
	private static $spacer = array(
		'en' => ' ',
		'lv' => ' ',
		'ru' => ' ',
		'lt' => ' ',
		'es' => ' y ',
	);
	
	private static $decimalReplacement = array(
		'en' => ' and ',
		'lv' => ' un ',
		'ru' => ' и ',
		'lt' => ' ir ',
		'es' => ' con ',
	);
	
	private static $currencies = array(
		'USD' => array( // currency code
			'lv' => array( // language
				'1' => array( // before decimal
					'1' => 'dolārs', // 1
					'2' => 'dolāri', // 2-9
					'3' => 'dolāru' // 0, 10-20, 30, 40...
				),
				'2' => array( // after decimal
					'1' => 'cents',
					'2' => 'centi',
					'3' => 'centu',
				),
			),
			'ru' => array(
				'1' => array(
					'1' => 'доллар', // 1
					'2' => 'доллара', // 2-4
					'3' => 'долларов', // 0, 5-20, 30, 40...
				),
				'2' => array(
					'1' => 'цент',
					'2' => 'цента',
					'3' => 'центов',
				),
			),
			'en' => array(
				'1' => array(
					'1' => 'dollar',
					'2' => 'dollars',
					'3' => 'dollars',
				),
				'2' => array(
					'1' => 'cent',
					'2' => 'cents',
					'3' => 'cents',
				),
			),
			// TODO lt/es
		),
		'EUR' => array(
			'lv' => array(
				'1' => array(
					'1' => 'eiro',
					'2' => 'eiro',
					'3' => 'eiro',
				),
				'2' => array(
					'1' => 'cents',
					'2' => 'centi',
					'3' => 'centu',
				),
			),
			'ru' => array(
				'1' => array(
					'1' => 'евро',
					'2' => 'евро',
					'3' => 'евро',
				),
				'2' => array(
					'1' => 'цент',
					'2' => 'цента',
					'3' => 'центов',
				),
			),
			'en' => array(
				'1' => array(
					'1' => 'euro',
					'2' => 'euro',
					'3' => 'euro',
				),
				'2' => array(
					'1' => 'cent',
					'2' => 'cents',
					'3' => 'cents',
				),
			),
			// TODO lt/es
		),
		'LVL' => array(
			'lv' => array(
				'1' => array(
					'1' => 'lats',
					'2' => 'lati',
					'3' => 'latu',
				),
				'2' => array(
					'1' => 'santīms',
					'2' => 'santīmi',
					'3' => 'santīmu',
				),
			),
			'ru' => array(
				'1' => array(
					'1' => 'лат',
					'2' => 'лата',
					'3' => 'лат',
				),
				'2' => array(
					'1' => 'сантим',
					'2' => 'сантима',
					'3' => 'сантимов',
				),
			),
			'en' => array(
				'1' => array(
					'1' => 'lat',
					'2' => 'lats',
					'3' => 'lats',
				),
				'2' => array(
					'1' => 'santim',
					'2' => 'santims',
					'3' => 'santims',
				),
			),
			// TODO lt/es
		),
		'LTL' => array(
			'lv' => array(
				'1' => array(
					'1' => 'lits',
					'2' => 'liti',
					'3' => 'litu',
				),
				'2' => array(
					'1' => 'cents',
					'2' => 'centi',
					'3' => 'centu',
				),
			),
			'ru' => array(
				'1' => array(
					'1' => 'лит',
					'2' => 'лита',
					'3' => 'литов',
				),
				'2' => array(
					'1' => 'цент',
					'2' => 'цента',
					'3' => 'центов',
				),
			),
			'en' => array(
				'1' => array(
					'1' => 'litas',
					'2' => 'litai',
					'3' => 'litai',
				),
				'2' => array(
					'1' => 'centas',
					'2' => 'centai',
					'3' => 'centai',
				),
			),
			// TODO lt/es
		),
		'RUR' => array(
			'lv' => array(
				'1' => array(
					'1' => 'rublis',
					'2' => 'rubļi',
					'3' => 'rubļu',
				),
				'2' => array(
					'1' => 'kapeika',
					'2' => 'kapeikas',
					'3' => 'kapeiku',
				),
			),
			'ru' => array(
				'1' => array(
					'1' => 'рубль',
					'2' => 'рубля',
					'3' => 'рублей',
				),
				'2' => array(
					'1' => 'копейка',
					'2' => 'копейки',
					'3' => 'копеек',
				),
			),
			'en' => array(
				'1' => array(
					'1' => 'ruble',
					'2' => 'rubles',
					'3' => 'rubles',
				),
				'2' => array(
					'1' => 'kopek',
					'2' => 'kopek',
					'3' => 'kopek',
				),
			),
			// TODO lt
			'es' => array(
				'1' => array(
					'1' => 'rublo',
					'2' => 'rublos',
					'3' => 'rublos',
				),
				'2' => array(
					'1' => 'kopek',
					'2' => 'kopeks',
					'3' => 'kopeks',
				),
			),
		),
	);
	
	private static $es_twentysomething = 'veinti';
	// just plain one hundred (100) is written differently in Spanish
	// than when used in conjunction with other numbers like 101
	private static $es_hundred = 'cien';
	private static $es_thousand = 'mil'; // TODO use this
	private static $en_hundred = ' hundred';
	
	/**
	 * Convert a number into its linguistic representation.
	 * 
	 * @param mixed $number : the number to convert to the specified language
	 * @param string $language : a two-letter representation of the language to convert the number to
	 * @param string $beforeDecimal : the text to attach after the whole numbers
	 * @param string $atEnd : the text to attach after the decimal numbers
	 * @return string : the number as written in words in the specified language,
	 * or "null" if any parameter was invalid
	 */
	public static function numberToWords($number, $language, $beforeDecimal = '', $atEnd = '')
	{
		self::normalizeParameters($number, $language);
		
		$amounts = explode('.', "$number");
		$text = self::parseInt($amounts[0], $language, 1)
			. ' '
			. $beforeDecimal;
		
		if (count($amounts) > 1)
		{
			$text .= self::$decimalReplacement[$language]
				. self::parseInt($amounts[1], $language, 2)
				. ' '
				. $atEnd;
		}
		
		return $text;
	}
	
	/**
	 * Convert currency from numeric to linguistic representation.
	 * 
	 * @param mixed $amount : the number to convert to the specified language
	 * @param string $language : a two-letter, ISO 639-1 code of the language to convert the number to
	 * @param string $currency : a three-letter, ISO 4217 currency code
	 * @return string : the currency as written in words in the specified language,
	 * or "null" if any parameter was invalid
	 */
	public static function currencyToWords($amount, $language, $currency)
	{
		if (!is_string($currency))
		{
			throw new InvalidArgumentException('Invalid currency code specified.');
		}
		
		self::normalizeParameters($amount, $language, $currency);
		
		$amounts = explode('.', "$amount");
		$wholePart = self::parseInt($amounts[0], $language, 1, $currency);
		$text = $wholePart . self::getCurrencyName($amounts[0], $currency, $language, '1');
		
		if (count($amounts) > 1)
		{
			$decimalPart = self::parseInt($amounts[1], $language, 2, $currency);
			$text .= self::$decimalReplacement[$language]
				. trim($decimalPart)
				. self::getCurrencyName($amounts[1], $currency, $language, '2');
		}
		
		return $text;
	}
	
	private static function normalizeParameters(&$amount, &$language, &$currency = null)
	{
		if (!is_numeric($amount))
		{
			throw new InvalidArgumentException('Invalid number specified.');
		}
		
		if (ctype_digit("$amount"))
		{
			$amount = intval($amount);
		}
		else
		{
			$amount = floatval($amount);
		}
		
		$language = strtolower(trim($language));
		
		if (strlen($language) != 2)
		{
			throw new InvalidArgumentException('Invalid language code specified, must follow ISO 639-1 format.');
		}
		
		if (!isset(self::$languages[$language]))
		{
			throw new InvalidArgumentException('That language is not implemented yet.');
		}
		
		if ($currency !== null)
		{
			$currency = strtoupper(trim($currency));
			
			if (!isset(self::$currencies[$currency]))
			{
				throw new InvalidArgumentException('That currency is not implemented yet.');
			}
		}
	}
	
	private static function getCurrencyName($amount, $currency, $language, $part)
	{
		$lastDigit = (int)substr("$amount", -1);
		$lastTwoDigits = (int)substr("$amount", -2);
		
		if ($lastDigit === 0)
		{
			// 0, 10, 20, 30...
			return ' ' . self::$currencies[$currency][$language][$part]['3'];
		}
		
		if (($lastTwoDigits > 10)
			&& ($lastTwoDigits < 20))
		{
			// 11-19
			return ' ' . self::$currencies[$currency][$language][$part]['3'];
		}
		
		if ($lastDigit === 1)
		{
			// 1, 21, 31, 41...
			return ' ' . self::$currencies[$currency][$language][$part]['1'];
		}
		
		if ($language === 'ru')
		{
			if ($lastDigit < 5)
			{
				// 2, 3, 4, 24, 33... рубля
				return ' ' . self::$currencies[$currency][$language][$part]['2'];
			}
			
			return ' ' . self::$currencies[$currency][$language][$part]['3'];
		}
		
		// 2-9, 22-29, 33-39...
		return ' ' . self::$currencies[$currency][$language][$part]['2'];
	}
	
	private static function parseInt($number, $language, $part, $currency = '')
	{
		$number = (int)$number;
		$text = '';
		
		if ($number < 0)
		{
			$text = self::$minus[$language] . ' ';
			$number = abs($number); // get rid of the minus sign
		}
		
		if (($number < 10) && ($part === 2) && ($currency !== ''))
		{
			// decimal part of currency must be 2 digits
			// if there is only one digit, that means the currency is missing a digit,
			// i.e. 121.2 instead of 121.20
			// multiply by 10 to fix it
			$number *= 10;
		}
		
		if (($number >= 1000)
			&& ($number < 1000000)) // 1000-999 999
		{
			$thousands = (int)substr("$number", 0, -3);
			$text .= self::parseThreeDigitBlock($thousands, $language, $part, $currency);
			$count = (($thousands === 1) ? '1' : '2');
			$text .= ' ' . self::$thousands[$count][$language] . ' ';
			
			$number = (int)substr("$number", -3);
			
			if ($number === 0)
			{
				// exact thousands, no hundreds
				return $text;
			}
		}
		
		if ($number < 1000)
		{
			$text .= self::parseThreeDigitBlock($number, $language, $part, $currency);
		}
		
		return $text;
	}
	
	private static function parseThreeDigitBlock($number, $language, $part, $currency = '')
	{
		$text = '';
		
		if (($number >= 100)
			&& ($number < 1000))
		{
			$firstDigit = substr("$number", 0, 1);
			
			if ($language === 'en')
			{
				$text .= self::$singleDigits[$firstDigit][$language] . self::$en_hundred;
			}
			else if (($language === 'es')
				&& ($number === 100))
			{
				$text .= self::$es_hundred;
			}
			else
			{
				$text .= self::$hundreds[$firstDigit][$language];
			}
			
			$number = (int)substr("$number", 1);
			
			if ($number === 0)
			{
				// exact hundreds
				return $text;
			}
		}
		
		if ($number < 100)
		{
			if ($number < 10) // 0-9
			{
				if (($part === 2)
					&& ($currency === 'RUR')
					&& (($language === 'lv')
						|| ($language === 'ru')))
				{
					// russian kopeck nouns are feminine gender in certain languages
					$text .= ' ' . self::$singleDigitsFeminine[$language][$number];
				}
				else
				{
					$text .= ' ' . self::$singleDigits[$number][$language];
				}
			}
			else if (($number > 10)
					&& ($number < 20))
			{
				$text .= ' ' . self::$teens[$number][$language]; // 11-19
			}
			else if ($number % 10 === 0)
			{
				$text .= ' ' . self::$tens[substr($number, 0, 1)][$language];// 10-90
			}
			else
			{
				if (($language === 'es')
					&& ($number < 30))
				{
					$text .= ' '
						. self::$es_twentysomething
						. self::$singleDigits[$number % 10][$language]; // 21-29 is different in spanish
				}
				else
				{
					$text .= ' '
						. self::$tens[substr($number, 0, 1)][$language]
						. self::$spacer[$language];
					
					if (($part === 2)
						&& ($currency === 'RUR')
						&& (($language === 'lv')
							|| ($language === 'ru')))
					{
						// russian kopeck nouns are feminine gender in certain languages
						$text .= self::$singleDigitsFeminine[$language][$number % 10];
					}
					else
					{
						$text .= self::$singleDigits[$number % 10][$language];
					}
				}
			}
		}
		
		return $text;
	}
}
