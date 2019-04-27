<?php 
require('connection.php');
require('session.php');
require('functions.php');
?>
<?php 
    if(isset($_POST['submit'])){
        $username = mysqli_real_escape_string($conn, $_POST['username']);
        $password = mysqli_real_escape_string($conn, $_POST['password']);
        
        if(empty($username) || empty($password)){
            $_SESSION['ErrorMessage'] = "All Fields Must Be Filled In";
            Redirect_to('login.php');
        }else{
            $hashedPassword = md5($id.md5($password));
            $sql_cmd = "SELECT * FROM registeration WHERE username='$username' AND password='$hashedPassword'";
            $res = mysqli_query($conn, $sql_cmd);
            $admin = mysqli_fetch_assoc($res);
           // $admin = loginAttempet($username, $password); 

           if(!empty($admin)){
                $_SESSION['user_id'] = $admin['id'];
                $_SESSION['username'] = $admin['username'];
                $_SESSION['SuccessMessage'] = "Welcome {$_SESSION["username"]}";
                Redirect_to('Dashboard.php');
            }else{
                $_SESSION['ErrorMessage'] = "Wrong username | password";
                Redirect_to('login.php');
            }
        }
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../css/all.min.css">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
    <title>Log in</title>
    <style>
        body{
            background-image:url('../images/background.jpg');
            background-repeat: no-repeat;
            background-size: cover;
        }

        .col-md-4{
            background-color:rgba(0,0,0,0.3)
        }
    </style>
</head>
<body>
    <div class="container-fluid">
            <main>
                <div class="w-50 mx-auto mt-4"><?php echo ErrorMessage(); ?></div>
                <h1 class="text-center mt-5 text-info">Welcome Back</h1>
                <div class="row">
                    <div class="col-md-4 mx-auto mt-5 border border-dark p-5">
                        <form action="login.php" method="POST">
                            <div class="form-group mb-5">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                                    </div>
                                    <input type="text" name="username" class="form-control" placeholder="User Name...">
                                </div>
                            </div>
                            <div class="form-group mb-5">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="fas fa-lock"></i>
                                        </span>
                                    </div>
                                    <input type="password" name="password" class="form-control" placeholder="Password...">
                                </div>
                            </div>
                            <div class="form-group">
                                <button type="submit" name="submit" class="btn btn-info mx-auto">Log In</button>
                            </div>
                        </form>
                    </div>
                </div>
             </main>
    </div>
</body>
</html>


