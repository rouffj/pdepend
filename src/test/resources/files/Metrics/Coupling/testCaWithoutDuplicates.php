<?php
class testCaWithoutDuplicates
{
    /**
     * @var SplObjectStorage
     */
    protected $storage = null;

    /**
     * @var SplObjectStorage
     */
    protected $objects = null;

    protected function createNewStorage()
    {
        return new SplObjectStorage();
    }

    protected function createNewObjects()
    {
        return new ArrayObject();
    }
}

class testCaWithoutDuplicatesOne
{
    /**
     * @var testCaWithoutDuplicates
     */
    protected $storage = null;

    /**
     * @var testCaWithoutDuplicates
     */
    protected $objects = null;

    protected function createNewStorage()
    {
        return new SplObjectStorage();
    }

    protected function createNewObjects()
    {
        return new ArrayObject();
    }
}

class testCaWithoutDuplicatesTwo
{
    /**
     * @var testCaWithoutDuplicates
     */
    protected $storage = null;

    /**
     * @var testCaWithoutDuplicates
     */
    protected $objects = null;

    protected function createNewStorage()
    {
        return new SplObjectStorage();
    }

    protected function createNewObjects()
    {
        return new ArrayObject();
    }
}