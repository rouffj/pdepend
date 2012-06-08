<?php
class testCaForParentTypeReference
{
    public function bar()
    {
        return testCaForParentTypeReferenceChildOne::foo();
    }
}

class testCaForParentTypeReferenceChildOne extends testCaForParentTypeReference
{
    /**
     * @var testCaForParentTypeReference
     */
    private static $ref;

    /**
     * @return testCaForParentTypeReference
     */
    public static function foo()
    {
        return new testCaForParentTypeReference();
    }
}

class testCaForParentTypeReferenceChildTwo extends testCaForParentTypeReference
{

}