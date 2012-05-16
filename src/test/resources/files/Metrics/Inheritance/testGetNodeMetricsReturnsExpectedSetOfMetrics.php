<?php
class NoInheritance
{
    public function foo() {}
    public function bar() {}
}

class OneLevelInheritance extends NoInheritance implements DummyInheritanceInterface
{
    public function foo() {}
    public function bar() {}

    private function _foo() {}
    private function _bar() {}
    private function _baz() {}
}

class TwoLevelInheritance extends OneLevelInheritance
{
    private function _bar() {}
    private function _baz() {}

    public function bar2() {}
    public function baz2() {}
}

class ThreeLevelInheritance extends TwoLevelInheritance
{

}

class FourLevelInheritance extends ThreeLevelInheritance
{
    public function bar3() {}
    public function baz3() {}
}

class FourLevelInheritanceA extends ThreeLevelInheritance
{

}

class FourLevelInheritanceB extends ThreeLevelInheritance
{

}

class UnknownClassInheritance extends UnknownInheritClass
{

}

class InternalClassInheritance extends DOMDocument
{

}

interface DummyInheritanceInterface
{

}