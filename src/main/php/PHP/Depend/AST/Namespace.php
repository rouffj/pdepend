<?php
class PHP_Depend_AST_Namespace extends PHPParser_Node_Stmt_Namespace
{
    private $id;

    public function __construct( PHPParser_Node_Stmt_Namespace $namespace )
    {
        parent::__construct(
            $namespace->name,
            $namespace->stmts,
            $namespace->line,
            $namespace->docComment
        );

        $this->attributes = $namespace->attributes;
    }

    public function setId( $id )
    {
        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }
}