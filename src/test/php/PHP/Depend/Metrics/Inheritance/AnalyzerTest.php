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
 * Test case for the inheritance analyzer.
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
 * @covers PHP_Depend_Metrics_Inheritance_Analyzer
 * @group pdepend
 * @group pdepend::metrics
 * @group pdepend::metrics::inheritance
 * @group unittest
 * @group 2.0
 */
class PHP_Depend_Metrics_Inheritance_AnalyzerTest extends PHP_Depend_Metrics_AbstractTest
{
    /**
     * Tests that the analyzer calculates the correct average number of derived
     * classes.
     *
     * @return void
     */
    public function testAnalyzerCalculatesCorrectANDCValue()
    {
        $processor = new PHP_Depend_Metrics_Processor();
        $processor->register( $analyzer = new PHP_Depend_Metrics_Inheritance_Analyzer() );
        $processor->process( self::parseTestCaseSource( __METHOD__ ) );

        $metrics = $analyzer->getProjectMetrics();
        $this->assertEquals( 0.7368, $metrics['andc'], null, 0.0001 );
    }

    /**
     * Tests that the analyzer calculates the correct average hierarchy height.
     *
     * @return void
     */
    public function testAnalyzerCalculatesCorrectAHHValue()
    {
        $processor = new PHP_Depend_Metrics_Processor();
        $processor->register( $analyzer = new PHP_Depend_Metrics_Inheritance_Analyzer() );
        $processor->process( self::parseTestCaseSource( __METHOD__ ) );

        $metrics = $analyzer->getProjectMetrics();
        $this->assertEquals( 1, $metrics['ahh'] );
    }

    /**
     * testCalculatesExpectedNoccMetricForClassWithoutChildren
     *
     * @return void
     */
    public function testCalculatesExpectedNoccMetricForClassWithoutChildren()
    {
        $this->assertEquals( 0, $this->_getCalculatedMetric( __METHOD__, 'nocc' ) );
    }

    /**
     * testCalculatesExpectedNoccMetricForClassWithDirectChildren
     *
     * @return void
     */
    public function testCalculatesExpectedNoccMetricForClassWithDirectChildren()
    {
        $this->assertEquals( 3, $this->_getCalculatedMetric( __METHOD__, 'nocc' ) );
    }

    /**
     * testCalculatesExpectedNoccMetricForClassWithDirectAndIndirectChildren
     *
     * @return void
     */
    public function testCalculatesExpectedNoccMetricForClassWithDirectAndIndirectChildren()
    {
        $this->assertEquals( 1, $this->_getCalculatedMetric( __METHOD__, 'nocc' ) );
    }

    /**
     * Tests that the analyzer calculates the correct DIT values.
     *
     * @return void
     */
    public function testCalculateDITMetricNoInheritance()
    {
        $this->assertEquals( 0, $this->_getCalculatedMetric( __METHOD__, 'dit' ) );
    }

    /**
     * Tests that the analyzer calculates the correct DIT values.
     *
     * @return void
     */
    public function testCalculateDITMetricOneLevelInheritance()
    {
        $this->assertEquals( 1, $this->_getCalculatedMetric( __METHOD__, 'dit' ) );
    }

    /**
     * Tests that the analyzer calculates the correct DIT values.
     *
     * @return void
     */
    public function testCalculateDITMetricTwoLevelInheritance()
    {
        $this->assertEquals( 2, $this->_getCalculatedMetric( __METHOD__, 'dit' ) );
    }

    /**
     * Tests that the analyzer calculates the correct DIT values.
     *
     * @return void
     */
    public function testCalculateDITMetricThreeLevelInheritance()
    {
        $this->assertEquals( 3, $this->_getCalculatedMetric( __METHOD__, 'dit' ) );
    }

    /**
     * Tests that the analyzer calculates the correct DIT values.
     *
     * @return void
     */
    public function testCalculateDITMetricFourLevelInheritance()
    {
        $this->assertEquals( 4, $this->_getCalculatedMetric( __METHOD__, 'dit' ) );
    }

    /**
     * testCalculateDITMetricForUnknownParentIncrementsMetricWithTwo
     *
     * @return void
     */
    public function testCalculateDITMetricForUnknownParentIncrementsMetricWithTwo()
    {
        $this->assertEquals( 3, $this->_getCalculatedMetric( __METHOD__, 'dit' ) );
    }

    /**
     * testCalculateDITMetricForInternalParentIncrementsMetricWithTwo
     *
     * @return void
     */
    public function testCalculateDITMetricForInternalParentIncrementsMetricWithTwo()
    {
        $this->assertEquals( 3, $this->_getCalculatedMetric( __METHOD__, 'dit' ) );
    }

    /**
     * Tests that {@link PHP_Depend_Metrics_Inheritance_Analyzer::analyze()}
     * calculates the expected DIT values.
     *
     * @return void
     */
    public function testCalculateDepthOfInheritanceForSeveralClasses()
    {
        $processor = new PHP_Depend_Metrics_Processor();
        $processor->register( $analyzer = new PHP_Depend_Metrics_Inheritance_Analyzer() );
        $processor->process( $compilationUnits = self::parseTestCaseSource( __METHOD__ ) );

        $actual = array();
        foreach ( array( 'A', 'B', 'C', 'D', 'E' ) as $name )
        {
            $metrics       = $analyzer->getNodeMetrics( "{$name}#c" );
            $actual[$name] = $metrics['dit'];
        }

        $this->assertEquals(
            array(
                'A' => 0,
                'B' => 1,
                'C' => 1,
                'D' => 2,
                'E' => 3,
            ),
            $actual
        );
    }

    /**
     * testCalculatesExpectedMaxDepthOfInheritanceTreeMetric
     *
     * @return void
     */
    public function testCalculatesExpectedMaxDepthOfInheritanceTreeMetric()
    {
        $processor = new PHP_Depend_Metrics_Processor();
        $processor->register( $analyzer = new PHP_Depend_Metrics_Inheritance_Analyzer() );
        $processor->process( self::parseTestCaseSource( __METHOD__ ) );

        $metrics = $analyzer->getProjectMetrics();
        $this->assertEquals( 3, $metrics['maxDIT'] );
    }

    /**
     * testCalculatesExpectedNoamMetricForClassWithoutParent
     *
     * @return void
     */
    public function testCalculatesExpectedNoamMetricForClassWithoutParent()
    {
        $this->assertEquals( 0, $this->_getCalculatedMetric( __METHOD__, 'noam' ) );
    }

    /**
     * testCalculatesExpectedNoamMetricForClassWithDirectParent
     *
     * @return void
     */
    public function testCalculatesExpectedNoamMetricForClassWithDirectParent()
    {
        $this->assertEquals( 2, $this->_getCalculatedMetric( __METHOD__, 'noam' ) );
    }

    /**
     * testCalculatesExpectedNoamMetricForClassWithIndirectParent
     *
     * @return void
     */
    public function testCalculatesExpectedNoamMetricForClassWithIndirectParent()
    {
        $this->assertEquals( 2, $this->_getCalculatedMetric( __METHOD__, 'noam' ) );
    }

    /**
     * testCalculatesExpectedNoomMetricForClassWithoutParent
     *
     * @return void
     */
    public function testCalculatesExpectedNoomMetricForClassWithoutParent()
    {
        $this->assertEquals( 0, $this->_getCalculatedMetric( __METHOD__, 'noom' ) );
    }

    /**
     * testCalculatesExpectedNoomMetricForClassWithParent
     *
     * @return void
     */
    public function testCalculatesExpectedNoomMetricForClassWithParent()
    {
        $this->assertEquals( 2, $this->_getCalculatedMetric( __METHOD__, 'noom' ) );
    }

    /**
     * testCalculatesExpectedNoomMetricForClassWithParentPrivateMethods
     *
     * @return void
     */
    public function testCalculatesExpectedNoomMetricForClassWithParentPrivateMethods()
    {
        $this->assertEquals( 1, $this->_getCalculatedMetric( __METHOD__, 'noom' ) );
    }

    /**
     * testAnalyzerIgnoresClassesThatAreNotUserDefined
     *
     * @return void
     */
    public function testAnalyzerIgnoresClassesThatAreNotUserDefined()
    {
        $processor = new PHP_Depend_Metrics_Processor();
        $processor->register( $analyzer = new PHP_Depend_Metrics_Inheritance_Analyzer() );
        $processor->process( self::parseTestCaseSource( __METHOD__ ) );

        $metrics = $analyzer->getNodeMetrics( __FUNCTION__ . 'Parent#c' );
        $this->assertEquals( array(), $metrics );

    }

    /**
     * Analyzes the source associated with the calling test and returns the
     * calculated metric value.
     *
     * @param string $testCase Name of the calling test case.
     * @param string $metric   Name of the searched metric.
     *
     * @return mixed
     */
    private function _getCalculatedMetric( $testCase, $metric )
    {
        $processor = new PHP_Depend_Metrics_Processor();
        $processor->register( $analyzer = new PHP_Depend_Metrics_Inheritance_Analyzer() );
        $processor->process( self::parseTestCaseSource( $testCase ) );

        list( , $class ) = explode( '::', $testCase );

        $metrics = $analyzer->getNodeMetrics( "{$class}#c" );
        return $metrics[$metric];
    }
}
