
<?php
 session_start();//

     if(isset($_SESSION["logged"]) && $_SESSION["logged"]){
      header("Location: cars.php");
      die();
    }

if($_SERVER["REQUEST_METHOD"] === "POST"){
  include_once("includes/conn.php");
  if(isset($_POST["register"])){//register form


        $fullname = $_POST["fullname"];
        //$pass = password_hash($_POST["password"],PASSWORD_DEFAULT);
        $pass = $_POST["password"];
        $email = $_POST["email"];
        $username = $_POST["username"];
        try{
            $sql = "INSERT INTO `users`(`email`, `fullname`, `password`, `username`) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$email, $fullname, $pass, $username]);
           header("Location: login.php"); //go to login
            die();
        }catch(PDOException $e){
            echo "Connection failed: " . $e->getMessage();
        }
  }
  //login form.............................................................


  elseif(isset($_POST["login"])){

        $pass =$_POST ["password"];
        $username = $_POST["username"];
        
        try{
            $sqll ="SELECT `password`,`id` FROM `users` where`username`= ? and `active`= 1 "; 
            $stmtl = $conn->prepare($sqll);
            $stmtl->execute([$username]);
            if($stmtl->rowCount() > 0){
               $result=$stmtl->fetch();
               $hash=$result["password"];
               $id=$result["id"];
               $verify=password_verify($pass,$hash);
               if($hash==$pass){
               $_SESSION["logged"]=true;//
              // echo $id;
               header("Location: cars.php"); 
                die();
              }else{
                    echo "password not correct";
                    }
               

             }else{ echo "not found";}   
            
           
        }catch(PDOException $e){
            echo "Connection failed: " . $e->getMessage();
        }

  }
}

?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Rent Car Admin | Login/Register</title>

    <!-- Bootstrap -->
    <link href="vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="vendors/nprogress/nprogress.css" rel="stylesheet">
    <!-- Animate.css -->
    <link href="vendors/animate.css/animate.min.css" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="build/css/custom.min.css" rel="stylesheet">
  </head>

  <body class="login">
    <div>
      <a class="hiddenanchor" id="signup"></a>
      <a class="hiddenanchor" id="signin"></a>

      <div class="login_wrapper">
        <div class="animate form login_form">
          <section class="login_content">
            <form action=""  method="Post">
              <h1>Login Form</h1>
              <div>
                <input type="text" class="form-control" placeholder="Username" name="username" required="" />
              </div>
              <div>
                <input type="password" class="form-control" placeholder="Password" name="password" required="" />
              </div>
              <div>
                <!--a class="btn btn-default submit" href="index.html">Log in</a!-->
                
                <a href="cars.php?id=<?php echo $id;  ?>"><input class="btn btn-default submit" type="submit" name="login" value="login"></a>
                <a class="reset_pass" href="#">Lost your password?</a>
              </div>

              <div class="clearfix"></div>

              <div class="separator">
                <p class="change_link">New to site?
                  <a href="#signup" class="to_register"> Create Account </a>
                </p>

                <div class="clearfix"></div>
                <br />

                <div>
                  <h1><i class="fa fa-car"></i></i> Rent Car Admin</h1>
                  <p>©2016 All Rights Reserved. Rent Car Admin is a Bootstrap 4 template. Privacy and Terms</p>
                </div>
              </div>
            </form>
          </section>
        </div>

        <div id="register" class="animate form registration_form">
          <section class="login_content">
            <form action="" method="Post">
              <h1>Create Account</h1>
              <div>
                <input type="text" class="form-control" placeholder="Fullname" name="fullname" required="" />
              </div>
              <div>
                <input type="text" class="form-control" placeholder="Username" name="username" required="" />
              </div>
              <div>
                <input type="email" class="form-control" placeholder="Email" name="email" required="" />
              </div>
              <div>
                <input type="password" class="form-control" placeholder="Password" name="password" required="" />
              </div>
              <div>
                <!--<a class="btn btn-default submit" href="index.html">Submit</a>!-->
                <input  class="btn btn-default submit" type="submit" name="register" value="Register">
               
              </div>

              <div class="clearfix"></div>

              <div class="separator">
                <p class="change_link">Already a member ?
                  <a href="#signin" class="to_register"> Log in </a>
                  
                </p>

                <div class="clearfix"></div>
                <br />

                <div>
                  <h1><i class="fa fa-car"></i></i> Rent Car Admin</h1>
                  <p>©2016 All Rights Reserved. Rent Car Admin is a Bootstrap 4 template. Privacy and Terms</p>
                </div>
              </div>
            </form>
          </section>
        </div>
      </div>
    </div>
  </body>
</html>
