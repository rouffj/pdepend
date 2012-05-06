<?php
class PHP_Depend_AST_Function extends PHPParser_Node_Stmt_Function
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var
     */
    private $namespace;

    public function __construct( PHPParser_Node_Stmt_Function $function )
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