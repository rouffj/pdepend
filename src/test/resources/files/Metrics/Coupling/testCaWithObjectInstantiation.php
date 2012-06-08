<?php
class testCaWithObjectInstantiation
{
    public function createCollection()
    {
        $collection = new SplObjectStorage();
        $collection->attach( new ArrayObject() );
        $collection->attach( new ArrayObject() );

        return $collection;
    }
}

class testCaWithObjectInstantiationFactory
{
    function create()
    {
        return new testCaWithObjectInstantiation();
    }
}