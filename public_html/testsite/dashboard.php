<?php
	//require_once($_SERVER['DOCUMENT_ROOT'] . '/login_system/auth.php' );
  require_once('login_system/auth.php');
//   $project = 1;
//   require_once('project-access.php');
// session_start();
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
    
    <div id="topNav" class="fullwidth clearfix">
      <div id="leftNav">
    	<span id="cloudicon"><img src="images/full_white_logo.svg" alt="Zeus agile project management logo" ></span>
        <h1>Zeus Dashboard</h1>
      </div>
      <div id="rightNav">
        <ul>
          <li>Projects
            
              <!--<li>Zeus</li>
              <li>Project Atlas</li>
              <li>All Projects</li>-->
              <?php
                session_start();
                $conn = new mysqli('10.168.1.92', 'wearezeu_phpserv', '0!ZeusPhP!0', 'wearezeu_test01') 
                or die ('Cannot connect to db');
   
                $result = $conn->query("select a.project_id AS 'id', a.project_name AS 'name' from project a inner join users_projects b where b.project_id = a.project_id and user_id =  '".$_SESSION['SESS_MEMBER_ID']."'");
    
                echo "<ul>";

                while ($row = $result->fetch_assoc()) {
                    echo "<li>";
                        unset($id, $name);
                        $id = $row['id'];
                        $name = $row['name']; 
                        echo '<a href="../testsite/dashboard.php?id='.$id.'">'.$name.'</a>';
                    echo "</li>";              
            }

                echo "</ul>";
              ?>
            
          </li>  
          <li>Sprints
            <ul>
              <li>Zeus - Sprint 14</li>
              <li>Atlas - Sprint 5</li>
              <li><a href ="../dashboard/sprints.php">All Sprints</a></li>
            </ul>
          </li>  
          <li>Backlog
            <ul>
              <li>Zeus - PBI 112</li>
              <li>Atlas - PBI 74</li>
              <li><a href ="../dashboard/backlog.php">Product Backlog</a></li>
            </ul>
          </li>
          <li>Tasks
            <ul>
                <li>Atlas - Task 32</li>
                <li>Zeus - Task 8</li>
                <li>All Tasks</li>
              </ul>
          </li>
        </ul>
      </div>
        
    </div>
    
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
