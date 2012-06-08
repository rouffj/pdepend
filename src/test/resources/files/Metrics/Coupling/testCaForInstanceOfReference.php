<?php
class testCaForInstanceOfReference
{
    public function foo( $object )
    {
        if ( $object instanceof testCaForInstanceOfReferenceRefOne )
        {

        }
    }
}

class testCaForInstanceOfReferenceRefOne
{
    public function foo( $object )
    {
        if ( $object instanceof testCaForInstanceOfReference )
        {

        }
    }
}

class testCaForInstanceOfReferenceRefTwo
{
    public function foo( $object )
    {
        if ( $object instanceof testCaForInstanceOfReference )
        {

        }
    }
}

class testCaForInstanceOfReferenceRefThree extends testCaForInstanceOfReference
{
    public function foo( $object )
    {
        if ( $object instanceof testCaForInstanceOfReference )
        {

        }
    }
}