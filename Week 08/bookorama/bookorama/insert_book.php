<html>
<head>
  <title>Book-O-Rama Book Entry Results</title>
</head>
<body>
<h1>Book-O-Rama Book Entry Results</h1>
<?php
  // create short variable names
  $isbn=$_POST['isbn'];
  $author=$_POST['author'];
  $title=$_POST['title'];
  $price=$_POST['price'];

  if (!$isbn || !$author || !$title || !$price) {
     echo "You have not entered all the required details.<br />"
          ."Please go back and try again.";
     exit;
  }

  // if (!get_magic_quotes_gpc()) {
  //   $isbn = addslashes($isbn);
  //   $author = addslashes($author);
  //   $title = addslashes($title);
  //   $price = doubleval($price);
  // }
  
  // server, username, password, database
  @ $db = new mysqli('localhost', 'root','', 'myuser');

  // check if connected
  if (mysqli_connect_errno()) {
     echo "Error: Could not connect to database.  Please try again later.";
     exit;
  }

  // request the database for the information
  $query = "insert into books values
            ('".$isbn."', '".$author."', '".$title."', '".$price."')";
  // put the result into $result
  $result = $db->query($query);

  // check if results were inserted properly
  if ($result) {
      echo  $db->affected_rows." book inserted into database.";
  } else {
  	  echo "An error has occur red.  The item was not added.";
  }

  $db->close();
?>
</body>
</html>
