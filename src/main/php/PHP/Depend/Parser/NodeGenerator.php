<?php
/**
 * This file is part of PHP_Depend.
 *
 * PHP Version 5
 *
 * Copyright (c) 2008-2012, Manuel Pichler <mapi@pdepend.org>.
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions
 * are met:
 *
 *   * Redistributions of source code must retain the above copyright
 *     notice, this list of conditions and the following disclaimer.
 *
 *   * Redistributions in binary form must reproduce the above copyright
 *     notice, this list of conditions and the following disclaimer in
 *     the documentation and/or other materials provided with the
 *     distribution.
 *
 *   * Neither the name of Manuel Pichler nor the names of his
 *     contributors may be used to endorse or promote products derived
 *     from this software without specific prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS
 * FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE
 * COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT,
 * INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING,
 * BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
 * LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER
 * CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT
 * LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN
 * ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE
 * POSSIBILITY OF SUCH DAMAGE.
 *
 * @category   QualityAssurance
 * @package    PHP_Depend
 * @subpackage Parser
 * @author     Manuel Pichler <mapi@pdepend.org>
 * @copyright  2008-2012 Manuel Pichler. All rights reserved.
 * @license    http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @version    SVN: $Id$
 * @link       http://pdepend.org/
 */

/**
 * Visitor class that generates custom nodes used by PHP_Depend.
 *
 * @category   QualityAssurance
 * @package    PHP_Depend
 * @subpackage Parser
 * @author     Manuel Pichler <mapi@pdepend.org>
 * @copyright  2008-2012 Manuel Pichler. All rights reserved.
 * @license    http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @version    Release: @package_version@
 * @link       http://pdepend.org/
 * @since      2.0.0
 */
class PHP_Depend_Parser_NodeGenerator extends PHPParser_NodeVisitorAbstract
{
    /**
     * @var string
     */
    private $declaringType;

    /**
     * @var string
     */
    private $declaringNamespace;

    /**
     * @var string
     */
    private $declaringPackage;

    /**
     * @var PHP_Depend_Context
     */
    private $context;

    /**
     * Initializes the node context.
     */
    public function __construct()
    {
        $this->context = new PHP_Depend_Context();
    }

    /**
     * Called when entering a node.
     *
     * Return value semantics:
     *  * null:      $node stays as-is
     *  * otherwise: $node is set to the return value
     *
     * @param PHPParser_Node $node
     * @return null|PHPParser_Node
     */
    public function enterNode(PHPParser_Node $node)
    {
        if ( $node instanceof PHPParser_Node_Stmt_Class
            || $node instanceof PHPParser_Node_Stmt_Interface )
        {
            $this->declaringType    = (string) $node->namespacedName;
            $this->declaringPackage = $this->extractNamespaceName( $node );
        }
        else if ( $node instanceof PHPParser_Node_Stmt_Namespace )
        {
            $this->declaringNamespace = (string) $node->name;
        }
    }

    /**
     * Sets a unique identifier on the given node. The ID will be stored in a
     * node attribute named <b>"id"</b>.
     *
     * @param PHPParser_Node $node Node
     * @return null|PHPParser_Node
     */
    public function leaveNode( PHPParser_Node $node )
    {
        if ( $node instanceof PHPParser_Node_Stmt_Namespace )
        {
            $this->declaringNamespace = null;

            return new PHP_Depend_AST_Namespace(
                $node, new PHP_Depend_AST_NamespaceRefs( $this->context )
            );
        }
        else if ( $node instanceof PHPParser_Node_Stmt_Class )
        {
            $this->declaringType    = null;
            $this->declaringPackage = null;

            $parentClassId = null;
            if ( $node->extends )
            {
                $parentClassId = (string) $node->extends;
            }

            $implemented = array();
            foreach ( $node->implements as $implements )
            {
                $implemented[] = (string) $implements;
            }

            return $this->wrapOptionalNamespace(
                new PHP_Depend_AST_Class(
                    $node,
                    new PHP_Depend_AST_ClassRefs(
                        $this->context,
                        $this->extractNamespaceName( $node ),
                        $parentClassId,
                        $implemented
                    )
                )
            );
        }
        else if ( $node instanceof PHPParser_Node_Stmt_Interface )
        {
            $this->declaringType    = null;
            $this->declaringPackage = null;

            $extends = array();
            foreach ( $node->extends as $extend )
            {
                $extends[] = (string) $extend;
            }

            return $this->wrapOptionalNamespace(
                new PHP_Depend_AST_Interface(
                    $node,
                    new PHP_Depend_AST_InterfaceRefs(
                        $this->context,
                        $this->extractNamespaceName( $node ),
                        $extends
                    )
                )
            );
        }
        else if ( $node instanceof PHPParser_Node_Stmt_PropertyProperty )
        {

        }
        else if ( $node instanceof PHPParser_Node_Stmt_ClassMethod )
        {
            return new PHP_Depend_AST_Method(
                $node,
                new PHP_Depend_AST_MethodRefs(
                    $this->context,
                    $this->extractNamespaceName( $node ),
                    $this->declaringType
                )
            );
        }
        else if ( $node instanceof PHPParser_Node_Stmt_Function )
        {
            $this->declaringPackage = null;

            return $this->wrapOptionalNamespace(
                new PHP_Depend_AST_Function(
                    $node,
                    new PHP_Depend_AST_FunctionRefs(
                        $this->context,
                        $this->extractNamespaceName( $node )
                    )
                )
            );
        }
    }

    /**
     * Extracts the best matching namespace for the given node.
     *
     * This method first looks for a currently active namespace. If this exists
     * it will return the namespace name. Then this method tries to extract a
     * package tag from the node's doc comment. If it exists this tag is used.
     * Then it tries to reuse a previously extracted package tag. And finally
     * this method returns the pseudo global namespace.
     *
     * @param PHPParser_Node $node
     * @return string
     */
    private function extractNamespaceName( PHPParser_Node $node )
    {
        if ( is_string( $this->declaringNamespace ) )
        {
            return $this->declaringNamespace;
        }
        else if ( preg_match( '(\*\s*@package\s+([^\s\*]+))', $node->getDocComment(), $match ) )
        {
            return ( $this->declaringPackage = $match[1] );
        }
        else if ( is_string( $this->declaringPackage ) )
        {
            return $this->declaringPackage;
        }
        return ( $this->declaringPackage = "+global" );
    }

    /**
     * This method will wrap the given node with a pseudo namespace object,
     * when the node itself is not within a valid php namespace.
     *
     * @param PHP_Depend_AST_Node $node
     * @return PHP_Depend_AST_Namespace|PHP_Depend_AST_Node
     */
    private function wrapOptionalNamespace( PHP_Depend_AST_Node $node )
    {
        if ( is_string( $this->declaringNamespace ) )
        {
            return $node;
        }

        return new PHP_Depend_AST_Namespace(
            new PHPParser_Node_Stmt_Namespace(
                new PHPParser_Node_Name( $this->extractNamespaceName( $node ) ),
                array( $node ),
                array( 'id'  =>  $this->extractNamespaceName( $node ) . '#n' )
            ),
            new PHP_Depend_AST_NamespaceRefs( $this->context )
        );
    }
}