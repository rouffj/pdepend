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
 * @subpackage AST
 * @author     Manuel Pichler <mapi@pdepend.org>
 * @copyright  2008-2012 Manuel Pichler. All rights reserved.
 * @license    http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @version    SVN: $Id$
 * @link       http://pdepend.org/
 */

/**
 * Container class that holds nodes referenced by a method.
 *
 * @category   QualityAssurance
 * @package    PHP_Depend
 * @subpackage AST
 * @author     Manuel Pichler <mapi@pdepend.org>
 * @copyright  2008-2012 Manuel Pichler. All rights reserved.
 * @license    http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @version    Release: @package_version@
 * @link       http://pdepend.org/
 * @since      2.0.0
 */
class PHP_Depend_AST_MethodRefs
{
    /**
     * @var PHP_Depend_Context
     */
    private $context;

    /**
     * @var string
     */
    private $namespace;

    /**
     * @var string
     */
    private $declaringType;

    /**
     * Constructs a new reference context for an interface.
     *
     * @param PHP_Depend_Context $context
     * @param string $namespace
     * @param string $declaringType
     */
    public function __construct( PHP_Depend_Context $context, $namespace, $declaringType )
    {
        $this->context       = $context;
        $this->namespace     = $namespace;
        $this->declaringType = $declaringType;
    }

    /**
     * Returns the namespace for the context interface.
     *
     * @return PHP_Depend_AST_Namespace
     */
    public function getNamespace()
    {
        if ( $namespace = $this->context->getNode( $this->namespace ) )
        {
            return $namespace;
        }
        // TODO Return dummy namespace
    }

    /**
     * Returns the declaring type for the context method.
     *
     * @return PHP_Depend_AST_Type
     */
    public function getDeclaringType()
    {
        if ( $declaringType = $this->context->getNode( $this->declaringType ) )
        {
            return $declaringType;
        }
        // TODO Return dummy class
    }

    /**
     * Initializes this reference instance for the given method.
     *
     * @param PHP_Depend_AST_Method $method
     * @return void
     */
    public function initialize( PHP_Depend_AST_Method $method )
    {
        $this->context->registerNode( $method );
    }
}