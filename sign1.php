<?php

    session_start();

    $error = "";    

    if (array_key_exists("logout", $_GET)) {
        
        unset($_SESSION);
        setcookie("id", "", time() - 60*60);
        $_COOKIE["id"] = "";  
        
    } else if ((array_key_exists("id", $_SESSION) AND $_SESSION['id']) OR (array_key_exists("id", $_COOKIE) AND $_COOKIE['id'])) {
        
       // header("Location: loggedinpage.php");
        
    }

    if (array_key_exists("submit", $_POST)) {
        
        
        
        $link = mysqli_connect("localhost","root","","travel");

        
        if (mysqli_connect_error()) {
            
            die ("Database Connection Error");
            
        }
        
        
        
        if (!$_POST['email']) {
            
            $error .= "An email address is required<br>";
            
        } 
        
        if (!$_POST['password']) {
            
            $error .= "A password is required<br>";
            
        } 
        
        if ($error != "") {
            
            $error = "<p>There were error(s) in your form:</p>".$error;
            
        } else {
            
            if ($_POST['signUp'] == '1') {
            
                $query = "SELECT id FROM `Signup` WHERE email = '".mysqli_real_escape_string($link, $_POST['email'])."' LIMIT 1";

                $result = mysqli_query($link, $query);

                if (mysqli_num_rows($result) > 0) {

                    $error = "That email address is taken.";

                } else {
                    
                    $hashedPassword = md5(md5($_POST['email']).$_POST['password']);

                    $query = "INSERT INTO `Signup` (`name`,`email`,`age`,`password`,`confirm`) VALUES ('".mysqli_real_escape_string($link, $_POST['name'])."','".mysqli_real_escape_string($link, $_POST['email'])."','".mysqli_real_escape_string($link, $_POST['age'])."', '".$hashedPassword."','".mysqli_real_escape_string($link, $_POST['confirm'])."')";

                    if (mysqli_query($link, $query)) {
                    
                    echo "<p>You have been signed up!</p>";
                   
                } else {
                    
                    echo "<p>There was a problem signing you up - please try again later.</p>";
                
            }
                }
            }else {
                    
                    $query = "SELECT * FROM `Signup` WHERE email = '".mysqli_real_escape_string($link, $_POST['email'])."'";
                
                    $result = mysqli_query($link, $query);
                
                    $row = mysqli_fetch_array($result);
                
                
                    if (isset($row)) {
                        
                       
                        
                        $hashedPassword = md5(md5($row['email']).$_POST['password']);
                        //echo $hashedPassword." ------------".$row['password'];
                      // exit(0);
                       // $hashedPassword = $_POST['password'];
                        
                        if ($hashedPassword == $row['password']) {
                            
                            $_SESSION['id'] = $row['id'];
                            
                            if ($_POST['stayLoggedIn'] == '1') {

                                setcookie("id", $row['id'], time() + 60*60*24*365);

                            } 

                            header("Location:train_form.php");
                                
                        } else {
                            
                            $error = "That email/password combination could not be found.";
                            
                        }
                        
                    } else {
                        
                        $error = "That email/password combination could not be found.";
                        
                    }
                    
                }
            
        }
        
        
    }


?>

<div id="error"><?php echo $error; ?></div>



 <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">

<style>

    .center{
  position: absolute;
  width: 800px;
  height: 600px;
  z-index: 15;
  top: 30%;
  left: 20%;
    opacity: 0.6;
         filter: alpha(opacity=60);     
 
    }
    
   html { 
  background: url(background.jpg) no-repeat center center fixed; 
  -webkit-background-size: cover;
  -moz-background-size: cover;
  -o-background-size: cover;
  background-size: cover;
}
    body{
        background: none;
    }
    
    #scroll{
        position: sticky;
    }
</style>
<body>
    
    
</form>

<nav class="navbar navbar-expand-lg navbar-light bg-light" id="scroll">
    <a class="navbar-brand" href="#">MY Tour</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="#"><span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#"></a>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="#">Action</a>
          <a class="dropdown-item" href="#">Another action</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="#">Something else here</a>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link disabled" href="#"></a>
      </li>
    </ul>
<form method="post" class="form-inline my-2 my-lg-0">

    <input class="form-control mr-sm-2" type="email" name="email" placeholder="Your Email">
    
    <input class="form-control mr-sm-2" type="password" name="password" placeholder="Password">
    
    
    <input type="hidden" name="signUp" value="0">
        
    <input  type="submit" name="submit" value="Log In!">

    </form>
    </nav>
    <nav class="center">
    <form method="post">
        
         <div class="form-group">
    <label for="exampleInputEmail1">Name</label>
    <input class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="name" type="name" placeholder="Enter name">
  </div>

      <div class="form-group">
    <label for="exampleInputEmail1">Email address</label>
    <input class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="email" type="email" placeholder="Enter email">
  </div>
        
      <div class="form-group">
    <label for="exampleInputEmail1">Email address</label>
    <input class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="password" type="password" placeholder="Enter password">
  </div>
        
          <div class="form-group">
    <label for="exampleInputEmail1">Email address</label>
    <input class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="age" type="text" placeholder="Enter age">
  </div>
    
    
    <input type="hidden" name="signUp" value="1">
        
       <button type="submit" class="btn btn-primary" name="submit" value="Sign Up!">Submit</button>
        

</form>
        </nav>
    </div>
<img src="background.jpg">
</body>