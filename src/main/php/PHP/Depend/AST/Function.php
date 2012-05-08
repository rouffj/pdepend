<?php
class PHP_Depend_AST_Function extends PHPParser_Node_Stmt_Function implements PHP_Depend_AST_Node
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
        PHPParser_Node_Stmt_Function $function,
        PHP_Depend_AST_Namespace $namespace
    )
    {
        parent::__construct(
            $function->name,
            array(
                'byRef'  => $function->byRef,
                'params' => $function->params,
                'stmts'  => $function->stmts,
            ),
            $function->line,
            $function->docComment
        );

        $this->attributes     = $function->attributes;
        $this->namespacedName = $function->namespacedName;

        $this->namespace = $namespace;
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