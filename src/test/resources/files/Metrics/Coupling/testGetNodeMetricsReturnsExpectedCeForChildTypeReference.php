<?php
class testGetNodeMetricsReturnsExpectedCeForChildTypeReference
{
    public static function create($type)
    {
        switch ($type) {
            case 'foo':
                return new testGetNodeMetricsReturnsExpectedCeForChildTypeReference_foo();

            case 'bar':
                return new testGetNodeMetricsReturnsExpectedCeForChildTypeReference_bar();

            case 'baz':
                return new testGetNodeMetricsReturnsExpectedCeForChildTypeReference_baz();

            default:
                return new stdClass;
        }
    }
}

class testGetNodeMetricsReturnsExpectedCeForChildTypeReference_foo
    extends testGetNodeMetricsReturnsExpectedCeForChildTypeReference
{

}

class testGetNodeMetricsReturnsExpectedCeForChildTypeReference_bar
    extends testGetNodeMetricsReturnsExpectedCeForChildTypeReference
{

}