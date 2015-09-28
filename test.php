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
		var_dump($path);
		
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
	echo Speller::spellNumber(123.45, 'en'), "\n";
	echo Speller::spellNumber(234.56, 'es'), "\n";
	echo Speller::spellNumber(345.67, 'lt'), "\n";
	echo Speller::spellNumber(456.78, 'lv'), "\n";
	echo Speller::spellNumber(567.89, 'ru'), "\n";
	
	echo Speller::spellCurrency(123.45, 'en', 'EUR'), "\n";
	echo Speller::spellCurrency(234.56, 'en', 'LTL'), "\n";
	echo Speller::spellCurrency(345.67, 'en', 'LVL'), "\n";
	echo Speller::spellCurrency(456.78, 'en', 'RUR'), "\n";
	echo Speller::spellCurrency(567.89, 'en', 'USD'), "\n";
	
	echo Speller::spellCurrency(123.45, 'es', 'EUR'), "\n";
	echo Speller::spellCurrency(234.56, 'es', 'LTL'), "\n";
	echo Speller::spellCurrency(345.67, 'es', 'LVL'), "\n";
	echo Speller::spellCurrency(456.78, 'es', 'RUR'), "\n";
	echo Speller::spellCurrency(567.89, 'es', 'USD'), "\n";
	
	echo Speller::spellCurrency(123.45, 'lv', 'EUR'), "\n";
	echo Speller::spellCurrency(234.56, 'lv', 'LTL'), "\n";
	echo Speller::spellCurrency(345.67, 'lv', 'LVL'), "\n";
	echo Speller::spellCurrency(456.78, 'lv', 'RUR'), "\n";
	echo Speller::spellCurrency(567.89, 'lv', 'USD'), "\n";
	
	echo Speller::spellCurrency(123.45, 'lt', 'EUR'), "\n";
	echo Speller::spellCurrency(234.56, 'lt', 'LTL'), "\n";
	echo Speller::spellCurrency(345.67, 'lt', 'LVL'), "\n";
	echo Speller::spellCurrency(456.78, 'lt', 'RUR'), "\n";
	echo Speller::spellCurrency(567.89, 'lt', 'USD'), "\n";
	
	echo Speller::spellCurrency(123.45, 'ru', 'EUR'), "\n";
	echo Speller::spellCurrency(234.56, 'ru', 'LTL'), "\n";
	echo Speller::spellCurrency(345.67, 'ru', 'LVL'), "\n";
	echo Speller::spellCurrency(456.78, 'ru', 'RUR'), "\n";
	echo Speller::spellCurrency(567.89, 'ru', 'USD'), "\n";
}
catch (\InvalidArgumentException $iae)
{
	echo $iae->getMessage();
}
