<?php
$tireqty = 5;
$strvar = "tires";
// for a variable to be printed out it has to be either in "" or without quote
echo "Variable name un-quoted: ";
echo $tireqty.'tires<br/>';

echo "Variable name in double quotes: ";
echo "$tireqty".'tires<br/>';

// cannot put variable names inside single quote
echo "Variable name in single quotes: ";
echo '$tireqty'.'tires<br/>';

// cannot put the concat in quotes
echo "Concatenation in double quotes: ";
echo "$tireqty.tires<br/>";

// single quotes are treated as string literals
echo "Concatenation in single quotes: ";
echo '$tireqty.tires<br/>';
?>