<?php
class ClassMethodWithReturnTypeReference
{
    /**
     * @return ClassWithoutMethodReferencingReturnType
     */
    public function foo()
    {
    }

    /**
     * @return ClassWithMethodReferencingClassByReturnType
     */
    public function bar()
    {
    }

    /**
     * @return ClassWithMethodReferencingClassByReturnType
     */
    public function baz()
    {
    }
}

class ClassWithMethodReferencingClassByReturnType
{
    /**
     * @return ClassMethodWithReturnTypeReference
     */
    public function foo()
    {
    }
}

class ClassWithoutMethodReferencingReturnType
{

}