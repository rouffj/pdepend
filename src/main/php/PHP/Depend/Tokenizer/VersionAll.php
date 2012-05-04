<?php
class PHP_Depend_Tokenizer_VersionAll
    extends PHPParser_Lexer_Emulative
    implements PHP_Depend_Tokenizer
{
    public function __construct($file)
    {
        parent::__construct(file_get_contents($file));
    }
}