<?php
interface testCaForParameterTypeReferences
{
    function foo(Iterator $it);

    function bar(SplObjectStorage $storage);
}

interface testCaForParameterTypeReferencesRefOne
{
    function foo(testCaForParameterTypeReferences $it);

    function bar(SplObjectStorage $storage);

    function baz(ArrayAccess $objects);
}

interface testCaForParameterTypeReferencesRefTwo
{
    function foo(Iterator $it);

    function bar(testCaForParameterTypeReferences $storage);

    function baz(ArrayAccess $objects);
}

interface testCaForParameterTypeReferencesRefThree
{
    function foo(Iterator $it);

    function bar(SplObjectStorage $storage);

    function baz(testCaForParameterTypeReferences $objects);
}