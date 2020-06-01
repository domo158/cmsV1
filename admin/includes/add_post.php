<?php 

if(isset($_POST["create_post"])){
    $post_title = $_POST["title"];
    $post_cat_id = $_POST["post_category_id"];
    $post_author = $_POST["post_author"];
    $post_status = $_POST["post_status"];
    $post_tags = $_POST["post_tags"];
    $post_content = $_POST["post_content"];
    $post_date = date("d-m-y");
    $post_comment_count = 0;
    $post_image = $_FILES["image"]["name"];
    $post_image_temp = $_FILES["image"]["tmp_name"];
    // $_FILES => 

    if($post_author == ""){
        $_SESSION["message"] = ["danger" ,"Post Author can not be empty!"];
        return header("Location: posts.php?source=add_post");
    }

    move_uploaded_file($post_image_temp, "../images/$post_image");

    $query = "INSERT INTO posts (post_category, post_title, post_author, post_date, 
              post_image, post_content, post_tags, post_comment_count, post_status) ";
    $query.= "VALUES ($post_cat_id, '$post_title', '$post_author', now(), '$post_image', 
             '$post_content', '$post_tags', $post_comment_count, '$post_status')";
    
    $result = mysqli_query($connection, $query);

    // CONFIRM QUERY
    confirm($result, $connection);

    $post_id = mysqli_insert_id($connection);

    $_SESSION["message"] = ["success" ,"Post Created! <a href='../post.php?p_id=$post_id'>View Post</a>"];
    
}

if(isset($_SESSION["message"])){
    $message = $_SESSION["message"];
    echo "<div class='alert alert-$message[0]'>$message[1]</div>";
    unset($_SESSION["message"]);
}
?>

<form action="" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label for="title">Post Title</label>
        <input type="text" class="form-control" name="title">
    </div>
    <div class="form-group">
        <label for="post_category">Post Category</label>
        <select class="form-control" name="post_category_id" id="post_category_id">
        <?php 
            $query = "SELECT * FROM categories";
            $result = mysqli_query($connection, $query);
            confirm($query, $connection);

            while($row = mysqli_fetch_assoc($result)){
                $cat_id = $row["cat_id"];
                $cat_title = $row["cat_title"];

                echo "<option value='$cat_id'>$cat_title</option>";
            }
        ?>
        </select>
    </div>
    <div class="form-group">
        <?php 
            $query = "SELECT user_id, username FROM users ORDER BY username ASC";
            $result = mysqli_query($connection, $query);
        ?>
        <label for="post_author">Post Author</label>
        <select class="form-control" name="post_author" id="post_author">
            <option value="">Select Author</option>
        <?php 
            while($row = mysqli_fetch_assoc($result)){
                $user_id = $row["user_id"];
                $username = $row["username"];
                echo "<option value='$user_id'>$username</option>";
            }            
        ?>
        </select>
    </div>
    <div class="form-group">
        <label for="post_status">Post Status</label>
        <select class="form-control" name="post_status" id="post_status">
            <option value="draft">Draft</option>
            <option value="published">Published</option>
        </select>
    </div>
    <div class="form-group">
        <label for="post_image">Post Image</label>
        <input type="file" name="image">
    </div>
    <div class="form-group">
        <label for="post_tags">Post Tags</label>
        <input type="text" class="form-control" name="post_tags">
    </div>
    <div class="form-group">
        <label for="post_content">Post Content</label>
        <textarea name="post_content" class="form-control" cols="30" rows="10" id="body"></textarea>
    </div>
    <div class="form-group">
        <input type="submit" class="btn btn-primary" name="create_post" value="Publish">
    </div>
    
    
</form>