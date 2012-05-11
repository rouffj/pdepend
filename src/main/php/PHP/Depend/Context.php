<?php
class PHP_Depend_Context
{
    public static $nodes = array();

    public function registerNode( PHP_Depend_AST_Node $node )
    {
        self::$nodes[$node->getId()] = $node;
    }

    public function getNode( $id )
    {
        if ( isset( self::$nodes[$id] ) )
        {
            return self::$nodes[$id];
        }
        return null;
    }
}