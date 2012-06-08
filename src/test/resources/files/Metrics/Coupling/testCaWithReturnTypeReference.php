<?php
class testCaWithReturnTypeReference
{
    /**
     * @return SplObjectStorage
     */
    public function createCollection()
    {
        return null;
    }

    /**
     * @return ArrayAccess
     */
    public function createList()
    {
        return null;
    }
}

class testCaWithReturnTypeReferenceCaller
{
    /**
     * @return testCaWithReturnTypeReference
     */
    public function create()
    {
        return null;
    }
}