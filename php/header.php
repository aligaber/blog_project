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
            <main class="col-md-9 bg-white">
            <?php 
                    if(isset($_SESSION['ErrorMessage'])){
                        echo ErrorMessage();
                        $_SESSION['ErrorMessage'] = null;
                    }else if(isset($_SESSION['SuccessMessage'])){
                        echo SuccessMessage();
                        $_SESSION['successMessage'] = null;
                    }
                ?>

