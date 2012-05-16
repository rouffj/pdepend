<?php
interface testCalculateDITMetricTwoLevelInheritanceInterface {}

class testCalculateDITMetricTwoLevelInheritance extends testCalculateDITMetricTwoLevelInheritanceParentC {}             // DIT = 2
class testCalculateDITMetricTwoLevelInheritanceParentC extends testCalculateDITMetricTwoLevelInheritanceParentB {}      // DIT = 1
class testCalculateDITMetricTwoLevelInheritanceParentB implements testCalculateDITMetricTwoLevelInheritanceInterface {} // DIT = 0
?>
