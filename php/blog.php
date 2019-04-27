<?php 
require('connection.php');
require('session.php');
include('functions.php');
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
                if(isset($_GET['searchBtn'])){
                    $searchInput  = $_GET['searchInput'];
                    $sql_cmd = "SELECT * FROM `admin_panel` WHERE 
                    `datetime` LIKE '%$searchInput%' OR
                    `title` LIKE '%$searchInput%' OR
                    `category` LIKE '%$searchInput%' oR
                    `post` LIKE '%$searchInput%'
                    ";
                }elseif(isset($_GET['category'])){

                    $category = $_GET['category'];
                    $sql_cmd = "SELECT * FROM `admin_panel` WHERE `category`='$category'"; 

                }else if(isset($_GET['page'])){
                    $startIndex = ($_GET['page'] * 5) - 5;
                    if($_GET['page'] < 1){
                        Redirect_to('blog.php?page=1');
                    }
                    $sql_cmd = "SELECT * FROM `admin_panel` ORDER BY datetime DESC LIMIT $startIndex,5";
                }else{
                    Redirect_to('blog.php?page=1');
                    //$sql_cmd = "SELECT * FROM `admin_panel` ORDER BY datetime DESC LIMIT 0,5";
                } 
                $res = mysqli_query($conn, $sql_cmd);
                while($row = mysqli_fetch_array($res, MYSQLI_ASSOC)){
                $postId = $row['id'];
                $datetime = $row['datetime'];
                $title = $row['title'];
                $category = $row['category'];
                $admin = $row['author'];
                $image = $row['image'];
                $post = $row['post'];
               ?>
                <div class="card card-body bg-light mb-5">
                    <figure class="figure">
                        <img src="../images/<?php echo($image); ?>" style="height:400px"  class="img-responsive img-thumbnail figure-img img-fluid rounded w-100">
                        <div class="figure-caption">
                            <h1 class="text-info "><?php echo(htmlentities($title));?></h1>
                            <p>
                                category:<?php echo(htmlentities($category));?> Published on 
                                <?php echo(htmlentities($datetime));?>
                                <?php
                                    $query = "SELECT COUNT(*) FROM `comments` WHERE `status`='ON' AND `admin_panel_id`='$postId'";
                                    $result = mysqli_query($conn, $query);
                                    $record = mysqli_fetch_array($result, MYSQLI_ASSOC);
                                    $total = array_shift($record);
                                    if($total > 0){
                                    ?>                
                                    <span class="badge badge-pill text-light badge-success ml-4">
                                    Comments: <?php echo($total); ?>
                                    </span>
                                    <?php } ?>
                            </p>
                            <p><?php
                                if(strlen($post) > 200){$post = substr($post,0,200).'...';}
                                echo( nl2br($post));?>
                            </p>
                        </div>
                        <a href="fullPost.php?id=<?php echo($postId); ?>" class="btn btn-info float-right">Read More &rsaquo;&rsaquo;</a>
                    </figure>
                </div>
                <?php }?>
                   <!-- pagination -->
                <?php 
                    if(isset($_GET['page'])){
                        $page = $_GET['page'];
                    // get number ofposts in the database
                    $sql_cmd = "SELECT COUNT(*) FROM `admin_panel`";
                    $res = mysqli_query($conn, $sql_cmd);
                    $row = mysqli_fetch_array($res);
                    $total = array_shift($row);
                    $numOfPages = ceil($total/2);
                ?>
                <nav class="mt-5" aria-label="Page navigation example">
                    <ul class="pagination pagination-lg">
                    <?php if($_GET['page'] > 1){?>
                       <li class="page-item">
                        <a class="page-link" href="blog.php?page=<?php echo --$page; ?>" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                        </li>
                    <?php } for($i = 1; $i <= $numOfPages; $i++){ 
                            if(isset($page)){
                                if($i == $_GET['page']){ ?>
                                <li class="page-item active"><a class="page-link" href="blog.php?page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
                          <?php  }else{ ?>
                                <li class="page-item"><a class="page-link" href="blog.php?page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
                <?php } }}
                if($_GET['page'] < $numOfPages ){
                ?>
                        <li class="page-item">
                        <a class="page-link" href="blog.php?page=<?php echo(++$_GET['page']); ?>" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                        </a>
                        </li>
                <?php }else{
                    $_GET['page'] = $numOfPages;
                } 
            }
                ?>
                    </ul>
                </nav>
            </main>
            <!-- Ending main area -->

            <!--start Side Area -->
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
                <!-- categories-->
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
    <!-- <footer class="bg-dark text-white text-center pt-3 pb-4 lead col"> 
            Created By Ali_Jaber <br>
            All Rights Reserved&copy;2019
    </footer>
    
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html> -->
<?php require('footer.php'); ?>
