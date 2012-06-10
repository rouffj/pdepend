<?php
class ClassWithCatchStatementReference
{
    public function foo()
    {
        try {
            // Do something
        } catch (ClassWhereCatchStatementReferencesClassTwo $e) {
        }
    }
}

class ClassWhereCatchStatementReferencesClassOne
{
    public function foo()
    {
        try {
            // Do something
        } catch (ClassWithCatchStatementReference $e) {
        }
    }
}

class ClassWhereCatchStatementReferencesClassTwo
{
    public function bar()
    {
        try {
            // Do something
        } catch (ClassWithCatchStatementReference $e) {
        }
    }
}