<?php
class PHP_Depend_Context
{
    public static $nodes = array(
        'namespaces'  =>  array(),
        'classes'     =>  array(),
        'interfaces'  =>  array(),
        'functions'   =>  array(),
        'methods'     =>  array()
    );

    public function registerNode( PHP_Depend_AST_Node $node )
    {
        if ( $node instanceof PHP_Depend_AST_Class )
        {
            self::$nodes['classes'][$node->getId()] = $node;
        }
        else if ( $node instanceof PHP_Depend_AST_Interface )
        {
            self::$nodes['interfaces'][$node->getId()] = $node;
        }
        else if ( $node instanceof PHP_Depend_AST_Namespace )
        {
            self::$nodes['namespaces'][$node->getId()] = $node;
        }
        else if ( $node instanceof PHP_Depend_AST_Function )
        {
            self::$nodes['functions'][$node->getId()] = $node;
        }
        else if ( $node instanceof PHP_Depend_AST_Method )
        {
            self::$nodes['methods'][$node->getId()] = $node;
        }
    }

    public function getNamespace( $id )
    {
        return $this->getNode( $id, 'namespaces' );
    }

    public function getClass( $id )
    {
        return $this->getNode( $id, 'classes' );
    }

    public function getInterface( $id )
    {
        return $this->getNode( $id, 'interfaces' );
    }

    public function getType( $id )
    {
        if ( $type = $this->getNode( $id, 'interfaces' ) )
        {
            return $type;
        }
        return $this->getNode( $id, 'classes' );
    }

    public function getMethod( $id )
    {
        return $this->getNode( $id, 'methods' );
    }

    public function getFunction( $id )
    {
        return $this->getNode( $id, 'functions' );
    }

    private function getNode( $id, $type )
    {
        if ( isset( self::$nodes[$type][$id] ) )
        {
            return self::$nodes[$type][$id];
        }
        return null;
    }
}