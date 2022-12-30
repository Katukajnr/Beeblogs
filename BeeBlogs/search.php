<?php
session_start();
 require "inc/process.php";
 require "inc/header.php";
 
 if(isset($_POST["search"])){
     $search = $_POST["search"];
 }else{
     $search = '';
 }
 ?>

<div class="container">
    <?php require './pages/header-home.php'; ?>
    <div class="container-fluid my-3">
        <div class="row justify-content-center">
            <div class="col-8">
                <div class="border p-3">
                    <form action="search.php" method="post">
                        <div class="form-group">
                            <h4>Search result for: <?php echo $search; ?></h4>
                            <input type="text" class="form-control" name="search" placeholder="Enter Search term" id=""
                                required>
                        </div>
                        <button type="submit" class="btn text-white mt-2"
                            style="background-color:#10597d;">Search</button>
                    </form>
                </div>
            </div>
            <div class="col-8">
                <div class="row">
                    <?php
              //displaying the search posts from database
              $searchterm = $_POST["search"];
              $sql = "SELECT * FROM posts WHERE title LIKE '%$searchterm%' ORDER BY id DESC";
              $query = mysqli_query($connection,$sql);
               while($result = mysqli_fetch_assoc($query)) { 
                //Looping through the col for multiples post
                ?>
                    <div class="col-4 mt-2">
                        <div class="card">
                            <img src="<?php echo $result["thumbnail"]; ?>" style="height:200px; width:100%"
                                class="card-img-top">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $result["title"]; ?></h5>
                                <p class="card-text">Date: <?php echo date("F j,Y", strtotime($result["timestamp"])) ?>
                                </p>
                                <a href="read-post.php?post_id=<?php echo $result["id"]; ?>" class="btn text-white"
                                    style="background-color:#10597d;">Read post</a>
                            </div>
                        </div>
                    </div>
                    <?php
            }
          ?>
                </div>
            </div>

        </div>
    </div>
    <?php require './pages/footer-home.php'; ?>
</div>

<?php
 require "inc/footer.php"; 
 ?>