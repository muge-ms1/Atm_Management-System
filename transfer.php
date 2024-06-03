<?php
 include ("connection.php");
 error_reporting(0);
?>

<html>
<head>
	<title>Transfer</title>
	<link rel="stylesheet" type="text/css" href="index.css">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
</head>
<body class="x">
<div class="jumbotron jumbotron-fluid">
  <div class="container">
    <h1 class="display-4">Enter Details: </h1><br><br>
    <form method="post" action="#">
    	<label>Account Number to Transfer: </label>
    	<input type="text" name="acct" id="acct"><br><br>
    	<label>Amount to Transfer: </label>
    	<input type="text" name="transfer" id="transfer"><br><br>
    	<button type="submit" id="submit" name="submit" class="btn btn-secondary btn-lg">Transfer</button>
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
	$amount=$_POST['transfer'];
	$acct=$_POST['acct'];

	$sql=mysqli_fetch_assoc(mysqli_query($conn,"select card_balance from card where card_cvv='$cvv'"));
	$sen_balance=$sql["card_balance"];
	
	$sql1=mysqli_fetch_assoc(mysqli_query($conn,"select card_balance from card where card_no in(select c_card_no from customer where c_id in(select a_c_id from account where acc_no='$acct'))"));
	$rec_balance=$sql1["card_balance"];
	
	if($sen_balance>$amount)
	{
		$a_sen_balance=$sen_balance-$amount;
		$a_rec_balance=$rec_balance+$amount;
		$sql=mysqli_query($conn,"update card set card_balance='$a_sen_balance'where card_cvv='$cvv'");
		echo"<br>";
		echo"hi";
		echo $a_sen_balance;
		$sql1=mysqli_query($conn,"update card set card_balance='$a_rec_balance'where card_no in(select c_card_no from customer where c_id in(select a_c_id from account where acc_no='$acct'))");
		$sql2="insert into transaction(transaction_id,transaction_name,transaction_status,transaction_type) values ('','transfered','COMPLETED','TRANSFER')";
		mysqli_query($conn,$sql2);
		$s=mysqli_fetch_assoc(mysqli_query($conn,"select card_no from card where card_cvv='$cvv'"));
		$v=$s['card_no'];
		$sql3="insert into temp(c_transaction_id,card_no,amount) values ('','$v','$amount')";
		mysqli_query($conn,$sql3);
	}
	$url = "receipt.php?card_no=" . $v;
    header('Location: ' . $url);
    exit();
    $conn->close();
    
  }

?>
</body>
</html>