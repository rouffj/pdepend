<?php
class ClassWithPropertyDependency
{
    /**
     * @var ClassWithPropertyDependencyProperty
     */
    protected $foo = null;
}


class ClassWithPropertyDependencyProperty
{
    /**
     * @var ClassWithPropertyDependency
     */
    protected $foo = null;
}