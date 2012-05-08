<?php
class PHP_Depend_AST_Method extends PHPParser_Node_Stmt_ClassMethod implements PHP_Depend_AST_Node
{
    /**
     * @var string
     */
    public $id;

    /**
     * @var PHP_Depend_AST_Namespace
     */
    public $namespace;

    public function __construct(
        PHPParser_Node_Stmt_ClassMethod $method,
        PHP_Depend_AST_Namespace $namespace = null
    )
    {
        parent::__construct(
            $method->name,
            array(
                'type'   => $method->type,
                'byRef'  => $method->byRef,
                'params' => $method->params,
                'stmts'  => $method->stmts,
            ),
            $method->line,
            $method->docComment
        );

        $this->attributes = $method->attributes;

        $this->namespace  = $namespace;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getNamespace()
    {
        return $this->namespace;
    }
}