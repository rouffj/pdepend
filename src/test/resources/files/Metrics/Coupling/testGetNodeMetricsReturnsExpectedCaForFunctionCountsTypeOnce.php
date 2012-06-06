<?php
class testGetNodeMetricsReturnsExpectedCaForFunctionCountsTypeOnce extends Exception
{

}

/**
 * @throws testGetNodeMetricsReturnsExpectedCaForFunctionCountsTypeOnce
 * @param testGetNodeMetricsReturnsExpectedCaForFunctionCountsTypeOnce $o
 * @return testGetNodeMetricsReturnsExpectedCaForFunctionCountsTypeOnce
 */
function foo(testGetNodeMetricsReturnsExpectedCaForFunctionCountsTypeOnce $o)
{
    if ($o instanceof testGetNodeMetricsReturnsExpectedCaForFunctionCountsTypeOnce) {
        throw new testGetNodeMetricsReturnsExpectedCaForFunctionCountsTypeOnce();
    }
    return new testGetNodeMetricsReturnsExpectedCaForFunctionCountsTypeOnce();
}

/**
 * @return void
 * @throws testGetNodeMetricsReturnsExpectedCaForFunctionCountsTypeOnce
 */
function bar(testGetNodeMetricsReturnsExpectedCaForFunctionCountsTypeOnce $o)
{
    if ($o instanceof testGetNodeMetricsReturnsExpectedCaForFunctionCountsTypeOnce) {
        throw new testGetNodeMetricsReturnsExpectedCaForFunctionCountsTypeOnce();
    }
}