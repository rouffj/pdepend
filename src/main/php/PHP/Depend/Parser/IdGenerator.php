<?php
class PHP_Depend_Parser_IdGenerator extends PHPParser_NodeVisitorAbstract
{
    private $parts = array();

    public function setFile( $file )
    {
        $this->parts = array(
            sprintf(
                '%s~%s~',
                base_convert( md5( $file ), 16, 35 ),
                substr( basename( $file ), -30, 30 )
            )
        );
    }

    public function enterNode( PHPParser_Node $node )
    {
        if ( $node instanceof PHPParser_Node_Stmt_Class )
        {
            array_push( $this->parts, "\\{$node->name}" );
        }
        else if ( $node instanceof PHPParser_Node_Stmt_Interface )
        {
            array_push( $this->parts, "\\{$node->name}" );
        }
        else if ( $node instanceof PHPParser_Node_Stmt_Namespace )
        {
            array_push( $this->parts, $node->name );
        }
        else if ( $node instanceof PHPParser_Node_Stmt_PropertyProperty )
        {
            array_push( $this->parts, "\${$node->name}" );
        }
        else if ( $node instanceof PHPParser_Node_Stmt_ClassMethod )
        {
            array_push( $this->parts, "::{$node->name}()" );
        }
        else if ( $node instanceof PHPParser_Node_Stmt_Function )
        {
            array_push( $this->parts, "\\{$node->name}()" );
        }
    }

    public function leaveNode( PHPParser_Node $node )
    {
        if ( $node instanceof PHPParser_Node_Stmt_Class )
        {
            $id = join( '', $this->parts );
            array_pop( $this->parts );
        }
        else if ( $node instanceof PHPParser_Node_Stmt_Interface )
        {
            $id = join( '', $this->parts );
            array_pop( $this->parts );
        }
        else if ( $node instanceof PHPParser_Node_Stmt_Namespace )
        {
            $id = $node->name;
            array_pop( $this->parts );
        }
        else if ( $node instanceof PHPParser_Node_Stmt_PropertyProperty )
        {
            $id = join( '', $this->parts );
            array_pop( $this->parts );
        }
        else if ( $node instanceof PHPParser_Node_Stmt_ClassMethod )
        {
            $id = join( '', $this->parts );
            array_pop( $this->parts );
        }
        else if ( $node instanceof PHPParser_Node_Stmt_Function )
        {
            $id = join( '', $this->parts );
            array_pop( $this->parts );
        }

        if ( isset( $id ) )
        {
            $node->setAttribute(
                'id',
                ltrim( preg_replace( '([^a-z0-9:\(\)\.\~]+)i', '-', $id ), '-' )
            );
        }
    }
}