<?php 
require('connection.php');
require('session.php');
include('functions.php');
?>
<?php confirmLogin(); ?>
<?php 
if(isset($_POST['submit'])){
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $confirmPassword = mysqli_real_escape_string($conn, $_POST['confirmPassword']);
    date_default_timezone_set("Africa/Cairo");
    $dateTime = strftime("%B-%d-%Y %H:%M-%S",time());
    $admin = $_SESSION['username'];
    if(empty($_POST['username']) || empty($_POST['password']) || empty($_POST['confirmPassword'])){
        $_SESSION['ErrorMessage'] = 'All fields must be filled in';
        Redirect_to('admins.php');
    }else if(strlen($_POST['password']) < 8 ){
        $_SESSION['ErrorMessage'] = 'password must be at least 8 characters';
        Redirect_to('admins.php');
    }else if($password != $confirmPassword){
        $_SESSION['ErrorMessage'] = 'Password/ confirm Password does not match';
        Redirect_to('admins.php');
    }else{
        // hashing password 
        $hashedPassword = md5($id.md5($password));
        $query = "INSERT INTO `registeration`(`datetime`,`username`,`password`,`addedby`)
         VALUES('$dateTime','$username','$hashedPassword','$admin')";
        if(mysqli_query($conn,$query)){
            $_SESSION['SuccessMessage'] = "new admin has been add successfull!!";
            Redirect_to('admins.php');
        }else{
            $_SESSION['ErrorMessage'] = "something went wrong!!!!!!";
            Redirect_to('admins.php');
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
    <title>Manage Admins</title>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <aside class="col-sm-3 bg-dark lead" style="height: 100vh">
                <nav class=" nav flex-column nav-pills mt-5">
                    <li class="nav-item"><a href="Dashboard.php" class="nav-link"><i class="fas fa-th"></i> Dashboard</a></li>
                    <li class="nav-item"><a href="addNewPost.php" class="nav-link" ><i class="far fa-clipboard"></i> Add New Post</a></li>
                    <li class="nav-item"><a href="categories.php" class="nav-link"><i class="fas fa-tags"></i> Categories</a></li>
                    <li class="nav-item"><a href="admins.php" class="nav-link active"><i class="far fa-user"></i> Manage Admins</a></li>
                    <li class="nav-item"><a href="comments.php" class="nav-link"><i class="far fa-comment-alt"></i> Comments</a></li>
                    <li class="nav-item"><a href="blog.php" class="nav-link"><i class="fab fa-blogger-b"></i> Live Blog</a></li>
                    <li class="nav-item"><a href="logout.php" class="nav-link"><i class="fas fa-sign-out-alt"></i>Logout</a></li>
                </nav>
            </aside>
            <main class="col-sm-9 bg-light">
                <?php 
                
                    if(isset($_SESSION['ErrorMessage'])){
                        echo ErrorMessage();
                    }else if(isset($_SESSION['SuccessMessage'])){
                        echo SuccessMessage();
                    }
                ?>
                
                <div class="row">
                    <div class="col-md-6 mx-auto mt-5">
                        <div class="card">
                            <div class="card-header">
                                <h2 class="card-title text-center text-success">Manage Admins</h2>  
                            </div>
                            <div class="card-body bg-dark">
                                <form action="admins.php" method="POST">
                                    <div class="form-group">
                                        <input type="text" name="username" class="form-control" placeholder="User Name...">
                                    </div>
                                    <div class="form-group">
                                        <input type="password" name="password" class="form-control" placeholder="Password...">
                                    </div>
                                    <div class="form-group">
                                        <input type="password" name="confirmPassword" class="form-control" placeholder="Confirm Password...">
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" name="submit" class="btn btn-block btn-success">Add New Admin</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <table class="table table-striped mt-5">
                            <thead class="table-dark">
                               <tr>
                                <th>Sr. No</th>
                                <th>Date & Time</th>
                                <th>Admin Name</th>
                                <th>Added By</th>
                                <th>Action</th>
                               </tr>
                            </thead>
                            <tbody>
                            <?php 
                                $sql_cmd = "SELECT * FROM `registeration` ORDER BY `id` DESC";
                                $res = mysqli_query($conn, $sql_cmd);
                                $serial = 0;
                                while($row = mysqli_fetch_array($res,MYSQLI_ASSOC)){
                                    $id = $row['id'];
                                    $datetime = $row['datetime'];
                                    $username = $row['username'];
                                    $addedby = $row['addedby'];
                                    $serial++;
                            ?>
                                <tr>
                                    <td><?php echo $serial; ?></td>
                                    <td><?php echo $datetime; ?></td>
                                    <td><?php echo $username; ?></td>
                                    <td><?php echo $addedby; ?></td>
                                    <td><a href="deleteAdmin.php?id=<?php echo $id; ?>" class="btn btn-danger">Delete</a></td>
                                </tr>
                            </tbody>
                                <?php }?>
                        </table>
            </main>
            <!-- <footer class="bg-dark text-white text-center pt-3 pb-4 lead col"> 
                Created By Ali_Jaber <br>
                All Rights Reserved&copy;2019
            </footer>
        </div>
    </div>
</body>
</html> -->
<?php require('footer.php'); ?>
