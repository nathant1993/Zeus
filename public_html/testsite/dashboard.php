<?php
  //Make sure the user is logged in
  require_once('login_system/auth.php');
  require_once('config.php');
//Start the session
session_start();

//See if there is an id value passed across from the dropdown menu
if(isset($_GET["id"]))
{ 
    //Set access as false to begin with
    $access = FALSE;
    
     $conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE);
  // Check connection
  if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
  } 
   
   //Query to make sure that the user is member of a project
    $result = $conn->query("select a.project_id AS 'id', a.project_name AS 'name' from project a 
                inner join users_projects b where b.project_id = a.project_id and user_id =  '".$_SESSION['SESS_MEMBER_ID']."'");
    
    //Loop to check id values
    while ($row = $result->fetch_assoc()) {
            // unset($id, $name);
        if ($row["id"] === $_GET["id"]) 
        {
         
         //If the user is a member of a project that they have tried to access then store the id value in the session variable
         $access = TRUE; 
         $_SESSION["SESS_PROJ_ID"]=$_GET["id"];
            
        }         
    }
    //If the user is not a member of a project that they have tried to access then null the session variable and redirect them            
    if ($access == FALSE)
    {
        $_SESSION["SESS_PROJ_ID"]=$NULL;
        header('Location: ../testsite/dashboard.php');
    }
    
}
?>

<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Zeus Agile Project Management - The Dashboard</title>
<meta name="Description" content="Zeus Agile Project Management Dashboard - The dashboard is where you can see your project metrics. Burndown Graphs, Velocity Graphs and any add in's that you purchased">
<meta name="keywords" content="Zeus agile project management.">
<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

<link rel="shortcut icon" href="images/ico/favicon.ico">
<link rel="stylesheet" href="chartist-js-master/dist/chartist.min.css">
<link rel="stylesheet" href="chartist-js-master/site/styles/main.scss">
<link href='http://fonts.googleapis.com/css?family=Roboto:400,300' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="css/popupstyle.css">
<link rel="stylesheet" href="css/graphstyle.css"></link>
<link rel="stylesheet" href="css/signup.css"></link>	 
<link rel="stylesheet" href="css/dashboardStyle.css">

    
<!--<script src="js/scripts.js"></script></script>-->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<script src="js/uikit.scrollspy.js"></script>
<script src="js/scroll.js"></script>
<script src="js/ajax.js"></script>
<script src="js/velocity.js"></script>
<script src="js/velocity.ui.js"></script>
<script src="chartist-js-master/dist/chartist.min.js"></script>
<script src="js/chartistGraph.js"></script> 
<script src="js/pbiData.js"></script>
<!--<script src="./js/all.js"></script>  -->

<!-- Google Analytics code, need to add this to all pages!-->
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
  ga('create', 'UA-60923636-1', 'auto');
  ga('send', 'pageview');
</script>
</head>

<body>

  <div id="wrapper" class="fullwidth clearfix">
    
    <?php include("php/topnav.php") ?>
    
    <!--<div id="leftNav">
    	<p>Left Nav</p>
    </div>-->
    
    <div id="maincont">
 
      <!--<div id="contentTitle" class="fullwidth clearfix">
      	<p>Dashboard</p>
      </div>-->
      
      <div id ="content1" class="fullwidth clearfix">
      	<!--<p> content1 </p>-->
        <div class="graph-container">
          <p>Project Burndown</p>
          <div class="ct-chart ct-golden-section" id="chart1"></div> 
        </div> 
        <div class="graph-container">
          <p>Effort Done per Sprint</p>
          <div class="ct-chart ct-golden-section" id="chart2"></div> 
        </div>
      </div>
      
      <div id="content2" class="fullwidth clearfix">
      	<p> PBI's This Sprint</p> 
        <!--<ul class ="mylist"></ul>-->
        <div id="test">
          <table id="testtable" style="width:100%;">
            <tr>
              <th>ID</th>
              <th>PBI Title</th>
              <th>Description</th>
              <th>Effort</th>
              <th>Priority</th>
              <th>State</th>
            </tr>
          </table>
        </div>   
      </div>
      
    </div>
    
    
    <div id="greyOut">
    <!-- Popup Div Starts Here -->
      <div id="popupContact">
        <!-- Contact Us Form -->
        <form action="#" id="pbi_form" method="post" name="form">
          <!--<img id="close" src="images/ZeusLogo.jpg" style="width:10%;">-->
          <h2>Contact Us</h2>
          <input id="name" name="name" placeholder="Name" type="text">
          <input id="email" name="email" placeholder="Email" type="text">
          <textarea id="msg" name="message" placeholder="Message"></textarea>
          <a href="#" id="submit">Send</a>
          <a href="#" id="close">Cancel</a>
        </form>
      </div>
    <!-- Popup Div Ends Here -->
    </div>

    <div id="footer" class="fullwidth clearfix">
    	<p> footer</div>
    </div>
  
  </div>

</body>
</html>
