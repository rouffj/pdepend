<?php
class PHP_Depend_AST_Class extends PHPParser_Node_Stmt_Class implements PHP_Depend_AST_Type
{
    private $id;

    private $namespace;

    public function __construct( PHPParser_Node_Stmt_Class $class, PHP_Depend_AST_Namespace $namespace )
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

        $this->attributes     = $class->attributes;
        $this->namespacedName = $class->namespacedName;

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