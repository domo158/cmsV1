<?php 
    // FILL THE FORM WITH DATA FROM DB  
    if(isset($_GET["p_id"])){
        $post_id = $_GET["p_id"];

        $query = "SELECT * FROM posts JOIN users ON posts.post_author=users.user_id WHERE post_id=$post_id ";
        $result = mysqli_query($connection, $query);

        confirm($query, $connection);

        while($row = mysqli_fetch_assoc($result)){
            $post_category_id = $row["post_category"];
            $post_title = $row["post_title"];
            $post_author = $row["username"];
            $post_status = $row["post_status"];
            $post_image = $row["post_image"];
            $post_tags = $row["post_tags"];
            $post_content = $row["post_content"];
        }
    } else {
        header("Location: posts.php");
    }

    // UPDATE POST IN DB WITH NEW DATA FROM THE FORM
    if(isset($_POST["update_post"])){
        $post_author = $_POST["post_author"];
        $post_title = $_POST["post_title"];
        $post_category_id = $_POST["post_category_id"];
        $post_status = $_POST["post_status"];
        $post_image = $_FILES["post_image"]["name"];
        $post_image_temp = $_FILES["post_image"]["tmp_name"];
        $post_tags = $_POST["post_tags"];
        $post_content = $_POST["post_content"];

        //moving image from temporary location to permanent location
        move_uploaded_file($post_image_temp, "../images/$post_image");

        // CHECK IF FILE INPUT IS EMPTY, TAKE FROM THE OLD IMAGE FROM THE DB
        if(empty($post_image)){
            $query = "SELECT * FROM posts WHERE post_id=$post_id";
            $result = mysqli_query($connection, $query);
            confirm($result, $connection);
            while($row = mysqli_fetch_assoc($result)){
                $post_image = $row["post_image"];
            }
        }

        // get user_id to update post_author
        $query_user = "SELECT user_id FROM users WHERE username='$post_author'";
        $result_user = mysqli_query($connection, $query_user);
        $post_author = mysqli_fetch_row($result_user);
 
        $query_update = "UPDATE posts SET post_category_id={$post_category_id}, ";
                  $query_update .="post_title='{$post_title}', ";
                  $query_update .= "post_author='{$post_author}', ";
                  $query_update .="post_date='now()', ";
                  $query_update .="post_image='{$post_image}', ";
                  $query_update .="post_content='{$post_content}', ";
                  $query_update .= "post_tags='{$post_tags}', ";
                  $query_update .="post_status='{$post_status} "; 
                  $query_update .="WHERE post_id={$post_id}";

        $query_update = "UPDATE posts SET 
                         post_category='$post_category_id',
                         post_title='$post_title',
                         post_author='$post_author',
                         post_date=now(),
                         post_image='$post_image',
                         post_content='$post_content',
                         post_tags='$post_tags',
                         post_status='$post_status' 
                         WHERE post_id=$post_id";

        mysqli_query($connection, $query_update);

        
        confirm($query_update, $connection);

        $_SESSION["message"] = "Post Updated!";
    }
?>
<?php 
    if(isset($_SESSION["message"])){
        $message = $_SESSION["message"];
        
        echo "<div class='alert alert-success'>$message <a href='../post.php?p_id=$post_id'>View Post</a></div>
              
        ";
        unset($_SESSION["message"]);
    }
?>
<form action="" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label for="title">Post Title</label>
        <input type="text" class="form-control" name="post_title" value="<?php echo $post_title; ?>">
    </div>
    <div class="form-group">
        <label for="post_category">Post Category</label>
        <select name="post_category_id" id="post_category_id">
        <!-- DISPLAY CATEGORIES FROM THE DB INSIDE SELECT > OPTIONS -->
        <?php 
            $query = "SELECT * FROM categories";
            $result_cat = mysqli_query($connection, $query);

            confirm($query, $connection);
            while($row = mysqli_fetch_assoc($result_cat)){
                $cat_id = $row["cat_id"];
                $cat_title = $row["cat_title"];
                if($cat_id == $post_category_id){
                    echo "<option value='$cat_id' selected>$cat_title</option>";
                } else {
                    echo "<option value='$cat_id'>$cat_title</option>";
                }
            }
        ?>
        </select>
    </div>
    <div class="form-group">
        <label for="post_author">Post Author</label>
        <input type="text" class="form-control" name="post_author" value="<?php echo $post_author; ?>">
    </div>
    <div class="form-group">
        <label for="post_status">Post Status</label>
        <select name="post_status" id="post_status">
            <option value="<?php echo $post_status; ?>"><?php echo ucfirst($post_status); ?></option>
            <?php 
                if($post_status === "published"){
                    echo "<option value='draft'>Draft</option>";
                } else {
                    echo "<option value='published'>Published</option>";
                }
            ?>
        </select>
    </div>
    <div class="form-group">
        <label for="post_image">Post Image</label>
        <input type="file" name="post_image">
        <img width="200px" src="../images/<?php echo $post_image; ?>" alt="">
    </div>
    <div class="form-group">
        <label for="post_tags">Post Tags</label>
        <input type="text" class="form-control" name="post_tags" value="<?php echo $post_tags; ?>">
    </div>
    <div class="form-group">
        <label for="post_content">Post Content</label>
        <textarea name="post_content" class="form-control" cols="30" rows="30" id="body"><?php echo $post_content; ?></textarea>
    </div>
    <div class="form-group">
        <input type="submit" class="btn btn-primary" name="update_post" value="Update Post">
    </div>
    
    
</form>