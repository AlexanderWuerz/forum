<?php
// create_topic.php
/*
if (user is NOT signed in) {
    // Handle this here.
} else {
    // The user is signed in
    if (the form has not been posted) {
        // Show form and allow user to fill it in. 
    } else {
        // Process form and create category with description. 
    }
}
*/ 

include "header.php"; 
include "connect.php"; 

$request_method = strtoupper(getenv("REQUEST_METHOD")); 
$http_method = array("POST");

/* First, check if the user is already signed in. */ 
if (!isset($_SESSION["signed_in"])) {
?>
        <h1>You must <a href="signin_user.php">sign in</a> before you can create a topic!</h1>
<?php 
} else if (isset($_SESSION["signed_in"]) && $_SESSION["signed_in"] == true) {
    /* So, the user is signed in. */ 
    if (!in_array($request_method, $http_method)) {
        /* The form hasn't been posted and must be displayed.*/ 
        $cat_sql = "SELECT 
                        cat_id,
                        cat_name,
                        cat_description
                    FROM
                        categories"; 
        $cat_result = mysqli_query($connection, $cat_sql); 
        if(!$cat_result) {
            printf("Error: %s\n",mysqli_error($connection)); 
            exit(); 
        } else {
                /* Display the form to the user. */ 
           // $rows=mysqli_fetch_array($cat_result,MYSQLI_ASSOC);

?>
<div id="content">
    <form method="post" action="">
        <table>
            <tr><td><font color="black">Topic:</font></td><td><input type="text" name="topic_subject"></td></tr>
        
        <tr><td><font color="black">Category: </font></td><td>
        <select name="topic_cat">
            <?php while ($rows = mysqli_fetch_array($cat_result,MYSQLI_ASSOC)) {
                echo '<option value="'.$rows["cat_id"].'">'.$rows["cat_name"].'</option>';  
            }
            ?>
        </select></td></tr>
        <br />
        <tr><td><font color="black">Description: </font></td><td><textarea name="post_content"></textarea>
        <br />
        <input type="submit" value="Add topic"></td></tr>
        <br />
        </table>
    </form>
</div>
<?php
        }
    } else {
        /* Put users topic in the database. */ 
        $query  = "BEGIN WORK;";
        $result = mysqli_query($connection, $query);
         
        if(!$result)
        {
            echo 'An error occured while creating your topic. Please try again later.';
        }
        else
        {
     
            //the form has been posted, so save it
            //insert the topic into the topics table first, then we'll save the post into the posts table
            $sql = "INSERT INTO 
                        topics(topic_subject,
                               topic_date,
                               topic_cat,
                               topic_by)
                   VALUES('" . mysqli_real_escape_string($connection, $_POST['topic_subject']) . "',
                               NOW(),
                               " . mysqli_real_escape_string($connection, $_POST['topic_cat']) . ",
                               " . $_SESSION['user_id'] . "
                               )";
                      
            $result = mysqli_query($connection, $sql);
            if(!$result)
            {
                //something went wrong, display the error
                echo 'An error occured while inserting your data. Please try again later.' . mysql_error();
                $sql = "ROLLBACK;";
                $result = mysqli_query($connection, $sql);
            }
            else
            {
                //the first query worked, now start the second, posts query
                //retrieve the id of the freshly created topic for usage in the posts query
                $topicid = mysqli_insert_id($connection);
                 
                $sql = "INSERT INTO
                            posts(post_content,
                                  post_date,
                                  post_topic,
                                  post_by)
                        VALUES
                            ('" . mysqli_real_escape_string($connection, $_POST['post_content']) . "',
                                  NOW(),
                                  " . $topicid . ",
                                  " . $_SESSION['user_id'] . "
                            )";
                $result = mysqli_query($connection, $sql);
                 
                if(!$result)
                {
                    //something went wrong, display the error
                    echo 'An error occured while inserting your post. Please try again later.' . mysql_error();
                    $sql = "ROLLBACK;";
                    $result = mysqli_query($connection, $sql);
                }
                else
                {
                    $sql = "COMMIT;";
                    $result = mysqli_query($connection, $sql);
                     
                    //after a lot of work, the query succeeded!
                    echo '<div id="content">You have successfully created <a href="topic.php?id='. $topicid . '">your new topic</a>.</div>';
                }
            }
        }
    }
    
}
?>

<?php include "footer.php"; ?>