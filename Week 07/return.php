<?php
// isset function tells if  variable is created and assigned
function larger ($x, $y) {
// if the values of x and y are not given it will return false
if ((!isset($x)) || (!isset($y))) {
	return false;
} else if ($x>=$y) {
	return $x;
} else {
	return $y; }
} 

$a = 1; $b = 2.5; $c = 1.9;

echo larger($a, $b).'<br />'; 
echo larger($c, $a).'<br />'; 
echo larger($d, $a).'<br />';
// $d is not defined so it will just return false

?>