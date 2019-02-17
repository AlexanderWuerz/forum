<?php
//create_cat.php
include 'connect.php';
include 'header.php';
?>

<div id="content">
<?php
$sql = "SELECT
    posts.post_topic,
    posts.post_content,
    posts.post_date,
    posts.post_by,
    users.user_id,
    users.user_name
FROM
    posts
LEFT JOIN
    users
ON
    posts.post_by = users.user_id
WHERE
    posts.post_topic = " . $_REQUEST['id'];//. mysqli_real_escape_string($connection, $_GET['id']);
    
    $result = mysqli_query($connection, $sql);
 
if(!$result)
{
    echo 'The topic could not be displayed, please try again later.' . mysql_error();
}
else
{
    echo '<table border="1">';
    while($rows = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            echo '<th>Post</th>';
            echo '<th></th>';

             echo '<tr>';
                echo '<td class="cats">';
                    echo $rows['post_content'];
                echo '</td>';
                echo '<td class="tops">';
                    echo 'Posted by '.$rows['user_name']; 
                    echo " at ".date('d-m-Y', strtotime($rows['post_date']));
                echo '</td>'; 
            echo '</tr>';
        
           
    }
    echo '</table>'; 
   // echo $rows['topic_id']; 
    echo '<form method="post" action="reply.php?id='.$_REQUEST['id'].'">';
    echo '<textarea name="reply-content"></textarea>';
    echo '<input type="submit" value="Submit reply" />
    </form>'; 
    
}
?>
</div>
<?php include 'footer.php'; ?>