<?php
class PHP_Depend_Parser
{
    /**
     * @var PHPParser_Parser
     */
    private $parser;

    /**
     * @var PHP_Depend_Parser_IdGenerator
     */
    private $idGenerator;

    public function __construct()
    {
        $this->parser = new PHPParser_Parser();

        $this->idGenerator = new PHP_Depend_Parser_IdGenerator();

        $this->traverser = new PHPParser_NodeTraverser();
        $this->traverser->addVisitor( new PHPParser_NodeVisitor_NameResolver() );
        $this->traverser->addVisitor( new PHP_Depend_Parser_TypeGenerator() );
        $this->traverser->addVisitor( $this->idGenerator );
    }

    /**
     *
     * @param PHP_Depend_Tokenizer $tokenizer
     * @return PHP_Depend_AST_CompilationUnit
     */
    public function parse( PHP_Depend_Tokenizer $tokenizer )
    {
        $this->idGenerator->setFile( $tokenizer->getFile() );

        return new PHP_Depend_AST_CompilationUnit(
            $this->traverser->traverse(
                $this->parser->parse( $tokenizer )
            )
        );
    }
}