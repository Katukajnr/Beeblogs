<?php  
session_start();

//check if user is not logged in
if(!isset($_SESSION["user"])){
    header("location: login.php");
}//check if logged in as user
if($_SESSION["user"]["role"] == "user"){
    header("location: index.php");
}

//header links
 require "inc/header.php"; ?>

<div class="container">

<?php
 //header content
 require './pages/header-home.php';
 include 'inc/process.php'; 

  //if user click edit
if(isset($_GET["edit_post_id"]) && !empty($_GET["edit_post_id"])){
    $edit_post_id = $_GET["edit_post_id"];
    //sql
    $sql = "SELECT * FROM posts WHERE id = '$edit_post_id'";
    $query = mysqli_query($connection,$sql);
    $result = mysqli_fetch_assoc($query);
}else{
    header("location: post.php");

}
 ?>

    <div class="container p-3">
        <div class="row">
            <div class="col-12">
                <div class="row">
                    <div class="col-6">
                        <h4>Welcome <?php  echo $_SESSION["user"]["name"]; ?></h4>
                    </div>
                    <div class="col-6">
                        <a href="logout.php" class="btn btn-sm btn-danger">Logout</a>
                    </div>
                </div>
            </div>
            <div class="col-3">
                <h5>Navigations</h5>
                <ul>
                    <li>
                        <a href="post.php">Posts</a>
                    </li>
                    <li>
                        <a href="comments.php">Comments</a>
                    </li>
                    <li>
                        <a href="new-post.php" class="text-danger">Add New Post</a>
                    </li>
                    <li>
                        <a href="category.php">Categories</a>
                    </li>
                    <li>
                        <a href="users.php">Users</a>
                    </li>
                    <li>
                        <a href="new-user.php">Add New User</a>
                    </li>
                </ul>
            </div>
            <div class="col-9">
                <div class="container">
                    <h6>Edit Post</h6>
                    <?php 
                    if(isset($error)) {
                    ?>
                    <div class="alert alert-danger">
                        <strong><?php echo $error ?></strong>
                    </div>
                    <?php
                         }elseif (isset($success)) {
                    ?>
                    <div class="alert alert-success">
                        <strong><?php echo $success ?></strong>
                    </div>
                    <?php
                   }
                 ?>
                    <form action="" method="post" enctype="multipart/form-data">
                        <img height="50px" src="<?php echo $result["thumbnail"]?>" alt="">
                        <div class="form-group">
                            <label for="">Select Thumbnail</label>
                            <input type="file" name="thumbnail" id="" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="">Title</label>
                            <input type="text" name="title" placeholder="Enter title"
                                value="<?php echo $result["title"] ?>" class="form-control" id="">
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="">Status</label>
                                    <select name="status" class="form-control" id="">
                                        <option value="1" <?php echo $result["status"] == 1 ? "selected" : "" ?>>
                                            Active</option>
                                        <option value="0" <?php echo $result["status"] == 0 ? "selected" : "" ?>>
                                            Not active</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="">Category</label>
                                    <select name="category_id" class="form-control" id="">
                                        <?php
                                         $sql = "SELECT * FROM category ORDER BY id DESC";
                                         $query = mysqli_query($connection,$sql);
                                         while($result2 = mysqli_fetch_assoc($query)){
                                             ?>
                                        <option value="<?php echo $result2["id"] ?>"
                                            <?php echo $result["category_id"] == $result2["id"] ? "selected" : "" ?>>
                                            <?php echo $result2["name"] ?>
                                        </option>
                                        <?php
                                         }
                                       ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="">Content</label>
                            <textarea name="content" id="" placeholder="Enter post content" cols="30" rows="10" class="form-control"><?php echo $result["content"] ?>
                            </textarea>
                        </div>
                        <div class="form-group">
                            <button type="submit" name="update_post" style="background-color:#10597d;"
                                class="btn btn-sm text-white my-2">
                                Update</button>
                        </div>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php  
//footer content
require './pages/footer-home.php'; ?>

</div>


<?php
 //footer script
  require "inc/footer.php";  ?>