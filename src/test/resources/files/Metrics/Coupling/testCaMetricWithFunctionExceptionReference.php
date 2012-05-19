<?php
namespace foo {

    use \ExceptionReferencedByFunction;

    /**
     * @return void
     * @throws ExceptionReferencedByFunction
     */
    function foo()
    {

    }

    /**
     * @return void
     * @throws ExceptionReferencedByFunction
     */
    function bar()
    {

    }
}

namespace {
    class ExceptionReferencedByFunction extends Exception
    {

    }
}