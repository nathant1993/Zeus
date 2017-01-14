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
            <h1>Zeus Dashboard</h1>
        </a>    
      </div>
      <div id="rightNav">
        <ul>
          <li>Projects
            <ul>
              <li>Zeus</li>
              <li>Project Atlas</li>
              <li>All Projects</li>
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
                <li>All Tasks</li>
              </ul>
          </li>
        </ul>
      </div>
        
    </div>
    
    <div id="maincont">
    
      <div id="contentTitle" class="fullwidth clearfix">
      	<h1>Sprints</h1>
      </div>
      
      <div id="content2" class="fullwidth clearfix">
      	<div class="oneThirdWidth">
          <!--Table of sprints populated on load-->
          <div id="sprintsDiv">
            <div id="currentSprints" class="SprintSelector">Current</div>
            <div id="previousSprints"class="SprintSelector">Previous</div>
            <div id="futureSprints"class="SprintSelector">Future</div>
            
            <table id="sprintsTable" style="width:100%;">
              <tr>
                <th>Sprint Number</th>
              </tr>
            </table>
          </div>
      	</div>
        
        <!-- A div containing more in depth information about a selected PBI -->
        <div class = "twoThirdsWidth">
          <h1>PBI Details</h1>
          
          <div id="board">
              <div id="PbiTitle" class="title">PBI
              </div><div id="ToDoTitle" class="title">To Do
              </div><div id="InProgTitle" class="title">In Progress
              </div><div id="DoneTitle" class="title">Done</div>
              
              <div class="KanbanRow">
                
                <div id="PBI" class="kanbanColumn">
                  
                    <div id="item0" class="Task">
                      <div class="cardTitle">
                          PBI example
                      </div>
                  </div>
                  
                </div><div id="todo" class="kanbanColumn">
                  
                  <div id="item1" class="Task" draggable="true">
                      <div class="cardTitle">
                          Learn HTML5
                      </div>
                  </div>
    
                  <div id="item2" class="Task"draggable="true">
                      <div class="cardTitle">
                          Learn CSS3
                      </div>
                  </div>
              </div><div id="inprogress" class="kanbanColumn">
                
              </div><div id="done" class="kanbanColumn">
              </div>
              
            </div>
            <!-- Closes KanbanRow -->
            
            <div class="KanbanRow">
                
                <div id="PBI" class="kanbanColumn">
                  
                    <div id="item0" class="Task">
                      <div class="cardTitle">
                          Second PBI example
                      </div>
                  </div>
                  
                </div><div id="todo" class="kanbanColumn">
                  
                  <div id="item3" class="Task" draggable="true">
                      <div class="cardTitle">
                          Make Kanban board
                      </div>
                  </div>
    
                  <div id="item4" class="Task"draggable="true">
                      <div class="cardTitle">
                          Fix bugs
                      </div>
                  </div>
              </div><div id="inprogress" class="kanbanColumn">
                
              </div><div id="done" class="kanbanColumn">
              </div>
              
            </div>
            <!-- Closes KanbanRow -->
            
            
            
            <!--<div id="PBI" class="kanbanColumn">
              <div class="title">PBI</div>
            </div><div id="todo" class="kanbanColumn">
              <div class="title">To Do</div>
              <div id="item1" class="Task" draggable="true">
                  <div class="cardTitle">
                      Learn HTML5
                  </div>
              </div>

              <div id="item2" class="Task"draggable="true">
                  <div class="cardTitle">
                      Learn CSS3
                  </div>
              </div>-->
              <!--<div id="item3" draggable="true">Make an amazing site</div>
              <div id="item4" draggable="true">Impress my friends</div>-->
            <!--</div><div id="inprogress" class="kanbanColumn">
              <div class="title">In Progress</div>
            </div><div id="done" class="kanbanColumn">
              <div class="title">Done</div>
            </div>-->
          
          <!--<div id="UpdateStatus" style="opacity:0;">
          </div>-->
          
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
      </div>
    <!-- Popup Div Ends Here -->
    
    <div id="footer" class="fullwidth clearfix">
    	<p> footer</div>
    </div>
  
  </div>

</body>
</html>
