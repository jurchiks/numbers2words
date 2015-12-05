<?php
// composer code:
// require __DIR__ . '/vendor/autoload.php';

// non-composer code (can run this in console immediately):
spl_autoload_register(
	function ($className)
	{
		$ds = DIRECTORY_SEPARATOR;
		$className = str_replace('js\\tools\\numbers2words', '', $className);
		$className = str_replace('\\', $ds, $className);
		$className = trim($className, $ds);
		
		$path = __DIR__ . $ds . 'src' . $ds . $className . '.php';
		
		if (!is_readable($path))
		{
			return false;
		}
		
		require $path;
		return true;
	},
	true
);

// common code:
use \js\tools\numbers2words\Speller;

try
{
	echo Speller::spellCurrency(123.45, Speller::LANGUAGE_ENGLISH, Speller::CURRENCY_EURO), "\n\n";
	
	foreach (Speller::getAcceptedLanguages() as $language)
	{
		for ($i = 10000; $i <= 1000000000; $i *= 10)
		{
			$number = (rand($i / 10, $i) / 100);
			echo 'Number = ', $number, "\n";
			
			foreach (Speller::getAcceptedCurrencies() as $currency)
			{
				echo $language, ' => ', $currency, ' = ', Speller::spellCurrency($number, $language, $currency), "\n";
			}
			
			echo "\n";
		}
		
		echo "\n";
	}
}
catch (\InvalidArgumentException $iae)
{
	echo $iae->getMessage();
	die(1);
}
