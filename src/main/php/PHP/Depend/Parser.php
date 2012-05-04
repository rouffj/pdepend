<?php
class PHP_Depend_Parser
{
    /**
     * @var PHPParser_Parser
     */
    private $parser;

    public function __construct()
    {
        $this->parser = new PHPParser_Parser();
    }

    /**
     *
     * @param PHP_Depend_Tokenizer $tokenizer
     * @return PHP_Depend_AST_CompilationUnit
     */
    public function parse(PHP_Depend_Tokenizer $tokenizer)
    {
        return new PHP_Depend_AST_CompilationUnit(
            $this->parser->parse($tokenizer)
        );
    }
}