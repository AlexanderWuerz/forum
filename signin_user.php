<?php
// signin_user.php
include "connect.php"; 
include "header.php"; 

echo '<h1>Sign in<h1>'; 
$request_method = strtoupper(getenv("REQUEST_METHOD")); 
$http_method = array("POST");

/* First, check if the user is already signed in. */ 
if (isset($_SESSION["signed_in"]) && $_SESSION["signed_in"] == true) {
    echo "You are already signed in, you can <a href='signout_user.php'>sign out</a> if you want."; 
} else {
    /* User is not signed in so sign user in. */ 
    if (!in_array($request_method, $http_method)) {
?>

    <form method="post" action="">
        Username: <input type="text" name="user_name"><br />
        Password: <input type="password" name="user_password"><br />
        <input type="submit" value="Sign in"><br />
    </form>

<?php        
    } else {
        /* The form has been posted, process the data: 
            1. Check the data. 
            2. Let the user refill any fields if necessary. 
            3. Log the user in and return to the home page. 
        */
        $errors[] = array(); 
        
        /* Check if username and password fields are empty. */ 
        if (!isset($_POST["user_name"])) 
            $errors[] = "The username field must not be empty."; 
        if (!isset($_POST["user_password"]))
            $errors[] = "the password field must not be empty"; 
        
        /* Output errors from the array if there are any. 
        foreach ($errors as $key => $value)
            printf($value); 
            */ 
        
        /* Query the database for the user information, if it is 
         * not there then the wrong credentials were entered. */ 
        $esc_user_name = mysqli_real_escape_string($connection, $_POST["user_name"]); 
        $esc_user_password = mysqli_real_escape_string($connection, $_POST["user_password"]); 
        $hash_user_password = password_hash($esc_user_password, PASSWORD_DEFAULT);
        
        $sql = "SELECT 
                    user_id,
                    user_name,
                    user_level
                FROM 
                    users
                WHERE
                    user_name = '$esc_user_name'
                AND 
                    user_password = '".md5('$esc_user_password')."'";//.sha1('$esc_user_password')."'";
        $result = mysqli_query($connection, $sql); 
        if(!$result) {
            printf("Error: %s\n",mysqli_error($connection)); 
            exit(); 
        } else {
            /* Great success! The query was successfully executed. */ 
            /* Should check if query is empty. */ 
            
            $_SESSION["signed_in"] = true; 
                
            $rows=mysqli_fetch_array($result,MYSQLI_ASSOC);
            $_SESSION["user_id"] = $rows["user_id"];
            $_SESSION["user_name"] = $rows["user_name"];
            $_SESSION["user_level"] = $rows["user_level"]; 

            echo "Welcome, ".$_SESSION["user_name"].".<a href='index.php'>Click here to go to the forum main page!</a>"; 
            
        }
    }
} // end biggest if else 
?>

<?php include "footer.php"; ?>