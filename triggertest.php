
<body>
<?php include('function.php'); ?>
<?php
    
    
    
if(isset($_POST["sbmt"]))
{
    
    $cn = makeconnection();
    
    $query = "insert into trigger_test(feedback)value('".$_POST["value"]."')";
    
    mysqli_query($cn,$query);
    
    $retrive = "SELECT `rating` FROM `trigger_test` WHERE `feedback` LIKE '".$_POST["value"]."'";
    
    if($result = mysqli_query($cn,$retrive))
    {
        $row = mysqli_fetch_array($result);
        
        echo "The user rating is".$row['rating'];
    }
    
  //  echo "<script>alert('Record Save');</script>";
    
}
?> 
   

<form method="post" enctype="multipart/form-data">
    
    <select name="value">
    
        <option>Very Good</option>
        <option>Good</option>
        <option>Fair</option>
        <option>Average</option>
        <option>Poor</option>
        
    
    </select>
    
    <input type="submit" value="submit" name="sbmt">



</form>
    </body>