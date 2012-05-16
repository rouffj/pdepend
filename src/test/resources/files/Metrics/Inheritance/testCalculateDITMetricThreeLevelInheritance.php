<?php
interface testCalculateDITMetricThreeLevelInheritanceInterface {}

class testCalculateDITMetricThreeLevelInheritance extends testCalculateDITMetricThreeLevelInheritanceParentC {} // DIT = 3
class testCalculateDITMetricThreeLevelInheritanceParentB extends testCalculateDITMetricThreeLevelInheritanceParentC {} // DIT = 3
class testCalculateDITMetricThreeLevelInheritanceParentC extends testCalculateDITMetricThreeLevelInheritanceParentE {} // DIT = 2
class testCalculateDITMetricThreeLevelInheritanceParentE extends testCalculateDITMetricThreeLevelInheritanceParentD {} // DIT = 1
class testCalculateDITMetricThreeLevelInheritanceParentD implements testCalculateDITMetricThreeLevelInheritanceInterface {} // DIT = 0
?>
