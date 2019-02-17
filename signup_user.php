<?php
// signup_user.php
include "connect.php"; 
include "header.php"; 

echo '<h1>Sign up<h1>'; 
$request_method = strtoupper(getenv("REQUEST_METHOD")); 
$http_method = array("POST");

if (!in_array($request_method, $http_method)) {
    /* The form hasn't been posted yet, so display it.
     * action="" will cause the form to post to the same page
     * it is on. */ 
?>

    <form method="post" action="">
        Username: <input type="text" name="user_name" /><br />
        Password: <input type="password" name="user_password" ><br />
        Password again: <input type="password" name="user_pass_check" ><br />
        E-mail: <input type="email" name="user_email" ><br />
        <input type="submit" value="Submit" /><br />
    </form>

<?php
} else {
    /* The form has been posted, process the data in three steps: 
        1. Check the data. 
        2. Let the user refill any fields if necessary. 
        3. Save the data in the database. 
    */ 
    $errors = array(); // array of error strings to use later
   
    /*Still have to check that the username isn't taken. */ 
    if (isset($_POST["user_name"])) {
        // if username isn't alphanumeric then error maybe? 
        if (strlen($_POST["user_name"]) > 30) {
            $errors[] = "The username field must be shorter than 30 characters"; 
        } // else if(/*username table contains*/$_POST["user_name"]) {}
    } else /* the user_name field is empty ... */ {
        $errors[] = "The username field must not be empty."; 
    }
    
    /* Check that the two passwords match and they are under 
     * 30 characters. */
    if (isset($_POST["user_password"]) && ($_POST["user_password"]==$_POST["user_pass_check"])) {
        // Are user_password and user_pass_check equal? 
    } else {
        $errors[] = "Your passwords must match."; 
    }


     
    if (!empty($errors)) {
        /* If there are erros, iterate through the array and
         * output the errors to the user so they can fix them. */ 
        foreach ($errors as $key => $value)
            printf($value); 
    } else {
    /* The information is correct so post save it in the database. 
     * Use mysql_real_escape_string to avoid cross site scripting.
     * Hash the password with the bcrypt hashing function or sha1
     * hashing funciton. */ 
         /* escape user inputs to avoid cross site scripting attacks */  
    $esc_user_name = mysqli_real_escape_string($connection, $_POST["user_name"]); 
    $esc_user_password = mysqli_real_escape_string($connection, $_POST["user_password"]); 
    $esc_user_email = mysqli_real_escape_string($connection, $_POST["user_email"]); 
    
        
        $sql = "INSERT INTO 
        users(user_name, user_password, user_email, user_date, user_level,signed_in)
        VALUES('$esc_user_name',
        '".md5('$esc_user_password')."',
        '$esc_user_email',
                        NOW(),
                        0,0)";
        
        $result = mysqli_query($connection, $sql); 
        if(!$result) {
            printf("Error: %s\n",mysqli_error($connection)); 
            exit(); 
        } else 
            echo "Successfully registered, <a href='signin_user.php'>sign in</a>"; 
    }
}
?>

<?php include "footer.php"; ?>