<?php
class PHP_Depend_AST_CompilationUnit
{
    /**
     * @var PHPParser_Node_Stmt[]
     */
    public $stmts = array();

    /**
     * @param PHPParser_Node_Stmt[] $stmts
     */
    public function __construct( array $stmts )
    {
        $this->stmts = $stmts;
    }
}