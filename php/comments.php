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
                <h1 class="card-header">Un-Approved Comments</h1>
                <div class="table-responsive">
                    <table class="table table-dark text-centertable-striped table-hover table-bordered">
                        <tr>
                            <th class="p-1">SN</th>
                            <th class="p-1">Name</th>
                            <th class="p-1">Date & Time</th>
                            <th class="p-1">Comment</th>
                            <th class="p-1">Approve</th>
                            <th class="p-1">Delete Comment</th>
                            <th class="p-1">Details</th>
                        </tr>
                        <?php 
                            $SN = 0;
                            $sql_cmd = "SELECT * FROM `comments` WHERE `status`='OFF' ORDER BY `datetime` DESC";
                            $res = mysqli_query($conn, $sql_cmd);
                            while($row = mysqli_fetch_array($res, MYSQLI_ASSOC)){
                                $id = $row['id'];
                                $dateTime = $row['datetime'];
                                $commeterName = $row['name'];
                                $comment = $row['comment'];
                                $admin_panel_id = $row['admin_panel_id'];
                                $SN++;
                        ?>
                        <tr>
                                <td class="p-1"><?php echo($SN); ?></td>
                                <td class="p-1"><?php 
                                    if(strlen($commeterName) > 10){$commeterName = substr($commeterName,0,10);}
                                echo($commeterName);?></td>
                                <td class="p-2"><?php
                                if(strlen($dateTime) > 10){$dateTime = substr($dateTime,0,10);}
                                echo($dateTime);?></td>
                                <td class="p-2"><?php 
                                if(strlen($comment) > 10){$comment = substr($comment,0,18);}
                                echo($comment);?></td>
                                <td class="p-2"><a href="approveComments.php?id=<?php echo($id); ?>" class="btn btn-success">Approve</a></td>
                                <td class="p-2"><a href="deleteComments.php?id=<?php echo $id; ?>" class="btn btn-danger">Delete</a></td>
                                <td class="p-2"><a href="fullPost.php?id=<?php echo($admin_panel_id); ?>" class="btn btn-primary" target='_blank'>Live Preview</a></td>
                        </tr>
                            <?php }?>
                    </table>
                </div>
                <!--Approved Comments -->
                <h1 class="card-header">Approved Comments</h1>
                <div class="table-responsive">
                    <table class="table table-dark text-centertable-striped table-hover table-bordered">
                        <tr>
                            <th class="p-1">SN</th>
                            <th class="p-1">Name</th>
                            <th class="p-1">Date & Time</th>
                            <th class="p-1">Comment</th>
                            <th class="p-1">Approved By</th>                            
                            <th class="p-1">Revert Approve</th>
                            <th class="p-1">Delete Comment</th>
                            <th class="p-1">Details</th>
                        </tr>
                        <?php 
                            $SN = 0;
                            $sql_cmd = "SELECT * FROM `comments` WHERE `status`='ON' ORDER BY `datetime` DESC";
                            $res = mysqli_query($conn, $sql_cmd);
                            while($row = mysqli_fetch_array($res, MYSQLI_ASSOC)){
                                $id = $row['id'];
                                $dateTime = $row['datetime'];
                                $commeterName = $row['name'];
                                $comment = $row['comment'];
                                $admin_panel_id = $row['admin_panel_id'];
                                $admin = $row['approvedby'];
                                $SN++;
                        ?>
                        <tr>
                                <td class="p-1"><?php echo($SN); ?></td>
                                <td class="p-1"><?php 
                                    if(strlen($commeterName) > 10){$commeterName = substr($commeterName,0,10);}
                                echo($commeterName);?></td>
                                <td class="p-2"><?php
                                if(strlen($dateTime) > 10){$dateTime = substr($dateTime,0,10);}
                                echo($dateTime);?></td>
                                <td class="p-2"><?php 
                                if(strlen($comment) > 10){$comment = substr($comment,0,18);}
                                echo($comment);?></td>
                                <td><?php echo $admin; ?></td>
                                <td class="p-2"><a href="disapproveComments.php?id=<?php echo $id; ?>" class="btn btn-warning">Disapprove</a></td>
                                <td class="p-2"><a href="deleteComments.php?id=<?php echo $id; ?>" class="btn btn-danger">Delete</a></td>
                                <td class="p-2"><a href="fullPost.php?id=<?php echo($admin_panel_id); ?>" class="btn btn-primary" target='_blank'>Live Preview</a></td>
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
