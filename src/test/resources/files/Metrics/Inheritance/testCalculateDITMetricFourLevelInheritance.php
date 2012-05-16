<?php
interface testCalculateDITMetricFourLevelInheritanceInterface {}

class testCalculateDITMetricFourLevelInheritance extends testCalculateDITMetricFourLevelInheritanceParentB {} // DIT = 4
class testCalculateDITMetricFourLevelInheritanceParentB extends testCalculateDITMetricFourLevelInheritanceParentD {} // DIT = 3
class testCalculateDITMetricFourLevelInheritanceParentC extends testCalculateDITMetricFourLevelInheritanceParentD {} // DIT = 3
class testCalculateDITMetricFourLevelInheritanceParentD extends testCalculateDITMetricFourLevelInheritanceParentE {} // DIT = 2
class testCalculateDITMetricFourLevelInheritanceParentE extends testCalculateDITMetricFourLevelInheritanceParentF {} // DIT = 1
class testCalculateDITMetricFourLevelInheritanceParentF implements testCalculateDITMetricFourLevelInheritanceInterface {} // DIT = 0
?>
