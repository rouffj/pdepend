<?php
interface testCalculateDITMetricOneLevelInheritanceInterface {}

class testCalculateDITMetricOneLevelInheritance extends testCalculateDITMetricOneLevelInheritanceParent {}             // DIT = 1
class testCalculateDITMetricOneLevelInheritanceParent implements testCalculateDITMetricOneLevelInheritanceInterface {} // DIT = 0
?>
