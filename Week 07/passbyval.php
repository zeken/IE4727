<?php
// how to create function
function my_function() {
  // nl2br to add line breaks
  echo nl2br("My function was called \n");
}
my_function();

function increment($value, $amount = 1) {
  $value = $value +$amount;
}


$a = 10;
echo $a.'<br/>';
increment ($a);
echo nl2br("does not update because value is not visible to outside the function\n");
echo $a. '<br/>';

?>