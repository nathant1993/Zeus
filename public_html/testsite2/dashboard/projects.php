<?php
    //Make sure the user is logged in
    require_once('../login_system/auth.php');
    require_once('../php/config.php');
  
    //Start the session
    session_start();

    // //See if there is an id value passed across from the dropdown menu
    // if(isset($_GET["id"]))
    // { 
    //     //Set access as false to begin with
    //     $access = FALSE;
        
    //     $conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE);
    // // Check connection
    // if ($conn->connect_error) {
    //     die("Connection failed: " . $conn->connect_error);
    // } 
    
    // //Query to make sure that the user is member of a project
    //     $result = $conn->query("select a.project_id AS 'id', a.project_name AS 'name' from project a 
    //                 inner join users_projects b where b.project_id = a.project_id and user_id =  '".$_SESSION['SESS_MEMBER_ID']."'");
        
    //     //Loop to check id values
    //     while ($row = $result->fetch_assoc()) {
    //             // unset($id, $name);
    //         if ($row["id"] === $_GET["id"]) 
    //         {
            
    //         //If the user is a member of a project that they have tried to access then store the id value in the session variable
    //         $access = TRUE; 
    //         $_SESSION["SESS_PROJ_ID"]=$_GET["id"];
                
    //         }         
    //     }
    //     If the user is not a member of a project that they have tried to access then null the session variable and redirect them            
    //         if ($access == FALSE)
    //         {
    //             $_SESSION["SESS_PROJ_ID"]=$NULL;
    //             header('Location: ../testsite/dashboard.php');
    //         }
        
    //     }
?>

<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Zeus Agile Project Management - Your Backlog</title>
<meta name="Description" content="Backlog page search for, edit and create new product backlog items">
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

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<script src="../js/scroll.js"></script>
<script src="../js/ClickOnClass.js"></script>
<script src="../js/displayProjects.js"></script>
<script src="../js/velocity.js"></script>
<script src="../js/velocity.ui.js"></script>

<!-- Google Analytics code, need to add this to all pages!-->
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
      	<h1>Projects</h1>
      </div>
      <!-- Bar across the screen that holds four drop down menus to add filters to a search for PBI's-->
      <!--<div id="searchBar" class="fullwidth clearfix">
        <form id="projectSearch" method="post" action="../js/searchPBIs">

            <p>Choose a project:</p>
            <select id="projects">
              <option value="Any">Any</option>
            </select>
            
            <p>Choose a sprint:</p>
            <select id="sprints">
              <option value="Any">Any</option>
            </select> 
             
            <p>Choose a priority:</p>
            <select id="pbiPriority">
              <option value="Any">Any</option>
            </select>
            
            <p>Choose a state:</p>
            <select id="pbiState">
              <option value="Any">Any</option>
            </select>

          <button type="submit" id="pbiSearch" value="Update" class="formbutton">Update</button>
		    </form>
      </div>-->
     
     <div id ="content1" class="fullwidth clearfix">
      	<!--<p> content1 </p>-->
       
      </div>
      
      <div id="content2" class="fullwidth clearfix">
      	<div class="oneThirdWidth">
          <h1>Results</h1>
          <!--Table of results populated by searching for PBI's based on filters applied from the search bar above-->
          <div id="projectResultsDiv">
            <table id="projectResultstable" style="width:100%;">
              <tr>
                <th>Project Name</th>
              </tr>
            </table>
          </div>
      	</div>
        
        <!-- A div containing more in depth information about a selected PBI -->
        <div class = "twoThirdsWidth">
          <h1>User Details
          </h1>
          <!--<button id ="showCreatePBIForm" class="formbutton">+</button>
          <form id="pbiDetails" class="pbiDetailsForm" method="post" action="../js/updatePBIs">
            <label for="pbiID">ID</label>
            <input id = "pbiID" readonly required>
            
            <label for="pbiTitle">Title</label>
            <input id = "pbiTitle" title="PBI Title">
            
            <label for="pbiDescription">Description</label>
            <textarea id = "pbiDescription"></textarea>
            
            <label for="pbiEffort">Effort</label>
            <input id = "pbiEffort">  
            
            <label for="pbiDetailPriority">Priority</label>
            <select id="pbiDetailPriority">
            </select>
            
            <label for="pbiDetailState">State</label>
            <select id = "pbiDetailState">
            </select>
            
            <label for="pbiIteration">Iteration</label>
            <select id = "pbiIteration">
            </select>
            
            <label for="pbiProject">Project Name</label>
            <select id = "pbiProject">
            </select>
            
            <button type="submit" id="createPBI" value="Create" class="formbutton">Create</button>
            <button type="submit" id="pbiDetailsButton" value="Update" class="formbutton">Update</button>  
            <button type="button" id="deletePbiButton" value="Delete" class="formbutton">Delete</button>
            <button type="reset" id="pbiDetailsResetButton" value="Cancel" class="formbutton">Cancel</button> 
          </form>
          
          <div id="UpdateStatus" style="opacity:0;">
          </div>-->
          
        </div>
              
      </div>
      
    </div>
    
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
