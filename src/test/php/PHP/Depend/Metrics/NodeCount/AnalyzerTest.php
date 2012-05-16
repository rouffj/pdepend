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

require_once dirname( __FILE__ ) . '/../AbstractTest.php';

/**
 * Test case for the node count analyzer.
 *
 * @category   QualityAssurance
 * @package    PHP_Depend
 * @subpackage Metrics
 * @author     Manuel Pichler <mapi@pdepend.org>
 * @copyright  2008-2012 Manuel Pichler. All rights reserved.
 * @license    http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @version    Release: @package_version@
 * @link       http://pdepend.org/
 *
 * @covers PHP_Depend_Metrics_NodeCount_Analyzer
 * @group pdepend
 * @group pdepend::metrics
 * @group pdepend::metrics::nodecount
 * @group unittest
 * @group 2.0
 */
class PHP_Depend_Metrics_NodeCount_AnalyzerTest extends PHP_Depend_Metrics_AbstractTest
{
    /**
     * Tests that the analyzer calculates the correct number of packages value.
     *
     * @return void
     */
    public function testCalculatesExpectedNumberOfPackages()
    {
        $processor = new PHP_Depend_Metrics_Processor();
        $processor->register( $analyzer = new PHP_Depend_Metrics_NodeCount_Analyzer() );
        $processor->process( self::parseTestCaseSource( __METHOD__ ) );

        $metrics = $analyzer->getProjectMetrics();
        self::assertEquals( 3, $metrics['nop'] );
    }

    /**
     * testCalculatesExpectedNumberOfClassesInProject
     *
     * @return void
     */
    public function testCalculatesExpectedNumberOfClassesInProject()
    {
        $processor = new PHP_Depend_Metrics_Processor();
        $processor->register( $analyzer = new PHP_Depend_Metrics_NodeCount_Analyzer() );
        $processor->process( self::parseTestCaseSource( __METHOD__ ) );

        $metrics = $analyzer->getProjectMetrics();
        self::assertEquals( 6, $metrics['noc'] );
    }

    /**
     * testCalculatesExpectedNumberOfClassesInPackages
     *
     * @return void
     */
    public function testCalculatesExpectedNumberOfClassesInPackages()
    {
        $processor = new PHP_Depend_Metrics_Processor();
        $processor->register( $analyzer = new PHP_Depend_Metrics_NodeCount_Analyzer() );
        $processor->process( self::parseTestCaseSource( __METHOD__ ) );

        self::assertEquals(
            array(
                'A' => array( 'noc' => 3, 'noi' => 0, 'nom' => 0, 'nof' => 0 ),
                'B' => array( 'noc' => 2, 'noi' => 0, 'nom' => 0, 'nof' => 0 ),
                'C' => array( 'noc' => 1, 'noi' => 0, 'nom' => 0, 'nof' => 0 ),
            ),
            array(
                'A'  =>  $analyzer->getNodeMetrics( 'A#n' ),
                'B'  =>  $analyzer->getNodeMetrics( 'B#n' ),
                'C'  =>  $analyzer->getNodeMetrics( 'C#n' ),
            )
        );
    }

    /**
     * testCalculatesExpectedNumberOfInterfacesInProject
     *
     * @return void
     */
    public function testCalculatesExpectedNumberOfInterfacesInProject()
    {
        $processor = new PHP_Depend_Metrics_Processor();
        $processor->register( $analyzer = new PHP_Depend_Metrics_NodeCount_Analyzer() );
        $processor->process( self::parseTestCaseSource( __METHOD__ ) );

        $metrics = $analyzer->getProjectMetrics();
        self::assertEquals( 9, $metrics['noi'] );
    }

    /**
     * testCalculatesExpectedNumberOfInterfacesInPackages
     *
     * @return void
     */
    public function testCalculatesExpectedNumberOfInterfacesInPackages()
    {
        $processor = new PHP_Depend_Metrics_Processor();
        $processor->register( $analyzer = new PHP_Depend_Metrics_NodeCount_Analyzer() );
        $processor->process( self::parseTestCaseSource( __METHOD__ ) );

        self::assertEquals(
            array(
                'A' => array( 'noc' => 0, 'noi' => 1, 'nom' => 0, 'nof' => 0 ),
                'B' => array( 'noc' => 0, 'noi' => 2, 'nom' => 0, 'nof' => 0 ),
                'C' => array( 'noc' => 0, 'noi' => 3, 'nom' => 0, 'nof' => 0 ),
            ),
            array(
                'A'  =>  $analyzer->getNodeMetrics( 'A#n' ),
                'B'  =>  $analyzer->getNodeMetrics( 'B#n' ),
                'C'  =>  $analyzer->getNodeMetrics( 'C#n' )
            )
        );
    }

    /**
     * testNumberOfMethodsInProject
     *
     * @return PHP_Depend_Metrics_NodeCount_Analyzer
     */
    public function testNumberOfMethodsInProject()
    {
        $processor = new PHP_Depend_Metrics_Processor();
        $processor->register( $analyzer = new PHP_Depend_Metrics_NodeCount_Analyzer() );
        $processor->process( self::parseTestCaseSource( __METHOD__ ) );

        $metrics = $analyzer->getProjectMetrics();
        $this->assertEquals( 12, $metrics['nom'] );

        return $analyzer;
    }

    /**
     * testNumberOfMethodsInPackages
     *
     * @param PHP_Depend_Metrics_NodeCount_Analyzer $analyzer
     *
     * @return void
     * @depends testNumberOfMethodsInProject
     */
    public function testNumberOfMethodsInPackages( PHP_Depend_Metrics_NodeCount_Analyzer $analyzer )
    {
        $this->assertEquals(
            array(
                'A' => array( 'noc' => 2, 'noi' => 1, 'nom' => 4, 'nof' => 0 ),
                'B' => array( 'noc' => 1, 'noi' => 2, 'nom' => 6, 'nof' => 0 ),
                'C' => array( 'noc' => 0, 'noi' => 1, 'nom' => 2, 'nof' => 0 ),
            ),
            array(
                'A'  =>  $analyzer->getNodeMetrics( 'A#n' ),
                'B'  =>  $analyzer->getNodeMetrics( 'B#n' ),
                'C'  =>  $analyzer->getNodeMetrics( 'C#n' )
            )
        );
    }

    /**
     * testNumberOfMethodsInClass
     *
     * @param PHP_Depend_Metrics_NodeCount_Analyzer $analyzer
     *
     * @return void
     * @depends testNumberOfMethodsInProject
     */
    public function testNumberOfMethodsInClass( PHP_Depend_Metrics_NodeCount_Analyzer $analyzer )
    {
        $this->assertEquals(
            array( 'nom'  =>  3 ),
            $analyzer->getNodeMetrics( 'B\\B3#c' )
        );
    }

    /**
     * testNumberOfMethodsInInterface
     *
     * @param PHP_Depend_Metrics_NodeCount_Analyzer $analyzer
     *
     * @return void
     * @depends testNumberOfMethodsInProject
     */
    public function testNumberOfMethodsInInterface( PHP_Depend_Metrics_NodeCount_Analyzer $analyzer )
    {
        $this->assertEquals(
            array( 'nom'  =>  2 ),
            $analyzer->getNodeMetrics( 'C\\C1#i' )
        );
    }

    /**
     * testCalculatesExpectedNumberOfFunctionsInProject
     *
     * @return void
     */
    public function testCalculatesExpectedNumberOfFunctionsInProject()
    {
        $processor = new PHP_Depend_Metrics_Processor();
        $processor->register( $analyzer = new PHP_Depend_Metrics_NodeCount_Analyzer() );
        $processor->process( self::parseTestCaseSource( __METHOD__ ) );

        $metrics = $analyzer->getProjectMetrics();
        $this->assertEquals( 6, $metrics['nof'] );
    }

    /**
     * testCalculatesExpectedNumberOfFunctionsInPackages
     *
     * @return void
     */
    public function testCalculatesExpectedNumberOfFunctionsInPackages()
    {
        $processor = new PHP_Depend_Metrics_Processor();
        $processor->register( $analyzer = new PHP_Depend_Metrics_NodeCount_Analyzer() );
        $processor->process( self::parseTestCaseSource( __METHOD__ ) );

        self::assertEquals(
            array(
                'A' => array( 'noc' => 0, 'noi' => 0, 'nom' => 0, 'nof' => 3 ),
                'B' => array( 'noc' => 0, 'noi' => 0, 'nom' => 0, 'nof' => 2 ),
                'C' => array( 'noc' => 0, 'noi' => 0, 'nom' => 0, 'nof' => 1 ),
            ),
            array(
                'A'  =>  $analyzer->getNodeMetrics( 'A#n' ),
                'B'  =>  $analyzer->getNodeMetrics( 'B#n' ),
                'C'  =>  $analyzer->getNodeMetrics( 'C#n' ),
            )
        );
    }
}
