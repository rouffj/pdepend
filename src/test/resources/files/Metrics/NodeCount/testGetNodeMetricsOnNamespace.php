<?php
namespace A {
    class A1 {
        function a1a() {}
        function a1b() {}
    }
    class A2 {
        function a2a() {}
    }
    class A3 {}

    interface I1 {
        function i3a();
    }

    function a1() {}
    function a2() {}
    function a3() {}
}

namespace B {
    class B1 {}
    class B2 {}

    interface I1 {
        function i1a();
        function i1b();
    }
    interface I2 {
        function i2a();
    }

    function b1() {}
    function b2() {}
}

namespace C {
    class C1 {}

    interface I1 {}
    interface I2 {
        function i1a();
        function i1b();
    }
    interface I3 {}

    function c1() {}
}