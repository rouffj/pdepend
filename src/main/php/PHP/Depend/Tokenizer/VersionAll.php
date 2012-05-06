<?php
class PHP_Depend_Tokenizer_VersionAll
    extends PHPParser_Lexer_Emulative
    implements PHP_Depend_Tokenizer
{
    private $file;

    public function __construct( $file )
    {
        parent::__construct( file_get_contents( $file ) );

        $this->file = $file;
    }

    public function getFile()
    {
        return $this->file;
    }
}