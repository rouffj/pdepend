<?php
class testCaFromMultipleFunctions
{

}

function foo(testCaFromMultipleFunctions $o)
{

}

function bar()
{
    return new testCaFromMultipleFunctions();
}

/**
 * @return testCaFromMultipleFunctions
 */
function baz()
{

}

/**
 * @throws testCaFromMultipleFunctions
 */
function foobar()
{

}