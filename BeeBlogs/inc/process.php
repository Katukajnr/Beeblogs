<?php

require "connection.php";


function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}


if(isset($_POST["register"])){

    $name = $_POST["name"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $encrypt_password = md5($password);

    //check if user exist
    $sql_check = "SELECT * FROM users WHERE email = '$email'";
    $query_check = mysqli_query($connection,$sql_check);
    if(mysqli_fetch_assoc($query_check)){
        //user exists
        $error = "User already exist";
    }else{
         //insert into DB
        $sql = "INSERT INTO users(name,email,password) VALUES('$name','$email','$encrypt_password')";
        $query = mysqli_query($connection,$sql) or die("Cant save data");
        $success = "Registration successfully";
    }  
}

if(isset($_POST["login"])){

    $email = $_POST["email"];
    $password = $_POST["password"];
    $encrypt_password = md5($password);

    //check if user exist
    $sql_check2 = "SELECT * FROM users WHERE email = '$email'";
    $query_check2 = mysqli_query($connection,$sql_check2);
    if(mysqli_fetch_assoc($query_check2)){
       //check if email and password exist
       $sql_check = "SELECT * FROM users WHERE email = '$email' AND password = '$encrypt_password'";
       $query_check = mysqli_query($connection,$sql_check);
       if($result = mysqli_fetch_assoc($query_check)){
       //Login to dashboard
       $_SESSION["user"] = $result;
       if($result["role"] == "user"){
           if(isset($_SESSION["url"])){
               $post_id = $_SESSION["url"];
               header("location: read-post.php?post_id=$post_id");
           }else{
               header("location: body.php");
           }
       }else{
        header("location: dashboard.php");
       } 
       $success = "User logged in";       
     }else{ 
    //user password wrong
    $error = "User password wrong";
}  
       }else{
        //user not found
        $error = "User email not found";
  } 
}

if(isset($_POST["category"])){
    $name = $_POST["name"];
    //sql
    $sql = "INSERT INTO category(name) VALUES('$name')";
    $query = mysqli_query($connection,$sql);
    
    if($query){
        $success = "Category added";
    }else{
        $error = "Unable to add category";
    }
}

if(isset($_GET["delete_category"]) && !empty($_GET["delete_category"])){
    $id = $_GET["delete_category"];
    //sql
    $sql = "DELETE FROM category WHERE id = '$id'";
    $query = mysqli_query($connection,$sql);

    if($query){
        $success = "Category deleted";
    }else{
        $error = "Unable to delete category";
    }

}

if(isset($_POST["edit_category"])){
    $name = $_POST["name"];
    $edit_id = $_GET["edit_id"];
    //sql
    $sql = "UPDATE category SET name = '$name' WHERE id = '$edit_id'";
    $query = mysqli_query($connection,$sql);
    if($query){
        $success = "Category updated";
    }else{
        $error = "Unable to update category";
    }

}

if(isset($_POST["new_post"])){
    //uploading to upload folder
    $target_dir = "uploads/";
    $basename = basename($_FILES["thumbnail"]["name"]);
    $upload_file = $target_dir.$basename;
    //move uploaded file
    $move = move_uploaded_file($_FILES["thumbnail"]["tmp_name"],$upload_file);
    if($move){
        $url = $upload_file;
        $title = $_POST["title"];
        $content = $_POST["content"];
        $status = $_POST["status"];
        $category_id = $_POST["category_id"];
        $thumbnail = $url;
        //sql
        $sql = "INSERT INTO posts(title,content,status,category_id,thumbnail) VALUES
                ('$title','$content','$status','$category_id','$thumbnail')";
        $query = mysqli_query($connection,$sql);
        if($query){
           //success message
            $success = "Post published";
        }else{
            $error = "Unable to publish post";
        }  
    }else{
        $error = "Unable to upload image";
    }
}

if(isset($_POST["update_post"])){
    $id = $_GET["edit_post_id"];
    if($_FILES["thumbnail"]["name"] != ""){
        //upload image
        $target_dir = "uploads/";
        $url = $target_dir.basename($_FILES["thumbnail"]["name"]);
        //move uploaded file
        if(move_uploaded_file($_FILES["thumbnail"]["tmp_name"],$url)){
            //update to database
             //parameters 
            $title = $_POST["title"];
            $content = $_POST["content"];
            $status = $_POST["status"];
            $category_id = $_POST["category_id"];
            $thumbnail = $url;    
            //sql
            $sql = "UPDATE posts SET title ='$title', content='$content', 
                    status='$status', category_id='$category_id', thumbnail='$thumbnail'
                    WHERE id='$id' ";
            $query = mysqli_query($connection,$sql);
            //check if
            if($query){
                $success = "Post updated";
            }else{
                $error = "Unable to update post";
            }
        }
    }else{
        //leave the upload image and
        //update to database
        //parameters 
        $title = $_POST["title"];
        $content = $_POST["content"];
        $status = $_POST["status"];
        $category_id = $_POST["category_id"];   
        //sql
        $sql = "UPDATE posts SET title ='$title', content='$content', 
            status='$status', category_id='$category_id'
            WHERE id='$id' ";
        $query = mysqli_query($connection,$sql);
        //check if
        if($query){
        $success = "Post updated";
        }else{
        $error = "Unable to update post";
        }

    }
}

if(isset($_GET["delete_post"]) && !empty($_GET["delete_post"])){
    $id = $_GET["delete_post"];
    //sql
    $sql = "DELETE FROM posts WHERE id = '$id'";
    $query = mysqli_query($connection,$sql);
    //check if
    if($query){
        $success = "Post deleted successfully";
    }else{
        $error = "Unable to delete post";
    }
}

if(isset($_POST["edit_user"])){
    //check if change password is click
    if(isset($_POST["change_password"]) && $_POST["change_password"] == "on"){
       //update the user with change_password
       $id = $_GET["edit_user_id"];
       $name = $_POST["name"];
       $email = $_POST["email"];
       $password = md5($_POST["password"]);  
       $role = $_POST["role"];
       //sql and query
       $sql = "UPDATE users SET name='$name', email='$email',
               password='$password', role='$role' WHERE id = '$id' ";
       $query = mysqli_query($connection,$sql);
       //check if
       if($query){
           $success = "User data updated";
       }else{
           $error = "Unable to update data";
       }

    }else{
        //update the data only
        $id = $_GET["edit_user_id"];
        $name = $_POST["name"];
        $email = $_POST["email"];
        $role = $_POST["role"];    
        //sql and query
        $sql = "UPDATE users SET name='$name', email='$email', role='$role'
                WHERE id = '$id' ";
        $query = mysqli_query($connection,$sql);
        //check if
        if($query){
            $success = "User data updated";
        }else{
            $error = "Unable to update data";
        }
    }
}

if(isset($_GET["delete_user"]) && !empty($_GET["delete_user"])){
    $id = $_GET["delete_user"];
    //sql
    $sql = "DELETE FROM users WHERE id = '$id'";
    $query = mysqli_query($connection,$sql);
    //check if
    if($query){
        $success = "User deleted successfully";
    }else{
        $error = "Unable to delete user";
    }
}

if(isset($_POST["new_user_admin"])){
    $name = $_POST["name"];
    $email = $_POST["email"];
    $role = $_POST["role"];
    $password = md5($_POST["password"]);
    
    //check if user already exist
    $sql_check = "SELECT * FROM users WHERE email = '$email'";
    $query_check = mysqli_query($connection,$sql_check);
    //check if
    if(mysqli_fetch_assoc($query_check)){
        //user already exist
        $error = "User already exist";
    }else{
        //user not found
        //add user
         //sql and query
        $sql = "INSERT INTO users (name,email,password,role)
        VALUES ('$name','$email','$password','$role')";
        $query = mysqli_query($connection,$sql);
        //check if
        if($query){
        $success = "New user added successfully";
        }else{
        $error = "Unable to add new user";
     }

  }

}

if(isset($_POST["comment_new"])){
    $comment = $_POST["comment"];
    $user_id = $_SESSION["user"]["id"];
    $post_id = $_GET["post_id"];
    
    if(empty($_POST["comment"])){
        $error = "Your comment is required!";
    }else{
        
        //sql & query
        $sql = "INSERT INTO comments(user_id,message,post_id) VALUES('$user_id','$comment','$post_id')";
        $query = mysqli_query($connection,$sql);
        //check if
        if($query){
            $success = "Comment added, waiting moderation";
        }else{
            $error = "Unable to add comment";
        }
    }
    
}

if(isset($_GET["approve_comment"]) && !empty($_GET["approve_comment"])){
    $comment_id = $_GET["approve_comment"];
    //sql query
    $sql = "UPDATE comments SET status = 1 WHERE id = '$comment_id'";
    $query = mysqli_query($connection,$sql);
    //check if
    if($query){
    $success = "Comment approved";
    }else{
    $error = "Unable to approved comment";
   }
}

if(isset($_GET["delete_comment"]) && !empty($_GET["delete_comment"])){
    $comment_id = $_GET["delete_comment"];
    //sql query
    $sql = "DELETE FROM comments WHERE id = '$comment_id'";
    $query = mysqli_query($connection,$sql);
    //check if
    if($query){
    $success = "Comment deleted";
    }else{
    $error = "Unable to delete comment";
   }
}



?>