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
class PHP_Depend_Parser_TypeGenerator extends PHPParser_NodeVisitorAbstract
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
     * @var PHP_Depend_Context
     */
    private $context;

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
     * @param PHPParser_Node $node Node
     *
     * @return null|PHPParser_Node Node
     */
    public function enterNode(PHPParser_Node $node)
    {
        if ( $node instanceof PHPParser_Node_Stmt_Class
            || $node instanceof PHPParser_Node_Stmt_Interface )
        {
            $this->declaringNamespace = $this->extractNamespaceName( $node );
            $this->declaringType      = (string) $node->namespacedName;
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
            return new PHP_Depend_AST_Namespace(
                $node, new PHP_Depend_AST_NamespaceRefs( $this->context )
            );
        }
        else if ( $node instanceof PHPParser_Node_Stmt_Class )
        {
            /** @var $node PHPParser_Node_Stmt_Class */
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

            return new PHP_Depend_AST_Class(
                $node,
                new PHP_Depend_AST_ClassRefs(
                    $this->context,
                    $this->extractNamespaceName( $node ),
                    $parentClassId,
                    array()
                )
            );
        }
        else if ( $node instanceof PHPParser_Node_Stmt_Interface )
        {
            $extends = array();
            foreach ( $node->extends as $extend )
            {
                $extends[] = (string) $extend;
            }

            return new PHP_Depend_AST_Interface(
                $node,
                new PHP_Depend_AST_InterfaceRefs(
                    $this->context,
                    $this->extractNamespaceName( $node ),
                    $extends
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
                    $this->declaringNamespace,
                    $this->declaringType
                )
            );
        }
        else if ( $node instanceof PHPParser_Node_Stmt_Function )
        {
            return new PHP_Depend_AST_Function(
                $node,
                new PHP_Depend_AST_FunctionRefs(
                    $this->context,
                    $this->extractNamespaceName( $node )
                )
            );
        }
    }

    private function extractNamespace( PHPParser_Node $node )
    {
        if ( isset( $node->namespacedName ) )
        {
            return new PHP_Depend_AST_Namespace(
                new PHPParser_Node_Stmt_Namespace(
                    new PHPParser_Node_Name(
                        substr(
                            $node->namespacedName,
                            0,
                            strrpos( $node->namespacedName, '\\' )
                        )
                    )
                ),
                new PHP_Depend_AST_NamespaceRefs(
                    $this->context
                )
            );
        }
        return "";
    }

    private function extractNamespaceName( PHPParser_Node $node )
    {
        if ( isset( $node->namespacedName ) )
        {
            return substr(
                $node->namespacedName,
                0,
                strrpos( $node->namespacedName, '\\' )
            );
        }
        return "";
    }
}