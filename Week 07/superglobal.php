<!DOCTYPE html>
<html>
<body>
<!-- create a form to submit a string -->
                            <!-- php echo here is to call itself 
                             because the script is in the same file -->
                    <!-- if script was in a different file:
                     action="filename.php" -->
<form method="get" action="<?php echo $_SERVER['PHP_SELF'];?>">
<!-- when the form is submitted, the input value will be sent under the key fname -->
Name: <input type="text" name="fname">
<!-- need to use input type submit so that php script can get it -->
<!-- submit button -->
<input type="submit"> 
</form>

<?php 
// request can handle both post and get methods
$name = $_REQUEST['fname'];
if (($name) != '')echo "<br> Text string submitted: ".$name; 
else echo "Nothing submitted";
?>

</body>
</html>