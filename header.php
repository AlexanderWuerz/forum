<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="nl" lang="nl">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>PHP-MySQL forum</title>
    <meta name="Web forum" content="This is a simple web forum." />
    <meta name="keywords" content="forum,web,put, keywords, here" />
   <!-- <title>PHP-MySQL forum</title> -->
    <link rel="stylesheet" href="forum_style.css" type="text/css">
        <script type="text/javascript" src="https://www.google.com/jsapi"></script>
 <script>
function showRSS(str) {
  if (str.length==0) { 
    document.getElementById("rssOutput").innerHTML="";
    return;
  }
  if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp=new XMLHttpRequest();
  } else {  // code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
  xmlhttp.onreadystatechange=function() {
    if (this.readyState==4 && this.status==200) {
      document.getElementById("rssOutput").innerHTML=this.responseText;
    }
  }
  xmlhttp.open("GET","getrss.php?q="+str,true);
  xmlhttp.send();
}
</script>
</head>
   <!-- <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script src="http://www.google.com/uds/solutions/dynamicfeed/gfdynamicfeedcontrol.js"
    type="text/javascript"></script>

    <style type="text/css">
    @import url("http://www.google.com/uds/solutions/dynamicfeed/gfdynamicfeedcontrol.css");

    #feedControl {
    margin-top : 10px;
    margin-left: auto;
    margin-right: auto;
    width : 440px;
    font-size: 12px;
    color: #9CADD0;
    }
    </style>
    <script type="text/javascript">
    function load() {
    var feed ="http://feeds.bbci.co.uk/news/world/rss.xml";
    new GFdynamicFeedControl(feed, "feedControl");

    }
    google.load("feeds", "1");
    google.setOnLoadCallback(load);
    </script> -->
<body>
    <div id="wrapper">
        <h1>PHP/MySQL forum</h1>
    <div id="menu">
        <a class="item" href="index.php">Home</a> -
        <a class="item" href="create_topic.php">Create a topic</a> -
        <a class="item" href="create_category.php">Create a category</a>
         
        <div id="userbar">
    <?php 
    session_start(); 
            
    if(isset($_SESSION["signed_in"]) && $_SESSION["signed_in"] == true) { 
      echo '<div id="userbar">Hello '.$_SESSION["user_name"].' Not you? <a href="signout_user.php">Log out.</a></div>';
     } else { 
        echo '<a href="signin_user.php">Sign in</a> or <a href="signup_user.php">Sign up!</a>';
        //echo '<a href="signout_user.php">Sign out.</a>'; 
     } ?>
    </div>
        <div>
