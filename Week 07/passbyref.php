<?php
// add the & so that it can be visible outside the function
// means that it is passing by reference
function increment(&$value, $amount = 1) {
  $value = $value +$amount;
}


$a = 10;
echo $a.'<br/>';
increment ($a);
echo $a. '<br/>';

?>