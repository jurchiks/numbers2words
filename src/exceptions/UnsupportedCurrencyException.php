<?php
namespace js\tools\numbers2words\exceptions;

class UnsupportedCurrencyException extends SpellerException
{
	public function __construct(string $currency)
	{
		parent::__construct(sprintf('Currency "%s" is not supported.', $currency));
	}
}
