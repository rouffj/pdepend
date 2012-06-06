<?php
class testGetNodeMetricsReturnsExpectedCaForParentTypeReference
{
    public function bar()
    {
        return testGetNodeMetricsReturnsExpectedCaForParentTypeReference_child::foo();
    }
}

class testGetNodeMetricsReturnsExpectedCaForParentTypeReference_child
    extends testGetNodeMetricsReturnsExpectedCaForParentTypeReference
{
    public static function foo()
    {

    }
}