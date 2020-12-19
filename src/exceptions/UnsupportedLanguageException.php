<?php
namespace js\tools\numbers2words\exceptions;

class UnsupportedLanguageException extends InvalidArgumentException
{
	public function __construct(string $language)
	{
		parent::__construct(sprintf('Language "%s" is not supported.', $language));
	}
}
