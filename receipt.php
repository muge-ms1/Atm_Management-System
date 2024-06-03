<?php
 include ("connection.php");
 error_reporting(0);
?>


<?php
	
  $v=$_GET['card_no'];
  $sql="select c_transaction_id,amount from temp where card_no='$v' order by c_transaction_id desc limit 1";
  $x=mysqli_fetch_assoc(mysqli_query($conn,$sql));
  $tran_id=$x['c_transaction_id'];
  //echo $tran_id."<br>";
  $amount=$x['amount'];
  //echo $amount;

  $sql1="select transaction_name,transaction_type,transaction_status from transaction where transaction_id='$tran_id'";
  $z=mysqli_fetch_assoc(mysqli_query($conn,$sql1));
  $tran_name=$z['transaction_name'];
  $tran_type=$z['transaction_type'];
  $tran_sts=$z['transaction_status'];


  // echo $tran_name;
  // echo $tran_type;
  // echo $tran_sts;

  //echo"hi";

  $sql2="select Card_Balance from card where Card_No='$v'";
  $a=mysqli_fetch_assoc(mysqli_query($conn,$sql2));
  $avail=$a['Card_Balance'];
  $vs=(string)$v;

  // echo"<br>";
  // echo $avail;
  // echo"hello";
  // echo $vs;
  
?>
<html>
  <head>
    <title>Receipt</title>
	  <link rel="stylesheet" type="text/css" href="index.css">
	  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
  </head>
  <body class="x">
    <div class="jumbotron jumbotron-fluid" >
      <div class="container"> 
        <h1 class="display-4">Indian Bank</h1>
        <hr class="my-4">
        <h3>Card No: ************<?php echo substr($vs,-4);?></h3>
        <h3>Transaction Id: <?php echo "$tran_id";?></h3>
        <h3>Transaction type: <?php echo "$tran_type";?></h3>
        <h3>Transaction status: <?php echo "$tran_sts";?></h3>
        <h3>Amount <?php echo "$tran_name: $amount";?></h3>
        <h3>Availabe Amount: <?php echo "$avail";?></h3>
        <form method="post" action="#">
  	      <button type="submit" name="submit" id="submit" class="btn btn-secondary btn-lg">Exit</button>
        </form>
      </div>
    </div>
  </body>
</html>
<?php
if(isset($_POST['submit']))
{
	header('Location:index.php');
}
exit();
$conn->close();
?>
