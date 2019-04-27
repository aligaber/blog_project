<?php 
require('connection.php');
require('session.php');
include('functions.php');
?>
<?php confirmLogin(); ?>
<?php 
$id = $_GET['edit'];
if(isset($_POST['submit'])){
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $category = mysqli_real_escape_string($conn, $_POST['category']);
    $post = mysqli_real_escape_string($conn, $_POST['post']);
    date_default_timezone_set("Africa/Cairo");
    $dateTime = strftime("%B-%d-%Y %H:%M-%S",time());
    $admin = $_SESSION['username'];
    $image = $_FILES['image']['name'];
    $target = "images/".basename($image);
    if(empty($_POST['title']) || empty($_POST['post']) ||empty($_POST['category']) || empty($_FILES['image'])){
        $_SESSION['ErrorMessage'] = 'All fields must be filled in';
        Redirect_to("updatePost.php?edit=$id");
    }else if(strlen($_POST['title']) < 2 ){
        $_SESSION['ErrorMessage'] = 'title must be at least 2 characters';
        Redirect_to("updatePost.php?edit=$id");
    }else{
        $query = "UPDATE `admin_panel` SET `datetime` = '$dateTime',`title` = '$title'
        ,`category` = '$category',`author` = '$admin',`image` = '$image',`post` = '$post' WHERE `id` = '$id'";
         move_uploaded_file($_FILES['image']['tmp_name'],$target);
        if(mysqli_query($conn,$query)){
            $_SESSION['SuccessMessage'] = "Post has been updated successfull!!";
            Redirect_to('Dashboard.php');
        }else{
            $_SESSION['ErrorMessage'] = "something went wrong!!!!!!";
            Redirect_to("updatePost.php?edit=$id");
    }
    }
    print_r($_GET); print_r($_POST);
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
    <title>Update Post</title>
</head>
<body>
    <div class="container-fluid p-0">
        <div class="row">
            <aside class="col-sm-3 bg-dark lead" style="height: 100vh">
                <nav class=" nav flex-column nav-pills mt-5">
                    <li class="nav-item"><a href="Dashboard.php" class="nav-link"><i class="fas fa-th"></i> Dashboard</a></li>
                    <li class="nav-item"><a href="addNewPost.php" class="nav-link active" ><i class="far fa-clipboard"></i> Add New Post</a></li>
                    <li class="nav-item"><a href="categories.php" class="nav-link"><i class="fas fa-tags"></i> Categories</a></li>
                    <li class="nav-item"><a href="#" class="nav-link"><i class="far fa-user"></i> Manage Admins</a></li>
                    <li class="nav-item"><a href="#" class="nav-link"><i class="far fa-comment-alt"></i> Comments</a></li>
                    <li class="nav-item"><a href="#" class="nav-link"><i class="fab fa-blogger-b"></i> Live Blog</a></li>
                    <li class="nav-item"><a href="#" class="nav-link"><i class="fas fa-sign-out-alt"></i>Logout</a></li>
                </nav>
            </aside>
            <main class="col-sm-9 bg-white">
             <?php   if(isset($_SESSION['ErrorMessage'])){
                        echo ErrorMessage();
                        $_SESSION['ErrorMessage'] = null;
                    }
                    ?> 
                <?php 
                          //get values from database
                          $sql_cmd = "SELECT * FROM `admin_panel` WHERE `id` = $id";
                          $res = mysqli_query($conn, $sql_cmd);
                          $row = mysqli_fetch_array($res, MYSQLI_ASSOC);
                          $title = $row['title'];
                          $category = $row['category'];
                          $image = $row['image'];
                          $post = $row['post'];
                          ?>
                <div class="row bg-light">
                    <div class="col-md-6 mx-auto mt-5">
                        <div class="card">
                            <div class="card-header">
                                <h1 class="card-title text-warning text-center">Update Post</h1>
                            </div>
                            <div class="card-body bg-dark">
                                <form action="updatePost.php?edit=<?php echo $id;?>" method="POST" enctype="multipart/form-data">
                                    <div class="form-group">
                                        <input type="text" value="<?php echo($title); ?>" name="title" class="form-control" placeholder="Title...">
                                    </div>
                                    <div class="form-group">
                                        <span class="text-warning">Existing category: <?php echo($category); ?></span>
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
                                        <span class="text-warning">Existing image: </span>
                                        <img src="../images/<?php echo($image);?>" height="50px" width="100px" />
                                        <input type="file" name="image" class="form-control mt-2">
                                    </div>
                                    <div class="form-group">
                                    <textarea name="post" class="form-control" placeholder="write your post..."><?php echo($post); ?></textarea>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" name="submit" class="btn btn-block btn-outline-warning">Update Post</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>     
            </div>
            <?php require('footer.php'); ?>
            <!-- <footer class="bg-dark text-white text-center pt-3 pb-4 lead col"> 
                Created By Ali_Jaber <br>
                All Rights Reserved&copy;2019
            </footer>                                       
        </div>
    </body>
</html> -->