<?php
 include ("connection.php");
 error_reporting(0);
?>

<html>
<head>
	<title>Deposit</title>
	<link rel="stylesheet" type="text/css" href="index.css">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
</head>
<body class="x">
<div class="jumbotron jumbotron-fluid">
  <div class="container">
    <h1 class="display-4">Enter Amount To Deposit: </h1><br><br>
    <form method="post" action="#">
    	<label>Rs: </label>
    	<input type="text" name="deposit" id="deposit"><br><br>
    	<button type="submit" id="submit" name="submit" class="btn btn-secondary btn-lg">Submit</button>
    	<button type="submit" id="cancel" name="cancel" class="btn btn-secondary btn-lg">Abort</button>
    </form>
</div>
</div>
<?php
  if(isset($_POST['cancel']))
  {
  	header('Location: index.php');
  }

  if(isset($_POST['submit']))
  {
  	$cvv=(int) $_GET['cvv'];
	$amount=$_POST['deposit'];
  	$sql=mysqli_fetch_assoc(mysqli_query($conn,"select card_balance from card where card_cvv='$cvv'"));
 	$z=$sql["card_balance"];
  	$y=$z+$amount;
	$sql1="update card set card_balance='$y' where card_cvv='$cvv'";
	mysqli_query($conn,$sql1);
	$sql2="insert into transaction(transaction_id,transaction_name,transaction_status,transaction_type) values ('','deposited','COMPLETED','DEPOSIT')";
	mysqli_query($conn,$sql2);
	$s=mysqli_fetch_assoc(mysqli_query($conn,"select card_no from card where card_cvv='$cvv'"));
	$v=$s['card_no'];
	$sql3="insert into temp(c_transaction_id,card_no,amount) values ('','$v','$amount')";
	mysqli_query($conn,$sql3);
	$url = "receipt.php?card_no=" . $v;
    header('Location: ' . $url);
    exit();
    $conn->close();

}
?>
</body>
</html>