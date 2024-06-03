<?php
 include ("connection.php");
 error_reporting(0);
?>

<html>
<head>
	<title>Welcome to Indian Bank</title>
	<link rel="stylesheet" type="text/css" href="index.css">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
</head>
<body class="x">

	<div class="jumbotron" >
  <h1 class="display-4 y">Welcome To Indian Bank</h1>
  <hr class="my-4">
  <form method="post" action="#">
  	<label>Enter Your ATM Card Number: </label><br>
  	<input type="text" name="card_no" id="card_no" required><br>
  	<label>CVV: </label><br>
  	<input type="password" name="cvv" id="cvv" required><br><br>
    <label>Account Type:</label>
    <select required>
      <option></option>
      <option>Current</option>
      <option>Savings</option>
      <option>Deemat</option>
    </select><br><br>
  	<button type="submit" name="submit" id="submit" class="btn btn-secondary btn-lg">Submit</button>
  </form>
  </div>

<?php
   
  if(isset($_POST['submit']))
  {
    $card_no=$_POST['card_no'];
    $cvv=$_POST['cvv'];
    $result =mysqli_fetch_row(mysqli_query($conn,"select * from card where card_no='$card_no'"));
    if($result[2] == $cvv)
    {
      echo " Correct Cvv Number";
    	header("Location: option.php");
      if(isset($_POST['cvv']))
      {
      $cvv=$_POST['cvv'];
      $url = "option.php?cvv=" . $cvv;
      header('Location: ' . $url);
      exit();
      }
    }
  }
  
  $conn->close();
?>

</body>
</html>