<?php
class testCaWithStaticMethodCall
{
    public static function invoke()
    {
        return FooBar::baz();
    }
}

class testCaWithStaticMethodCallCallerOne
{
    public function invoke()
    {
        return testCaWithStaticMethodCall::invoke();
    }
}

class testCaWithStaticMethodCallCallerTwo
{
    public function invoke()
    {
        return testCaWithStaticMethodCall::invoke();
    }
}