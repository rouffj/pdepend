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
 * @subpackage Metrics
 * @author     Manuel Pichler <mapi@pdepend.org>
 * @copyright  2008-2012 Manuel Pichler. All rights reserved.
 * @license    http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @version    SVN: $Id$
 * @link       http://pdepend.org/
 */

/**
 * This analyzer collects different count metrics for code artifacts like
 * classes, methods, functions or packages.
 *
 * @category   QualityAssurance
 * @package    PHP_Depend
 * @subpackage Metrics
 * @author     Manuel Pichler <mapi@pdepend.org>
 * @copyright  2008-2012 Manuel Pichler. All rights reserved.
 * @license    http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @version    Release: @package_version@
 * @link       http://pdepend.org/
 */
class PHP_Depend_Metrics_NodeCount_Analyzer
    extends PHP_Depend_Metrics_AbstractAnalyzer
    implements PHP_Depend_Metrics_Analyzer,
    PHP_Depend_Metrics_NodeAware,
    PHP_Depend_Metrics_ProjectAware
{
    /**
     * Type of this analyzer class.
     */
    const CLAZZ = __CLASS__;

    /**
     * Metrics provided by the analyzer implementation.
     */
    const M_NUMBER_OF_PACKAGES = 'nop',
        M_NUMBER_OF_CLASSES    = 'noc',
        M_NUMBER_OF_INTERFACES = 'noi',
        M_NUMBER_OF_METHODS    = 'nom',
        M_NUMBER_OF_FUNCTIONS  = 'nof';

    /**
     * Number Of Packages.
     *
     * @var integer
     */
    private $numberOfPackages = 0;

    /**
     * Number Of Classes.
     *
     * @var integer
     */
    private $numberOfClasses = 0;

    /**
     * Number Of Interfaces.
     *
     * @var integer
     */
    private $numberOfInterfaces = 0;

    /**
     * Number Of Methods.
     *
     * @var integer
     */
    private $numberOfMethods = 0;

    /**
     * Number Of Functions.
     *
     * @var integer
     */
    private $numberOfFunctions = 0;

    /**
     * Collected node metrics
     *
     * @var array(string=>array)
     */
    private $_nodeMetrics = null;

    /**
     * This method will return an <b>array</b> with all generated metric values
     * for the given node or node identifier. If there are no metrics for the
     * requested node, this method will return an empty <b>array</b>.
     *
     * <code>
     * array(
     *     'noc'  =>  23,
     *     'nom'  =>  17,
     *     'nof'  =>  42
     * )
     * </code>
     *
     * @param PHP_Depend_AST_Node|string $node The context node instance.
     *
     * @return array
     */
    public function getNodeMetrics( $node )
    {
        $nodeId = (string) is_object( $node ) ? $node->getId() : $node;

        if ( isset( $this->_nodeMetrics[$nodeId] ) )
        {
            return $this->_nodeMetrics[$nodeId];
        }
        return array();
    }

    /**
     * Provides the project summary as an <b>array</b>.
     *
     * <code>
     * array(
     *     'nop'  =>  23,
     *     'noc'  =>  17,
     *     'noi'  =>  23,
     *     'nom'  =>  42,
     *     'nof'  =>  17
     * )
     * </code>
     *
     * @return array(string=>mixed)
     */
    public function getProjectMetrics()
    {
        return array(
            self::M_NUMBER_OF_PACKAGES => $this->numberOfPackages,
            self::M_NUMBER_OF_CLASSES => $this->numberOfClasses,
            self::M_NUMBER_OF_INTERFACES => $this->numberOfInterfaces,
            self::M_NUMBER_OF_METHODS => $this->numberOfMethods,
            self::M_NUMBER_OF_FUNCTIONS => $this->numberOfFunctions
        );
    }

    /**
     * Processes all compilation units.
     *
     * @param PHP_Depend_AST_CompilationUnit[] $compilationUnits
     * @return void
     */
    public function analyze( array $compilationUnits )
    {
        // Check for previous run
        if ( $this->_nodeMetrics === null ) {

            $this->fireStartAnalyzer();

            // Init node metrics
            $this->_nodeMetrics = array();

            $processor = new MetricProcessor($this);

            foreach ( $compilationUnits as $compilationUnit ) {
                $processor->process( $compilationUnit );
            }

            $this->fireEndAnalyzer();
        }
    }

    /**
     * Visits a class node.
     *
     * @param PHP_Depend_Code_Class $class The current class node.
     *
     * @return void
     * @see PHP_Depend_VisitorI::visitClass()
     */
    public function visitClass( PHP_Depend_Code_Class $class )
    {
        if ( false === $class->isUserDefined() ) {
            return;
        }

        $this->fireStartClass( $class );

        // Update global class count
        ++$this->numberOfClasses;

        // Update parent package
        $packageUUID = $class->getPackage()->getUUID();
        ++$this->_nodeMetrics[$packageUUID][self::M_NUMBER_OF_CLASSES];

        $this->_nodeMetrics[$class->getUUID()] = array(
            self::M_NUMBER_OF_METHODS => 0
        );

        foreach ( $class->getMethods() as $method ) {
            $method->accept( $this );
        }

        $this->fireEndClass( $class );
    }

    /**
     * Visits a function node.
     *
     * @param PHP_Depend_Code_Function $function The current function node.
     *
     * @return void
     * @see PHP_Depend_VisitorI::visitFunction()
     */
    public function visitFunction( PHP_Depend_Code_Function $function )
    {
        $this->fireStartFunction( $function );

        // Update global function count
        ++$this->numberOfFunctions;

        // Update parent package
        $packageUUID = $function->getPackage()->getUUID();
        ++$this->_nodeMetrics[$packageUUID][self::M_NUMBER_OF_FUNCTIONS];

        $this->fireEndFunction( $function );
    }

    /**
     * Visits a code interface object.
     *
     * @param PHP_Depend_Code_Interface $interface The context code interface.
     *
     * @return void
     * @see PHP_Depend_VisitorI::visitInterface()
     */
    public function visitInterface( PHP_Depend_Code_Interface $interface )
    {
        if ( false === $interface->isUserDefined() ) {
            return;
        }

        $this->fireStartInterface( $interface );

        // Update global class count
        ++$this->numberOfInterfaces;

        // Update parent package
        $packageUUID = $interface->getPackage()->getUUID();
        ++$this->_nodeMetrics[$packageUUID][self::M_NUMBER_OF_INTERFACES];

        $this->_nodeMetrics[$interface->getUUID()] = array(
            self::M_NUMBER_OF_METHODS => 0
        );

        foreach ( $interface->getMethods() as $method ) {
            $method->accept( $this );
        }

        $this->fireEndInterface( $interface );
    }

    /**
     * Visits a method node.
     *
     * @param PHP_Depend_Code_Class $method The method class node.
     *
     * @return void
     * @see PHP_Depend_VisitorI::visitMethod()
     */
    public function visitMethod( PHP_Depend_Code_Method $method )
    {
        $this->fireStartMethod( $method );

        // Update global method count
        ++$this->numberOfMethods;

        $parent = $method->getParent();

        // Update parent class or interface
        $parentUUID = $parent->getUUID();
        ++$this->_nodeMetrics[$parentUUID][self::M_NUMBER_OF_METHODS];

        // Update parent package
        $packageUUID = $parent->getPackage()->getUUID();
        ++$this->_nodeMetrics[$packageUUID][self::M_NUMBER_OF_METHODS];

        $this->fireEndMethod( $method );
    }

    public function visitClassBefore( PHP_Depend_AST_Class $class )
    {
        ++$this->numberOfClasses;

        $namespace = $class->getNamespace();
        $this->visitNamespaceBefore( $namespace );

        ++$this->_nodeMetrics[$namespace->getId()][self::M_NUMBER_OF_CLASSES];
    }

    public function visitStmtInterfaceBefore( PHPParser_Node_Stmt_Interface $interface )
    {
        ++$this->numberOfInterfaces;
    }

    public function visitMethodBefore( PHP_Depend_AST_Method $method )
    {
        ++$this->numberOfMethods;

        $method->getNamespace();
    }

    public function visitFunctionBefore( PHP_Depend_AST_Function $function )
    {
        ++$this->numberOfFunctions;

        $namespace = $function->getNamespace();
        $this->visitNamespaceBefore( $namespace );

        ++$this->_nodeMetrics[$namespace->getId()][self::M_NUMBER_OF_FUNCTIONS];
    }

    public function visitNamespaceBefore( PHPParser_Node_Stmt_Namespace $ns )
    {
        if ( false === isset( $this->_nodeMetrics[$ns->getId()] ) )
        {
            $this->_nodeMetrics[$ns->getId()] = array(
                self::M_NUMBER_OF_CLASSES     =>  0,
                self::M_NUMBER_OF_INTERFACES  =>  0,
                self::M_NUMBER_OF_METHODS     =>  0,
                self::M_NUMBER_OF_FUNCTIONS   =>  0
            );

            ++$this->numberOfPackages;
        }
    }
}

class MetricProcessor extends PHPParser_NodeTraverser implements PHPParser_NodeVisitor
{
    /**
     * @var PHP_Depend_Metrics_Analyzer[]
     */
    private $analyzers = array();

    private $data = array();

    private $callbacks = array();

    public function __construct( $analyzer )
    {
        $class = get_class( $analyzer );

        foreach ( get_class_methods( $analyzer ) as $method )
        {
            if ( 0 === preg_match( '(^visit[\w\d]+(Before|After)$)', $method ) )
            {
                continue;
            }
            if ( false === isset( $this->callbacks[$method] ) )
            {
                $this->callbacks[$method] = array();
            }
            $this->callbacks[$method][] = $class;
        }

        $this->addVisitor( $this );

        $this->data[$class]      = null;
        $this->analyzers[$class] = $analyzer;
    }

    public function process( PHP_Depend_AST_CompilationUnit $compilationUnit )
    {
        foreach ( $this->analyzers as $analyzer )
        {
            if ( method_exists( $analyzer, 'visitCompilationUnitBefore' ) )
            {
                $analyzer->visitCompilationUnitBefore( $compilationUnit );
            }
        }

        $this->traverse( $compilationUnit->stmts );

        foreach ( $this->analyzers as $analyzer )
        {
            if ( method_exists( $analyzer, 'visitCompilationUnitAfter' ) )
            {
                $analyzer->visitCompilationUnitBefore( $compilationUnit );
            }
        }
    }

    /**
     * Called once before traversal.
     *
     * Return value semantics:
     *  * null:      $nodes stays as-is
     *  * otherwise: $nodes is set to the return value
     *
     * @param PHPParser_Node[] $nodes Array of nodes
     *
     * @return null|PHPParser_Node[] Array of nodes
     */
    public function beforeTraverse(array $nodes)
    {
        foreach ( array_keys( $this->data ) as $class )
        {
            $this->data[$class] = null;
        }
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
    public function enterNode( PHPParser_Node $node )
    {
        $callback = sprintf(
            'visit%sBefore',
            str_replace( '_', '', substr( get_class( $node ), 15 ) )
        );

        if ( false === isset( $this->callbacks[$callback] ) )
        {
            return ;
        }

        foreach ( $this->callbacks[$callback] as $class )
        {
            $this->data[$class] = $this->analyzers[$class]->$callback( $node, $this->data[$class] );
        }
    }

    /**
     * Called when leaving a node.
     *
     * Return value semantics:
     *  * null:      $node stays as-is
     *  * false:     $node is removed from the parent array
     *  * array:     The return value is merged into the parent array (at the position of the $node)
     *  * otherwise: $node is set to the return value
     *
     * @param PHPParser_Node $node Node
     *
     * @return null|PHPParser_Node|false|PHPParser_Node[] Node
     */
    public function leaveNode(PHPParser_Node $node)
    {
        $callback = sprintf(
            'visit%sAfter',
            str_replace( '_', '', substr( get_class( $node ), 15 ) )
        );

        if ( false === isset( $this->callbacks[$callback] ) )
        {
            return ;
        }

        foreach ( $this->callbacks[$callback] as $class )
        {
            $this->data[$class] = $this->analyzers[$class]->$callback( $node, $this->data[$class] );
        }
    }

    /**
     * Called once after traversal.
     *
     * Return value semantics:
     *  * null:      $nodes stays as-is
     *  * otherwise: $nodes is set to the return value
     *
     * @param PHPParser_Node[] $nodes Array of nodes
     *
     * @return null|PHPParser_Node[] Array of nodes
     */
    public function afterTraverse(array $nodes)
    {

    }

}