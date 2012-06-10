<?php
namespace A {
    abstract class A1
    {
        public function a1a()
        {
        }

        public function a1b()
        {
        }
    }

    abstract class A2
    {
    }

    class A3
    {
        public function a3a()
        {
        }
    }

    interface I1
    {
    }

    interface I2
    {
    }

    interface I3
    {
        public function i3a();

        public function i3b();
    }

    function a1()
    {
    }

    function a2()
    {
    }

    function a3()
    {
    }
}

namespace B {
    class B1
    {
        public function b1a()
        {
        }

        public function b1b()
        {
        }
    }

    abstract class B2
    {
    }

    interface I1
    {
    }

    interface I2
    {
        public function i2a();

        public function i2b();
    }

    interface I3
    {
        public function i3a();
    }

    function b1()
    {
    }

    function b2()
    {
    }
}

namespace C {
    abstract class C1
    {
        public function c1a()
        {
        }

        public function c1b()
        {
        }
    }

    interface I1
    {
        public function i1a();
    }

    interface I2
    {
    }

    function c1()
    {
    }
}