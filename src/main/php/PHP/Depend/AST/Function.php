<?php
class PHP_Depend_AST_Function extends PHPParser_Node_Stmt_Function implements PHP_Depend_AST_Node
{
    /**
     * @var string
     */
    public $id;

    /**
     * @var PHP_Depend_AST_FunctionRefs
     */
    private $refs;

    public function __construct(
        PHPParser_Node_Stmt_Function $function,
        PHP_Depend_AST_FunctionRefs $refs
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

        $this->refs           = $refs;
        $this->attributes     = $function->attributes;
        $this->namespacedName = $function->namespacedName;

        $this->refs->initialize( $this );
    }

    public function getId()
    {
        return $this->getAttribute( 'id' );
    }

    public function getNamespace()
    {
        return $this->refs->getNamespace();
    }

    public function __wakeup()
    {
        $this->refs->initialize( $this );
    }
}