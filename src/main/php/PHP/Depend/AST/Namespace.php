<?php
class PHP_Depend_AST_Namespace
    extends PHPParser_Node_Stmt_Namespace
    implements PHP_Depend_AST_Node
{
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

    public function getId()
    {
        return (string) $this->name;
    }

    public function getNamespace()
    {
        return null;
    }
}