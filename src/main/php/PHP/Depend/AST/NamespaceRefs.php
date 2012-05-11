<?php
class PHP_Depend_AST_NamespaceRefs
{
    /**
     * @var PHP_Depend_Context
     */
    private $context;

    public function __construct( PHP_Depend_Context $context )
    {
        $this->context = $context;
    }

    public function initialize( PHP_Depend_AST_Namespace $namespace )
    {
        $this->context->registerNode( $namespace );
    }
}
