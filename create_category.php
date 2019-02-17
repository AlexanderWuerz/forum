<?php
// create_category.php
include "connect.php"; 
include "header.php"; 
?>

<?php 
$request_method = strtoupper(getenv("REQUEST_METHOD")); 
$http_method = array("POST");


if (!isset($_SESSION["signed_in"])) {
?>
   
        <h1>You must <a href="signin_user.php">sign in</a> before you can create a category!</h1>
<?php 
} else {
if (!in_array($request_method, $http_method)) {
    /* The form hasn't been posted yet, so display it.
     * action="" will cause the form to post to the same page
     * it is on. */
?>
    <div id="content">

    <form method="post" action="">
        <table>
            <tr><td>Category name: </td><td><input type="text" name="cat_name"></td></tr><br />
        <tr><td>Category URL: </td><td><input type="text" name="cat_url"></td></tr><br />
        <tr><td>Category description: </td><td><textarea name="cat_description"></textarea></td></tr>
        <br />
        <tr><td></td><td><input type="submit" value = "Add category"></td></tr>
        <br />
        </table>
    </form>
</div>
<?php
} else {
    /* The form has been posted, so save it in the database. */ 
    
    $esc_cat_name = mysqli_real_escape_string($connection, $_POST["cat_name"]); 
    $esc_cat_description = mysqli_real_escape_string($connection, $_POST["cat_description"]);
    $esc_cat_url = mysqli_real_escape_string($connection, $_POST["cat_url"]); 
    
                                                     
    $sql = "INSERT INTO categories(cat_name, cat_description, cat_url)
        VALUES('$esc_cat_name', '$esc_cat_description', '$esc_cat_url')"; 
                            
    $result = mysqli_query($connection, $sql); 
                                                     
     if(!$result) {
        printf("Error: %s\n",mysqli_error($connection)); 
        exit(); 
    } else {
         //echo "You successfully added category: .$_POST['cat_name']."; 
         echo "You successfully created a category!"; 
     }
                                            
    }
}
?>
<?php
include "footer.php"; 
?>