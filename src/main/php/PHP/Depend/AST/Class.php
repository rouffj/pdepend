<?php
class PHP_Depend_AST_Class extends PHPParser_Node_Stmt_Class implements PHP_Depend_AST_Type
{
    /**
     * @var PHP_Depend_AST_ClassRefs
     */
    private $refs;

    public function __construct( PHPParser_Node_Stmt_Class $class, PHP_Depend_AST_ClassRefs $refs )
    {
        parent::__construct(
            $class->name,
            array(
                'type'       => $class->type,
                'extends'    => $class->extends,
                'implements' => $class->implements,
                'stmts'      => $class->stmts,
            ),
            $class->line,
            $class->docComment
        );

        $this->refs           = $refs;
        $this->attributes     = $class->attributes;
        $this->namespacedName = $class->namespacedName;

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