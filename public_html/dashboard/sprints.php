<?php
	//require_once($_SERVER['DOCUMENT_ROOT'] . '/login_system/auth.php' );
  require_once('../login_system/auth.php');
?>

<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Zeus Agile Project Management - Your Sprints</title>
<meta name="Description" content="The Sprints page allows you to see and manage all your project's sprints">
<meta name="keywords" content="Zeus agile project management.">
<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

<link rel="shortcut icon" href="../images/ico/favicon.ico">
<link rel="stylesheet" href="../chartist-js-master/dist/chartist.min.css">
<link href='http://fonts.googleapis.com/css?family=Roboto:400,300' rel='stylesheet' type='text/css'>
<!--<link rel="stylesheet" href="../chartist-js-master/site/styles/main.scss">-->
<link rel="stylesheet" href="../css/popupstyle.css">
<link rel="stylesheet" href="../css/graphstyle.css"></link>
<!--<link rel="stylesheet" href="../css/signup.css"></link>	 -->
<link rel="stylesheet" href="../css/dashboardStyle.css">
<link rel="stylesheet" href="../css/kanbanStyle.css">

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<script src="../js/scroll.js"></script>
<script src="../js/ClickOnClass.js"></script>
<script src="../js/displaySprints.js"></script>
<script src="../js/createSprint.js"></script>
<script src="../js/KanBan.js"></script>
<script src="../js/velocity.js"></script>
<script src="../js/velocity.ui.js"></script>

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
        <a href ="../dashboard.php">  
          <span id="cloudicon"><img src="../images/full_white_logo.svg" alt="Zeus agile project management logo" ></span>
            <h1>Zeus</h1>
        </a>    
      </div>
      <div id="rightNav">
        <ul>
          <li>Projects
            <ul>
              <li>Zeus</li>
              <li>Project Atlas</li>
              <li><a href ="../dashboard/projects.php">All Projects</a></li>
            </ul>
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
                <li><a href ="../dashboard/tasks.php">All Tasks</a></li>
              </ul>
          </li>
        </ul>
      </div>
        
    </div>
    
    <div id="maincont">
    
      <div id="contentTitle" class="fullwidth clearfix">
      	<h1>Sprints</h1>
        <button id ="showCreatePBIForm" class="formbutton">+</button>
      </div>
      
      <div id="content2" class="fullwidth clearfix">
      	<div class="oneThirdWidth">
          <!--Table of sprints populated on load-->
          <div id="sprintsDiv">
            <div id="currentSprints" class="SprintSelector">Current</div>
            <div id="previousSprints"class="SprintSelector">Previous</div>
            <div id="futureSprints"class="SprintSelector">Future</div>
            <div style = "clear: both; max-height:71vh;">
            <table id="sprintsTable" style="width:100%;">
              <tr>
                <th>Sprint Number</th>
              </tr>
            </table>
            </div>
          </div>
      	</div>
        
        <!-- A div containing more in depth information about a selected PBI -->
        <div class = "twoThirdsWidth">
          <h1></h1><h3></h3><h2></h2>
          
          <div id="board">
              <div id="PbiTitle" class="title">PBI
              </div><div id="ToDoTitle" class="title">To Do
              </div><div id="InProgTitle" class="title">In Progress
              </div><div id="DoneTitle" class="title">Done</div>
          
          </div>
          <!-- Closes board -->
          
        </div>
        <!-- closes twoThirdsWidth -->  
            
      </div>
      <!--closes content2 -->
      
    </div>
    <!--closes maincont-->
    
    <div id="greyOut">
    </div>

    <!-- Popup Div Starts Here -->
      <div id="popupContact">
        
        <!--<div id="feedback"> 
          <img id="msgImg" src="../images/tick.svg" /> <h1 id="msgH1">Sprint was successfully created!</h1> <br> <a href="#" id="msgClose">OK</a>
        </div>-->
        
        <div id="popupFormContainer">
          <h1>Create Sprint</h1>
          <form id="SprintCreateForm" class="pbiDetailsForm" method="post" action="../js/updatePBIs">
            <div class="createSprintForm">
              <label for="sprintName">Title</label>
              <input id = "sprintName" title="sprintName">
            </div>
              
            <div class="createSprintForm">
              <label for="startDate">Start Date</label>
              <input id = "startDate" title="startDate" type="date">
            </div>
              
            <div class="createSprintForm">
              <label for="endDate">End Date</label>
              <input id = "endDate" title="endDate" type="date">
            </div>
          </form>
          
          <div class="createSprintForm">
            <a href="#" id="confirmButton">Yes</a> <a href="#" id="msgClose">No</a>
          </div>
        </div>   
      </div>
    <!-- Popup Div Ends Here -->
    
    <div id="footer" class="fullwidth clearfix">
    	<p> footer</div>
    </div>
  
  </div>

</body>
</html>
