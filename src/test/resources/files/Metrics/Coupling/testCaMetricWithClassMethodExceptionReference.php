<?php
class ClassMethodWithExceptionReference
{
    /**
     * ...
     *
     * @return void
     * @throws ClassMethodWithExceptionReferenceExceptionOne
     * @throws ClassMethodWithExceptionReferenceExceptionTwo
     * @throws ClassMethodWithExceptionReferenceExceptionThree
     */
    public function foo()
    {
    }
}

class ClassMethodWithExceptionReferenceExceptionOne extends Exception
{
    /**
     * @var ClassMethodWithExceptionReference
     */
    protected $o;
}

class ClassMethodWithExceptionReferenceExceptionTwo extends Exception
{
    /**
     * @var ClassMethodWithExceptionReference
     */
    protected $o;
}

class ClassMethodWithExceptionReferenceExceptionThree extends Exception
{

}