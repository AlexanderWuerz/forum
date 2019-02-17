<?php 
include "header.php"; 
include "connect.php"; 

    unset($_SESSION["signed_in"]); 

echo '<div id="content">';
    echo "You are not signed in, you can <a href='signin_user.php'>sign in</a> if you want."; 
echo '</div>';

?>

<?php include "footer.php"; ?>