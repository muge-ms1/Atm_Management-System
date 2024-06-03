<?php
 include ("connection.php");
 error_reporting(0);
?>

<html>
<head>
	<title>Withdraw</title>
	<link rel="stylesheet" type="text/css" href="index.css">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
</head>
<body class="x">
<div class="jumbotron jumbotron-fluid">
  <div class="container">
    <h1 class="display-4">Enter Amount To Withdraw: </h1><br><br>
    <form method="post" action="#">
    	<label>Rs: </label>
    	<input type="text" name="withdraw" id="withdraw"><br><br>
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
    echo "cvv:".$cvv."<br>";
	  $amount=$_POST['withdraw'];
    echo $amount."<br>";
    $sql=mysqli_fetch_assoc(mysqli_query($conn,"select card_balance from card where card_cvv='$cvv'"));
    $balance=$sql['card_balance'];
 	  if($balance>$amount)
    {                       
    $a_balance=$balance-$amount;
    echo "a_balance:".$a_balance."<br>";
    $sql1=mysqli_query($conn,"update card set card_balance='$a_balance' where card_cvv='$cvv'");
		$sql2=mysqli_query($conn,"insert into transaction(TRANSACTION_ID,TRANSACTION_NAME,TRANSACTION_STATUS,TRANSACTION_TYPE) VALUES ('','withdrawn','COMPLETED','WITHDRAW')");
		$sql3=mysqli_fetch_assoc(mysqli_query($conn,"select card_no from card where card_cvv='$cvv'"));
		$v=$sql3['card_no'];
    echo "cno:".$v."<br>";
		$sql4=mysqli_query($conn,"insert into temp( c_transaction_id,card_no ,amount) VALUES ('','$v','$amount')");
    
    }

    $url = "receipt.php?card_no=" . $v;
    echo $v;
    header('Location: ' . $url);
    exit();
    $conn->close();
    
  }
  
  
?>
</body>
</html>