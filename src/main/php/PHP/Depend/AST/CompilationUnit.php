<?php
/**
 * @property PHPParser_Node_Stmt[] $stmts
 */
class PHP_Depend_AST_CompilationUnit extends PHPParser_NodeAbstract
{
    /**
     * Constructs a new compilation unit.
     *
     * @param PHPParser_Node_Stmt[] $stmts
     */
    public function __construct( array $stmts )
    {
        parent::__construct( array( 'stmts' => $stmts ) );
    }
}