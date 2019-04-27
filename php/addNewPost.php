<?php 
require('connection.php');
require('session.php');
include('functions.php');
?>
<?php confirmLogin(); ?>
<?php 
if(isset($_POST['submit'])){
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $category = mysqli_real_escape_string($conn, $_POST['category']);
    $post = mysqli_real_escape_string($conn, $_POST['post']);
    date_default_timezone_set("Africa/Cairo");
    $dateTime = strftime("%B-%d-%Y %H:%M-%S",time());
    $admin = $_SESSION['username'];
    $image = $_FILES['image']['name'];
    $target = "images/".basename($image);
    if(empty($_POST['title']) || empty($_POST['post']) ||empty($_POST['category'])){
        $_SESSION['ErrorMessage'] = 'All fields must be filled in';
        Redirect_to('addNewPost.php');
    }else if(strlen($_POST['title']) < 2 ){
        $_SESSION['ErrorMessage'] = 'title must be at least 2 characters';
        Redirect_to('addNewPost.php');
    }else{
        $query = "INSERT INTO `admin_panel`(`datetime`,`title`,`category`,`author`,`image`,`post`)
         VALUES('$dateTime','$title','$category','$admin','$image','$post')";
         move_uploaded_file($_FILES['image']['tmp_name'],$target);
        if(mysqli_query($conn,$query)){
            $_SESSION['SuccessMessage'] = "Post has been add successfull!!";
            Redirect_to('addNewPost.php');
        }else{
            $_SESSION['ErrorMessage'] = "something went wrong!!!!!!";
            Redirect_to('addNewPost.php ');
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
    <title>Comments</title>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-dark">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarToggler" aria-controls="navbarToggler" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarToggler">
            <a class="navbar-brand text-dark rounded-circle h4 p-2 ml-3">&lt;code/&gt;</a>
            <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                <li class="nav-item"><a href="#" class="nav-link text-white">Home</a></li>
                <li class="nav-item active"><a href="blog.php" class="nav-link text-white active" target="_blank">Blog</a></li>
                <li class="nav-item"><a href="#" class="nav-link text-white">About Us</a></li>
                <li class="nav-item"><a href="#" class="nav-link text-white">Services</a></li>
                <li class="nav-item"><a href="#" class="nav-link text-white">Contact Us</a></li>
                <li class="nav-item"><a href="#" class="nav-link text-white">Features</a></li>
            </ul>
            <form class="form-inline my-2 my-lg-0" method="GET">
                <div class="form-group">
                    <input type="search"  name="searchInput" class="form-control mr-sm-2" placeholder="Search...">
                    <button type="submit" name="searchBtn" class="btn btn-light ml-3 my-2 my-sm-0">Go</button>
                </div>            
            </form>
        </div>
    </nav>
    <div class="container-fluid">
        <div class="row">
            <aside class="col-md-3 bg-dark lead" style="height: 100vh">
                <nav class=" nav flex-column nav-pills mt-5">
                    <li class="nav-item"><a href="Dashboard.php" class="nav-link"><i class="fas fa-th"></i> Dashboard</a></li>
                    <li class="nav-item"><a href="addNewPost.php" class="nav-link" ><i class="far fa-clipboard"></i> Add New Post</a></li>
                    <li class="nav-item"><a href="categories.php" class="nav-link"><i class="fas fa-tags"></i> Categories</a></li>
                    <li class="nav-item"><a href="admins.php" class="nav-link"><i class="far fa-user"></i> Manage Admins</a></li>
                    <li class="nav-item"><a href="comments.php" class="nav-link active"><i class="far fa-comment-alt"></i> Comments</a></li>
                    <li class="nav-item"><a href="blog.php" class="nav-link"><i class="fab fa-blogger-b"></i> Live Blog</a></li>
                    <li class="nav-item"><a href="logout.php" class="nav-link"><i class="fas fa-sign-out-alt"></i>Logout</a></li>
                </nav>
            </aside>
            <main class="col-md-9 bg-light">
            <?php 
                    if(isset($_SESSION['ErrorMessage'])){
                        echo ErrorMessage();
                        $_SESSION['ErrorMessage'] = null;
                    }else if(isset($_SESSION['SuccessMessage'])){
                        echo SuccessMessage();
                        $_SESSION['successMessage'] = null;
                    }
                ?>
                
                <div class="row">
                    <div class="col-md-6 mx-auto mt-5">
                        <div class="card border border-dark">
                            <div class="card-header">
                            <h2 class="card-header text-primary text-center">Add New Post</h2>
                            </div>
                            <div class="card-body bg-dark">
                                <form action="addNewPost.php" method="POST" enctype="multipart/form-data">
                                    <div class="form-group">
                                        <input type="text" name="title" class="form-control" placeholder="Title...">
                                    </div>
                                    <div class="form-group">
                                        <select name="category" class="form-control">
                                            <option disabled>Select a category</option>
                                            <?php 
                                                $sql_cmd = "SELECT category_name FROM `categories` ORDER BY `id` DESC";
                                                $res = mysqli_query($conn, $sql_cmd);
                                                while($row = mysqli_fetch_array($res,MYSQLI_ASSOC)){
                                                    $category_name = $row['category_name'];
                                            ?>
                                            <option><?php echo $category_name;}?></option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <input type="file" name="image" class="form-control">
                                    </div>
                                    <div class="form-group">
                                    <textarea name="post" class="form-control" placeholder="write your psot..."></textarea>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" name="submit" class="btn btn-block btn-primary">Add New Post</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>     
            </div>
            <!-- <footer class="bg-dark text-white text-center pt-3 pb-4 lead col"> 
                Created By Ali_Jaber <br>
                All Rights Reserved&copy;2019
            </footer>                                       
        </div>
    </body>
</html> -->
<?php require('footer.php'); ?>
