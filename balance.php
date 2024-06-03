<?php
 include ("connection.php");
 error_reporting(0);
?>

<html>
<head>
	<title>Balance Enquiry</title>
	<link rel="stylesheet" type="text/css" href="index.css">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
</head>
<body class="x">

<?php
  $cvv=(int) $_GET['cvv'];
  $sql=mysqli_fetch_assoc(mysqli_query($conn,"select card_balance from card where card_cvv='$cvv'"));
  $balance=$sql['card_balance'];
?>

<div class="jumbotron">
  <h1 class="display-3 y">Your Current Balance is: </h1>
  <hr class="my-4">
  <h1 class="display-4 y">Rs: <?php echo "$balance";?></h1><br>
  <form method="post" action="#">
  	<button type="submit" name="submit" id="submit" class="btn btn-secondary btn-lg">Continue</button>
  </form>
</div>
<?php
if(isset($_POST['submit']))
{
  $sql2="insert into transaction(transaction_id,transaction_name,transaction_status,transaction_type) values ('','','COMPLETED','BALANCE ENQUIRY')";
	mysqli_query($conn,$sql2);
	$s=mysqli_fetch_assoc(mysqli_query($conn,"select card_no from card where card_cvv='$cvv'"));
	$v=$s['card_no'];
	$sql3="insert into temp(c_transaction_id,card_no,amount) values ('','$v','0')";
	mysqli_query($conn,$sql3);
	$url = "receipt.php?card_no=" . $v;
	header('Location: ' . $url);
	exit();
  $conn->close();
}
?>
</body>
</html>