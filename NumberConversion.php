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
		'en', 'lv', 'ru', 'lt', 'es'
	);
	
	private static $minus = array(
		'en' => 'minus',
		'lv' => 'mīnus',
		'ru' => 'минус',
		'lt' => 'minus',
		'es' => 'menos'
	);
	
	private static $singleDigits = array(
		'0' => array(
			'en' => 'zero',
			'lv' => 'nulle',
			'ru' => 'ноль',
			'lt' => 'nulis',
			'es' => 'cero'
		),
		'1' => array(
			'en' => 'one',
			'lv' => 'viens',
			'ru' => 'один',
			'lt' => 'vienas',
			'es' => 'uno'
		),
		'2' => array(
			'en' => 'two',
			'lv' => 'divi',
			'ru' => 'два',
			'lt' => 'du',
			'es' => 'dos'
		),
		'3' => array(
			'en' => 'three',
			'lv' => 'trīs',
			'ru' => 'три',
			'lt' => 'trys',
			'es' => 'tres'
		),
		'4' => array(
			'en' => 'four',
			'lv' => 'četri',
			'ru' => 'четыре',
			'lt' => 'keturi',
			'es' => 'cuatro'
		),
		'5' => array(
			'en' => 'five',
			'lv' => 'pieci',
			'ru' => 'пять',
			'lt' => 'penki',
			'es' => 'cinco'
		),
		'6' => array(
			'en' => 'six',
			'lv' => 'seši',
			'ru' => 'шесть',
			'lt' => 'šeši',
			'es' => 'seis'
		),
		'7' => array(
			'en' => 'seven',
			'lv' => 'septiņi',
			'ru' => 'семь',
			'lt' => 'septyni',
			'es' => 'siete'
		),
		'8' => array(
			'en' => 'eight',
			'lv' => 'astoņi',
			'ru' => 'восемь',
			'lt' => 'aštuoni',
			'es' => 'ocho'
		),
		'9' => array(
			'en' => 'nine',
			'lv' => 'deviņi',
			'ru' => 'девять',
			'lt' => 'devyni',
			'es' => 'nueve'
		)
	);
	
	private static $teens = array(
		'11' => array(
			'en' => 'eleven',
			'lv' => 'vienpadsmit',
			'ru' => 'одиннадцать',
			'lt' => 'vienuolika',
			'es' => 'once'
		),
		'12' => array(
			'en' => 'twelve',
			'lv' => 'divpadsmit',
			'ru' => 'двенадцать',
			'lt' => 'dvylika',
			'es' => 'doce'
		),
		'13' => array(
			'en' => 'thirteen',
			'lv' => 'trīspadsmit',
			'ru' => 'тринадцать',
			'lt' => 'trylika',
			'es' => 'trece'
		),
		'14' => array(
			'en' => 'fourteen',
			'lv' => 'četrpadsmit',
			'ru' => 'четырнадцать',
			'lt' => 'keturiolika',
			'es' => 'catorce'
		),
		'15' => array(
			'en' => 'fifteen',
			'lv' => 'piecpadsmit',
			'ru' => 'пятнадцать',
			'lt' => 'penkiolika',
			'es' => 'quince'
		),
		'16' => array(
			'en' => 'sixteen',
			'lv' => 'sešpadsmit',
			'ru' => 'шестнадцать',
			'lt' => 'šešiolika',
			'es' => 'dieciséis'
		),
		'17' => array(
			'en' => 'seventeen',
			'lv' => 'septiņpadsmit',
			'ru' => 'семнадцать',
			'lt' => 'septyniolika',
			'es' => 'diecisiete'
		),
		'18' => array(
			'en' => 'eighteen',
			'lv' => 'astoņpadsmit',
			'ru' => 'восемнадцать',
			'lt' => 'aštuoniolika',
			'es' => 'dieciocho'
		),
		'19' => array(
			'en' => 'nineteen',
			'lv' => 'deviņpadsmit',
			'ru' => 'девятнадцать',
			'lt' => 'devyniolika',
			'es' => 'diecinueve'
		)
	);
	
	private static $tens = array(
		'1' => array(
			'en' => 'ten',
			'lv' => 'deviņi',
			'ru' => 'десять',
			'lt' => 'dešimt',
			'es' => 'diez'
		),
		'2' => array(
			'en' => 'twenty',
			'lv' => 'divdesmit',
			'ru' => 'двадцать',
			'lt' => 'dvidešimt',
			'es' => 'veinte'
		),
		'3' => array(
			'en' => 'thirty',
			'lv' => 'trīsdesmit',
			'ru' => 'тридцать',
			'lt' => 'trisdešimt',
			'es' => 'treinta'
		),
		'4' => array(
			'en' => 'fourty',
			'lv' => 'četrdesmit',
			'ru' => 'сорок',
			'lt' => 'keturiasdešimt',
			'es' => 'cuarenta'
		),
		'5' => array(
			'en' => 'fifty',
			'lv' => 'piecdesmit',
			'ru' => 'пятьдесят',
			'lt' => 'penkiasdešimt',
			'es' => 'cincuenta'
		),
		'6' => array(
			'en' => 'sixty',
			'lv' => 'sešdesmit',
			'ru' => 'шестьдесят',
			'lt' => 'šešiasdešimt',
			'es' => 'sesenta'
		),
		'7' => array(
			'en' => 'seventy',
			'lv' => 'septiņdesmit',
			'ru' => 'семьдесят',
			'lt' => 'septyniasdešimt',
			'es' => 'setenta'
		),
		'8' => array(
			'en' => 'eighty',
			'lv' => 'astoņdesmit',
			'ru' => 'восемьдесят',
			'lt' => 'aštuoniasdešimt',
			'es' => 'ochenta'
		),
		'9' => array(
			'en' => 'ninety',
			'lv' => 'deviņdesmit',
			'ru' => 'девятьдесят',
			'lt' => 'devyniasdešimt',
			'es' => 'noventa'
		)
	);
	
	private static $hundreds = array(
		'1' => array(
			'en' => '',
			'lv' => 'simts',
			'ru' => 'сто',
			'lt' => 'šimtas',
			'es' => 'ciento'
		),
		'2' => array(
			'en' => '',
			'lv' => 'divsimt',
			'ru' => 'двести',
			'lt' => 'du šimtai',
			'es' => 'doscientos'
		),
		'3' => array(
			'en' => '',
			'lv' => 'trīssimt',
			'ru' => 'триста',
			'lt' => 'trys šimtai',
			'es' => 'trescientos'
		),
		'4' => array(
			'en' => '',
			'lv' => 'četrsimt',
			'ru' => 'четыреста',
			'lt' => 'keturi šimtai',
			'es' => 'cuatrocientos'
		),
		'5' => array(
			'en' => '',
			'lv' => 'piecsimt',
			'ru' => 'пятсот',
			'lt' => 'penki šimtai',
			'es' => 'quinientos'
		),
		'6' => array(
			'en' => '',
			'lv' => 'sešsimt',
			'ru' => 'шестьсот',
			'lt' => 'šeši šimtai',
			'es' => 'seiscientos'
		),
		'7' => array(
			'en' => '',
			'lv' => 'septiņsimt',
			'ru' => 'семьсот',
			'lt' => 'septyni šimtai',
			'es' => 'setecientos'
		),
		'8' => array(
			'en' => '',
			'lv' => 'astoņsimt',
			'ru' => 'восемьсот',
			'lt' => 'aštuoni šimtai',
			'es' => 'ochocientos'
		),
		'9' => array(
			'en' => '',
			'lv' => 'deviņsimt',
			'ru' => 'девятьсот',
			'lt' => 'devyni šimtai',
			'es' => 'novecientos'
		)
	);
	
	private static $thousands = array(
		'1' => array(
			'en' => 'thousand',
			'lv' => 'tūkstotis',
			'ru' => 'тысяча',
			'lt' => 'tūkstantis',
			'es' => 'mil'
		),
		'2' => array(
			'en' => 'thousand',
			'lv' => 'tūkstoši',
			'ru' => 'тысячи',
			'lt' => 'tūkstančiai',
			'es' => 'mil'
		)
	);
	
	private static $spacer = array(
		'en' => ' ',
		'lv' => ' ',
		'ru' => ' ',
		'lt' => ' ',
		'es' => ' y '
	);
	
	private static $decimalReplacement = array(
		'en' => ' and ',
		'lv' => ' un ',
		'ru' => ' и ',
		'lt' => ' ir ',
		'es' => ' con '
	);
	
	private static $es_twentysomething = 'veinti';
	// just plain one hundred (100) is written differently in Spanish
	// than when used in conjunction with other numbers like 101
	private static $es_hundred = 'cien';
	private static $es_thousand = 'mil';
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
		if (!is_numeric($number))
		{
			error_log(__METHOD__ . ': invalid number specified.');
			return 'null';
		}
		
		if (ctype_digit("$number"))
		{
			$number = intval($number);
		}
		else
		{
			$number = floatval($number);
		}
		
		$language = strtolower(trim($language));
		
		if (strlen($language) != 2)
		{
			error_log(__METHOD__ . ': invalid language parameter.');
			return 'null';
		}
		
		if (!in_array($language, self::$languages))
		{
			error_log(__METHOD__ . ': that language is not yet implemented.');
			return 'null';
		}
		
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
	
	private static function parseInt($number, $language, $part)
	{
		$number = (int)$number;
		$text = '';
		
		if ($number < 0)
		{
			$text = self::$minus[$language] . ' ';
			$number = abs($number); // get rid of the minus sign
		}
		
		if (($number >= 1000)
			&& ($number < 1000000)) // 1000-999 999
		{
			$thousands = (int)substr("$number", 0, -3);
			$text .= self::parseThreeDigitBlock($thousands, $language, $part);
			$count = (($thousands == 1) ? '1' : '2');
			$text .= ' ' . self::$thousands[$count][$language] . ' ';
			
			$number = (int)substr("$number", -3);
			
			if ($number == 0)
			{
				// exact thousands, no hundreds
				return $text;
			}
		}
		
		if ($number < 1000)
		{
			$text .= self::parseThreeDigitBlock($number, $language, $part);
		}
		
		return $text;
	}
	
	private static function parseThreeDigitBlock($number, $language, $part)
	{
		$text = '';
		
		if (($number >= 100)
			&& ($number < 1000))
		{
			$firstDigit = substr("$number", 0, 1);
			
			if ($language == 'en')
			{
				$text .= self::$singleDigits[$firstDigit][$language] . self::$en_hundred;
			}
			else
			{
				$text .= self::$hundreds[$firstDigit][$language];
			}
			
			$number = (int)substr("$number", 1);
			
			if ($number == 0)
			{
				// exact hundreds
				return $text;
			}
		}
		
		if (($language == 'es') // TODO methinks this doesn't happen... gotta check
			&& ($number == 100))
		{
			$text .= ' ' . self::$es_hundred;
		}
		else if ($number < 100)
		{
			if (($language != 'es')
				&& ($part == 2))
			{
				$text .= " $number";
			}
			else if ($number < 10)
			{
				$text .= ' ' . self::$singleDigits[$number][$language]; // 0-9
			}
			else if (($number > 10)
					&& ($number < 20))
			{
				$text .= ' ' . self::$teens[$number][$language]; // 11-19
			}
			else if ($number % 10 == 0)
			{
				$text .= ' ' . self::$tens[substr($number, 0, 1)][$language];// 10-90
			}
			else
			{
				if (($language == 'es')
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
						. self::$spacer[$language]
						. self::$singleDigits[$number % 10][$language];
				}
			}
		}
		
		return $text;
	}
}
