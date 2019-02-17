<?php 
include "header.php"; 
include "connect.php"; 
?>


<form>
<select onchange="showRSS(this.value)">
<option value="">Select an RSS-feed:</option>
<option value="Google">Google News</option>
<option value="NBC">NBC News</option>
</select>
</form>
<div id="rssOutput">
    RSS-feed will be listed here...
</div>

<div id="content">
<!-- 
<a href="http://www.pngmart.com/files/1/Cat-PNG-Picture.png"><img src="http://www.pngmart.com/files/1/Cat-PNG-Picture.png"></a><br />
PNG doesn't load in Firefox 
<a href="https://media.giphy.com/media/EmMWgjxt6HqXC/giphy.gif"><img src="https://media.giphy.com/media/EmMWgjxt6HqXC/giphy.gif"></a><br /> -->
<?php
if (isset($_SESSION["signed_in"]) && $_SESSION["signed_in"] == false) {
    /*the user is not signed in */ 
    echo '<a href="signin_user.php">Sign in</a> or <a href="signup_user.php">Sign up!</a>';
    } else if (isset($_SESSION["signed_in"]) && $_SESSION["signed_in"] == true) {
    /* Display some categories and their topics. */ 
    $cat_sql = "SELECT 
                cat_id,
                cat_name,
                cat_description,
                cat_url
            FROM 
                categories"; 
 
   
    $cat_result = mysqli_query($connection, $cat_sql); 

    if(!$cat_result) {
        printf("Error: %s\n",mysqli_error($connection)); 
        exit(); 
    } else {
            /* Display the table of categories. */ 
?>
    <table border="1">
        <tr>
            <th>Category</th>
            <th>Topics</th>
       
        <?php  
	while($cat_rows = mysqli_fetch_array($cat_result, MYSQLI_ASSOC))
        {    
	/*$top_sql = "SELECT 
                    topic_id,
                    topic_subject,
                    topic_date,
                    topic_cat
                FROM 
                    topics";   
	*/
	
	$top_sql = "SELECT 
                    topic_id,
                    topic_subject,
                    topic_date,
                    topic_cat
                FROM 
                    topics";   
	
   	$top_result = mysqli_query($connection, $top_sql); 
       
            echo '<tr>';
                echo '<td class="cats">';
                        echo '<h1><a href="'.$cat_rows["cat_url"].'">'.$cat_rows["cat_name"].'</a></h1>'.$cat_rows["cat_description"].'';  
                echo '</td>';
                echo '<td class="tops">';
	 	while ($top_rows = mysqli_fetch_array($top_result,MYSQLI_ASSOC)) { 
			if ($top_rows["topic_cat"] == $cat_rows["cat_id"]) {
                            echo '<h2><a href="topic.php?id='.$top_rows["topic_id"].'">'.$top_rows["topic_subject"].'</a></h2>';
			}
		}
                echo '</td>';
            echo '</tr>'; 
        } /*
	 while ($cat_rows = mysqli_fetch_array($cat_result,MYSQLI_ASSOC)) { 
 	

	?>
            <tr>
                <td class="cats">
                    <?php
                    // echo '<h1><a href="category.php?cat_id">"'.$cat_rows["cat_name"].'"</a></h1>"'.$cat_rows["cat_description"].'"'; 
                        echo '<h1><a href="'.$cat_rows["cat_url"].'">'.$cat_rows["cat_name"].'</a></h1>'.$cat_rows["cat_description"].'';  
                   //echo '<h1>"'.$cat_rows["cat_url"].'"</h1>'; 
                   //echo '<h1><a href="https://en.wikipedia.org/wiki/Film">"'.$cat_rows["cat_name"].'"</a></h1>"'.$cat_rows["cat_description"].'"'; ?>
                </td>
                <td class="tops"> 
                    <?php //while ($top_rows["topic_cat"] == $cat_rows["cat_id"]) { 
                           // echo '<a href="topic.php?id=">Topic subject</a> at 10-10';
                                     //   echo '<h1>'.$cat_rows["cat_id"].'  '.$top_rows["topic_cat"].'</h1>'; 
                       // if ($top_rows["topic_cat"] == $cat_rows["cat_id"]) 
                            echo '<a href="topic.php?id=">Topic subject</a> at 10-10';
				// echo '<h2>'.$top_rows["topic_cat"].'</h2>';
                           // echo '<h2><a href="topic.php?id='.$top_rows["topic_id"].'">'.$top_rows["topic_subject"].'</a></h2>';//.$top_rows["topic_subject"].'';//.$top_rows["topic_date"].'"';
			 
			 
                 //   } // end inner while ?>
                </td>    
            </tr>
        <?php } // end outer while  ?>
    </table>
	<?php */ ?>
<?php 
        
    }
}
?>

</div>

<?php include "footer.php"; ?>
