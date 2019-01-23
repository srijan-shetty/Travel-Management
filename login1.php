<?php
   
  if (array_key_exists('email', $_POST) OR array_key_exists('password', $_POST)) {
        
        $link = mysqli_connect("localhost","root","","travel");

            if (mysqli_connect_error()) {
        
                die ("There was an error connecting to the database");
        
            } 
      if ($_POST['email'] == '') {
            
            echo "<p>Email address is required.</p>";
            
        } else if ($_POST['password'] == '') {
            
            echo "<p>Password is required.</p>";
      }
  else{


  $query = "SELECT * FROM `Signup` WHERE email = '".mysqli_real_escape_string($link, $_POST['email'])."'";
                
                    $result = mysqli_query($link, $query);
                
                    $row = mysqli_fetch_array($result);
                
                    if (isset($row)) {
                        
                        $hashedPassword = md5(md5($row['id']).$_POST['password']);
                        
                        if ($hashedPassword == $row['password']) {
                            
                            $_SESSION['id'] = $row['id'];
                            
                            if ($_POST['stayLoggedIn'] == '1') {

                                setcookie("id", $row['id'], time() + 60*60*24*365);

                            } 

                            header("Location: logg.php");
                      }
                    }
            }
  }
  
      
      
      
      
?>

<form method="post">

    <input type="email" name="email" placeholder="Your Email">
    
    <input type="password" name="password" placeholder="Password" required="TRUE">
    
    <input type="checkbox" name="stayLoggedIn" value=1>
    
    <input type="hidden" name="signUp" value="0">
        
    <input type="submit" name="submit" value="Log In!">

</form>


