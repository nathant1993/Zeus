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
                require_once('config.php');
                //Connection to the database
                  // Create connection
                $conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE);
                // Check connection
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                } 
                                
                //Query to return project id and name that the logged in user is a member of
                $result = $conn->query("select a.project_id AS 'id', a.project_name AS 'name' from project a 
                inner join users_projects b where b.project_id = a.project_id and user_id =  '".$_SESSION['SESS_MEMBER_ID']."'");
    
                echo "<ul>";
                
                //Loop to create a dropdown menu of the project names that the user is a member off
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