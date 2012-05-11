<?php
class PHP_Depend_AST_FunctionRefs
{
    /**
     * @var PHP_Depend_Context
     */
    private $context;

    /**
     * @var string
     */
    private $namespaceId;

    public function __construct( PHP_Depend_Context $context, $namespaceId )
    {
        $this->context = $this->context = $context;

        $this->namespaceId = $namespaceId;
    }

    public function getNamespace()
    {
        if ( $namespace = $this->context->getNode( $this->namespaceId ) )
        {
            return $namespace;
        }
        var_dump($this->namespaceId);
        // TODO Return dummy namespace
    }

    public function initialize( PHP_Depend_AST_Function $function )
    {
        $this->context->registerNode( $function );
    }
}
