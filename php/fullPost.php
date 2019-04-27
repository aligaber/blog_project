<?php 
require('connection.php');
require('session.php');
include('functions.php');
?>
<?php
if(isset($_POST['submit'])){
    $name = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $comment = mysqli_real_escape_string($conn, $_POST['comment']);
    date_default_timezone_set("Africa/Cairo");
    $dateTime = strftime("%B-%d-%Y %H:%M-%S",time());
    $postId = $_GET['id'];
    if(empty($_POST['username']) || empty($_POST['email']) || empty($_POST['comment'])){
        $_SESSION['ErrorMessage'] = 'All fields must be filled in';
    }else if(strlen($_POST['comment']) > 500 ){
        $_SESSION['ErrorMessage'] = 'maximum number of characters in comment is 500 charecters';
    }else{
        $query = "INSERT INTO `comments`(`datetime`,`name`,`email`,`comment`,`status`,`admin_panel_id`)
         VALUES('$dateTime','$name','$email','$comment','OFF','$postId')";
        if(mysqli_query($conn,$query)){
            $_SESSION['SuccessMessage'] = "comment added successfully";
            Redirect_to("fullPost.php?id=$postId");
        }else{
            $_SESSION['ErrorMessage'] = "something went wrong!!!!!!";
            Redirect_to("fullPost.php?id=$postId");
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
    <title>Blog</title>
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
                <li class="nav-item active"><a href="#" class="nav-link text-white active">Blog</a></li>
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
    <div class="container">
        <div class="blog-header">
            <h1>The Complete Responsive CMS Blog</h1>
            <p class="lead">the complete blog using native php and bootstrap</p>
        </div>
        <div class="row">
            <main class="col-sm-8">
               <?php 
               $id = $_GET['id'];
                $sql_cmd = "SELECT * FROM `admin_panel` WHERE `id` = '$id'";
                $res = mysqli_query($conn, $sql_cmd);
                $row = mysqli_fetch_array($res, MYSQLI_ASSOC);
                $postId = $row['id'];
                $datetime = $row['datetime'];
                $title = $row['title'];
                $category = $row['category'];
                $admin = $row['author'];
                $image = $row['image'];
                $post = $row['post'];
               ?>
                <figure class="figure">
                    <img src="../images/<?php echo($image); ?>" class="img-thumbnail figure-img img-fluid rounded">
                    <div class="figure-caption">
                        <h1 class="text-info "><?php echo(htmlentities($title));?></h1>
                        <p>
                            category:<?php echo(htmlentities($category));?> Published on 
                            <?php echo(htmlentities($datetime));?>
                        </p>
                        <p><?php
                            echo(nl2br($post));?>
                        </p>
                    </div>
                </figure>
                <h3 class="text-warning">Comments</h3>
                <?php
                    $sql_cmd = "SELECT * FROM comments WHERE `admin_panel_id` = $id AND `status`='ON'";
                    $res = mysqli_query($conn, $sql_cmd);
                    while($row  = mysqli_fetch_array($res, MYSQLI_ASSOC)){
                        $commenterName = $row['name'];
                        $comment = $row['comment'];
                        $dateTime = $row['datetime'];
                ?>
                <div class="bg-light p-2 mb-3">
                    <p class="text-info mb-0 h4"><i class="far fa-lg fa-user"></i> <?php echo($commenterName);?></p>
                    <small class="text-muted"><?php echo($dateTime); ?></small>
                    <p class="lead"><?php echo('>>'.nl2br($comment));?></p>
                </div>
                <hr/>
                    <?php } ?>
                <?php 
                    if(isset($_SESSION['ErrorMessage'])){
                        echo ErrorMessage();
                        $_SESSION['ErrorMessage'] = null;
                    }else if(isset($_SESSION['SuccessMessage'])){
                        echo SuccessMessage();
                        $_SESSION['successMessage'] = null;
                    }
                ?>
                <div class="card">
                    <div class="card-header">
                    <p class="text-warning lead">Share your thoughts about this post: </p>
                    </div>
                    <div class="card-body bg-secondary">
                        <form action="fullPost.php?id=<?php echo($postId); ?>" method="POST">
                            <div class="form-group">
                                <input type="text" name="username" class="form-control" placeholder="enter your name..">
                            </div>
                            <div class="form-group">
                                <input type="email" name="email" class="form-control" placeholder="email">
                            </div>
                            <div class="form-group">
                                <textarea name="comment" placeholder="write your comment..." class="form-control"></textarea>
                            </div>
                            <div class="form-group">
                                <button type="submit" name="submit" class="btn btn-warning">Comment</button>
                            </div>
                        </form>
                    </div>
                </div>
            </main>
            <aside class="col-sm-3 ml-auto">
            <div class="card mb-3 border-warning">
                    <div class="card-header bg-warning">
                        <h2 class="card-title text-center">Ads. | Notes</h2>                        
                    </div>
                    <div class="card-body  bg-light text-justify">
                        <p class="lead">Lorem ipsum dolor sit amet consectetur adipisicing elit. Corrupti 
                        modi officia porro ab, vel possimus qui, cumque eius, dignissimos 
                        sequi exercitationem quasi! Inventore, dolores maiores fugiat quibusdam 
                        </p>
                    </div>
                    <div class="card-footer bg-warning">
                    </div>
                </div>
                    <div class="card border-primary mb-5">
                    <div class="card-header bg-primary">
                        <h5 class="card-title text-center text-white m-0">Categories</h5>
                    </div>
                    <div class="list-group">
                        <?php 
                            $sql_cmd = "SELECT `id`,`category_name` FROM `categories`";
                            $res = mysqli_query($conn, $sql_cmd);
                            while($row = mysqli_fetch_array($res,MYSQLI_ASSOC)){
                                $id = $row['id'];
                                $name = $row['category_name'];
                        ?>
                            <a href="blog.php?category=<?php echo $name; ?>" class="bg-light list-group-item list-group-item-action"><?php  echo $name; ?></a>
                        <?php }?>
                    </div>
                    <div class="card-footer">

                    </div>
                </div>
                <!-- recent posts-->
                <div class="card border-primary mb-5">
                    <div class="card-header bg-primary">
                        <h5 class="card-title text-center m-0 text-white">Recent Posts</h5>
                    </div>
                    <div class="list-group">
                        <?php 
                            $sql_cmd = "SELECT * FROM `admin_panel` ORDER BY `datetime` DESC LIMIT 0,5";
                            $res = mysqli_query($conn, $sql_cmd);
                            while($row = mysqli_fetch_assoc($res)){
                                $id = $row['id'];
                                $datatime = $row['datetime'];
                                $title = $row['title'];
                                $image = $row['image'];
                        ?>
                        <a href="fullpost.php?id=<?php echo $id; ?>" class="bg-light list-group-item list-group-item-action">
                        <img class="float-left mr-2" src="../images/<?php echo $image; ?>" width=50 height=50>
                        <p class="lead m-0 p-0"><?php  
                        if(strlen($title) > 20){$title = substr($title,0,20);}
                            echo $title; 
                            ?>
                        </p>   
                        <span class="muted">
                        <?php 
                            if(strlen($datetime) > 13){$datetime = substr($datetime,0,13);}
                            echo $datetime; ?> </span>
                        </a>
                        <?php } ?>
                    </div>
                    <div class="card-footer">
                    </div>
                </div>
            </aside>
        </div>
    </div>
    <?php require('footer.php'); ?>