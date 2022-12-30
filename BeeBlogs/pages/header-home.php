<nav class="navbar rounded navbar-light " style="background-color:#333652">
    <div class=" container-fluid">
        <a class="navbar-brand text-light" href="index.php">
            <h4> <i class="fas fa-bars"></i> <!-- BeeBlogs --></h4>
        </a>
        <div class="d-flex">
            <?php 
        if(isset($_SESSION["user"])){
          ?>
            <a href="dashboard.php" class="nav-link text-white">Dashboard </a><span></span>
            <a href="logout.php" class="nav-link text-danger"> 
                <i class="fas fa-sign-out-alt"></i> Logout</a>
            <?php
        }else{
          ?>
            <a href="login.php" class="nav-link text-white">
            <i class="fas fa-sign-in-alt"></i> Login </a><span></span>
            <a href="register.php" class="nav-link text-white">
            <i class="fas fa-sign-in-alt"></i> Signup</a>
            <?php
        }
      ?>
        </div>
    </div>
</nav>