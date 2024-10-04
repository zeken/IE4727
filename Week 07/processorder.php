<?php
  // create short variable names
  // use $_post to capture data you have transferred from server side
  // post method hides data from URL, get displays it on URL
  $tireqty = $_POST['tireqty']; // super global variables
  $oilqty = $_POST['oilqty'];
  $sparkqty = $_POST['sparkqty'];
  $find = $_POST['find'];
?>
<html>
<head>
  <title>Bob's Auto Parts - Order Results</title>
  <!-- displaying the order on the server side -->
</head>
<body>
<h1>Bob's Auto Parts</h1>
<h2>Order Results</h2>
<?php
	date_default_timezone_set("Asia/Singapore");
	echo date_default_timezone_get();
	// using date function H-24hr i=minutes j-dayofmonth S-suffix(e.g. th) F-fullnameofmonth Y-year
	// concantenation operator is (.)
	echo "<p>Order processed at ".date('H:i, jS F Y')."</p>";

	echo "<p>Your order is as follows: </p>";
	// total quantity
	$totalqty = 0;
	$totalqty = $tireqty + $oilqty + $sparkqty;
	echo "Items ordered: ".$totalqty."<br />";


	if ($totalqty == 0) {

	  echo "You did not order anything on the previous page!<br />";

	} else {

	  if ($tireqty > 0) {
		echo $tireqty." tires<br />"; // using period to concat
	  }

	  if ($oilqty > 0) {
		echo $oilqty." bottles of oil<br />"; // using period to concat
	  }

	  if ($sparkqty > 0) {
		echo $sparkqty." spark plugs<br />"; // using period to concat
	  }
	}

	// total amount 
	$totalamount = 0.00;

	// used to define the constants
	define('TIREPRICE', 100);
	define('OILPRICE', 10);
	define('SPARKPRICE', 4);

	$totalamount = $tireqty * TIREPRICE
				 + $oilqty * OILPRICE
				 + $sparkqty * SPARKPRICE;

	echo "Subtotal: $".number_format($totalamount,2)."<br />";

	$taxrate = 0.10;  // local sales tax is 10%
	$totalamount = $totalamount * (1 + $taxrate);
	echo "Total including tax: $".number_format($totalamount,2)."<br />";

	// find what option the customer selected
	if($find == "a") {
	  echo "<p>Regular customer.</p>";
	} elseif($find == "b") {
	  echo "<p>Customer referred by TV advert.</p>";
	} elseif($find == "c") {
	  echo "<p>Customer referred by phone directory.</p>";
	} elseif($find == "d") {
	  echo "<p>Customer referred by word of mouth.</p>";
	} else {
	  echo "<p>We do not know how this customer found us.</p>";
	}

?>
</body>
</html>
