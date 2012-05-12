<?php
class PHP_Depend_AST_Namespace
    extends PHPParser_Node_Stmt_Namespace
    implements PHP_Depend_AST_Node
{

    /**
     * @var PHP_Depend_AST_NamespaceRefs
     */
    private $refs;

    public function __construct( PHPParser_Node_Stmt_Namespace $namespace, PHP_Depend_AST_NamespaceRefs $refs )
    {
        parent::__construct(
            $namespace->name,
            $namespace->stmts,
            $namespace->attributes
        );

        $this->refs = $refs;

        $this->refs->initialize( $this );
    }

    public function getId()
    {
        return $this->getAttribute( 'id' );
    }

    public function __wakeup()
    {
        $this->refs->initialize( $this );
    }
}