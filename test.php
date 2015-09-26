<?php
spl_autoload_register(
	function ($className)
	{
		$ds = DIRECTORY_SEPARATOR;
		$className = str_replace('\\', $ds, $className);
		$path = __DIR__ . $ds . $className . '.php';
		
		if (!is_readable($path))
		{
			return false;
		}
		
		require $path;
		return true;
	},
	true
);

try
{
	echo NumberConversion::spellNumber(123.45, 'en'), "\n";
	echo NumberConversion::spellNumber(234.56, 'es'), "\n";
	echo NumberConversion::spellNumber(345.67, 'lt'), "\n";
	echo NumberConversion::spellNumber(456.78, 'lv'), "\n";
	echo NumberConversion::spellNumber(567.89, 'ru'), "\n";
	
	echo NumberConversion::spellCurrency(123.45, 'en', 'EUR'), "\n";
	echo NumberConversion::spellCurrency(234.56, 'en', 'LTL'), "\n";
	echo NumberConversion::spellCurrency(345.67, 'en', 'LVL'), "\n";
	echo NumberConversion::spellCurrency(456.78, 'en', 'RUR'), "\n";
	echo NumberConversion::spellCurrency(567.89, 'en', 'USD'), "\n";
	
	echo NumberConversion::spellCurrency(123.45, 'es', 'EUR'), "\n";
	echo NumberConversion::spellCurrency(234.56, 'es', 'LTL'), "\n";
	echo NumberConversion::spellCurrency(345.67, 'es', 'LVL'), "\n";
	echo NumberConversion::spellCurrency(456.78, 'es', 'RUR'), "\n";
	echo NumberConversion::spellCurrency(567.89, 'es', 'USD'), "\n";
	
	echo NumberConversion::spellCurrency(123.45, 'lv', 'EUR'), "\n";
	echo NumberConversion::spellCurrency(234.56, 'lv', 'LTL'), "\n";
	echo NumberConversion::spellCurrency(345.67, 'lv', 'LVL'), "\n";
	echo NumberConversion::spellCurrency(456.78, 'lv', 'RUR'), "\n";
	echo NumberConversion::spellCurrency(567.89, 'lv', 'USD'), "\n";
	
	echo NumberConversion::spellCurrency(123.45, 'lt', 'EUR'), "\n";
	echo NumberConversion::spellCurrency(234.56, 'lt', 'LTL'), "\n";
	echo NumberConversion::spellCurrency(345.67, 'lt', 'LVL'), "\n";
	echo NumberConversion::spellCurrency(456.78, 'lt', 'RUR'), "\n";
	echo NumberConversion::spellCurrency(567.89, 'lt', 'USD'), "\n";
	
	echo NumberConversion::spellCurrency(123.45, 'ru', 'EUR'), "\n";
	echo NumberConversion::spellCurrency(234.56, 'ru', 'LTL'), "\n";
	echo NumberConversion::spellCurrency(345.67, 'ru', 'LVL'), "\n";
	echo NumberConversion::spellCurrency(456.78, 'ru', 'RUR'), "\n";
	echo NumberConversion::spellCurrency(567.89, 'ru', 'USD'), "\n";
}
catch (InvalidArgumentException $iae)
{
	echo $iae->getMessage();
}
