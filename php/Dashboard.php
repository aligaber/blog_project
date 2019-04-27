<?php 
    require('session.php');
    require('connection.php');
    require('functions.php');
?>
<?php confirmLogin(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../css/all.min.css">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">

    <!-- favicon -->
    <!-- <link rel="shortcut icon" href="../images/favicon.ico" type="image/x-icon"> -->
    <link rel="icon" class="fas fa-th text-white" href="../images/th-solid.svg">
    <title>Dashboard</title>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-dark">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarToggler" aria-controls="navbarToggler" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarToggler">
            <a class="navbar-brand text-dark rounded-circle h4 p-2 ml-3">&lt;code/&gt;</a>
            <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                <li class="nav-item"><a href="blog.php" class="nav-link text-white">Home</a></li>
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
                    <li class="nav-item"><a href="Dashboard.php" class="nav-link active"><i class="fas fa-th"></i> Dashboard</a></li>
                    <li class="nav-item"><a href="addNewPost.php" class="nav-link" ><i class="far fa-clipboard"></i> Add New Post</a></li>
                    <li class="nav-item"><a href="categories.php" class="nav-link"><i class="fas fa-tags"></i> Categories</a></li>
                    <li class="nav-item"><a href="admins.php" class="nav-link"><i class="far fa-user"></i> Manage Admins</a></li>
                    <li class="nav-item"><a href="comments.php" class="nav-link"><i class="far fa-comment-alt"></i> Comments
                    <?php 
                        
                        $query = "SELECT COUNT(*) FROM `comments` WHERE `status`='OFF'";
                        $result = mysqli_query($conn, $query);
                        $record = mysqli_fetch_array($result, MYSQLI_ASSOC);
                        $total = array_shift($record);
                        if($total > 0){
                        ?>                
                        <span class="badge badge-pill text-light badge-warning ml-4">
                            <?php echo($total); ?>
                        </span>
                        <?php } ?>
                    </a></li>
                    <li class="nav-item"><a href="blog.php" class="nav-link"><i class="fab fa-blogger-b"></i> Live Blog</a></li>
                    <li class="nav-item"><a href="logout.php" class="nav-link"><i class="fas fa-sign-out-alt"></i>Logout</a></li>
                </nav>
            </aside>
            <main class="col-md-9 bg-light p-0">
            <?php 
                    if(isset($_SESSION['ErrorMessage'])){
                        echo ErrorMessage();
                        $_SESSION['ErrorMessage'] = null;
                    }else if(isset($_SESSION['SuccessMessage'])){
                        echo SuccessMessage();
                        $_SESSION['successMessage'] = null;
                    }
                ?>
                <h1 class="card-header">Admin Dashboard</h1>
                <div class="table-responsive border border-success">
                    <table class="table mb-0 table-dark text-centertable-striped table-hover table-bordered">
                        <tr>
                            <th class="p-1">id</th>
                            <th class="p-1">Post Title</th>
                            <th class="p-1">Date & Time</th>
                            <th class="p-1">Author</th>
                            <th class="p-1">Category</th>
                            <th class="p-1">Banner</th>
                            <th class="p-1">Comments</th>
                            <th class="p-1" colspan="2">Action</th>
                            <th class="p-1">Details</th>
                        </tr>
                        <?php 
                            $sql_cmd = "SELECT * FROM admin_panel";
                            $res = mysqli_query($conn, $sql_cmd);
                            while($row = mysqli_fetch_assoc($res)){
                                $id = $row['id'];
                                $dateTime = $row['datetime'];
                                $title = $row['title'];
                                $category = $row['category'];
                                $admin = $row['author'];
                                $image = $row['image'];
                                $post = $row['post'];
                        ?>
                        <tr>
                                <td class="p-1"><?php echo($id); ?></td>
                                <td class="p-1"><?php
                                    if(strlen($title > 20)){$title = substr($title,0,20)."..";}
                                    echo($title); 
                                 ?></td>
                                <td class="p-2"><?php
                                        if(strlen($dateTime) > 11){$dateTime = substr($dateTime,0,11)."..";} 
                                        echo($dateTime); 
                                    ?></td>
                                <td class="p-2"><?php 
                                if(strlen($admin) > 6){$admin = substr($admin,0,6)."..";} 
                                echo($admin); ?></td>
                                <td class="p-2"><?php
                                    if(strlen($category) > 8){$category = substr($category,0,8)."..";}
                                    echo($category); ?></td>
                                <td class="p-2"><img  style="width:100px;height:50px;" src="<?php echo("../images/".$image); ?>"></td>
                                <td class="p-2">
                                    <?php 
                                    $query = "SELECT COUNT(*) FROM `comments` WHERE `admin_panel_id` = '$id' AND `status`='ON'";
                                    $result = mysqli_query($conn, $query);
                                    $record = mysqli_fetch_array($result, MYSQLI_ASSOC);
                                    $total = array_shift($record);
                                    if($total > 0){
                                    ?>                
                                    <span class="badge badge-success float-right">
                                        <?php echo($total); ?>
                                    </span>
                                    <?php 
                                    }
                                    $query = "SELECT COUNT(*) FROM `comments` WHERE `admin_panel_id` = '$id' AND `status`='OFF'";
                                    $result = mysqli_query($conn, $query);
                                    $record = mysqli_fetch_array($result, MYSQLI_ASSOC);
                                    $total = array_shift($record);
                                    if($total > 0){
                                    ?>                
                                    <span class="badge badge-danger float-left">
                                        <?php echo($total); ?>
                                    </span>
                                    <?php } ?>
                                </td>
                                <td class="p-2">
                                    <a href="updatePost.php?edit=<?php echo($id);?>" class="btn btn-warning"><i class="fas text-info fa-sm fa-pencil-alt">Edit</i></a>
                                </td>
                                <td class="p-2">
                                    <a href="deletePost.php?delete=<?php echo($id);?>" class="btn btn-danger"><i class="fas text-light fa-sm fa-times">delete</i></a>
                                </td>
                                <td class="p-2"><a href="fullPost.php?id=<?php echo($id); ?>" class="btn btn-primary" target="_blank">Live Preview</a></td>
                        </tr>
                            <?php }?>
                    </table>
                </div>
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
