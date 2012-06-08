<?php
class testCaForChildTypeReference
{
    public static function create($type)
    {
        switch ($type) {
            case 'foo':
                return new testCaForChildTypeReferenceChildOne();

            case 'bar':
                return new testCaForChildTypeReferenceNoChildOne();

            case 'baz':
                return new testCaForChildTypeReferenceNoChildTwo();

            case 'sindelfingen':
                return new testCaForChildTypeReferenceNoChildThree();

            default:
                return new stdClass;
        }
    }
}

class testCaForChildTypeReferenceChildOne
    extends testCaForChildTypeReference
{
    public function setFactory(testCaForChildTypeReference $factory)
    {

    }
}

class testCaForChildTypeReferenceNoChildOne
{
    public function setFactory(testCaForChildTypeReference $factory)
    {

    }
}

class testCaForChildTypeReferenceNoChildTwo
{
    public function setFactory(testCaForChildTypeReference $factory)
    {

    }
}

class testCaForChildTypeReferenceNoChildThree
{
}