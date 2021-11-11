<!DOCTYPE HTML>
<!--
/*
Author: Programmer Davis jsoftware7@gmail.com
Created: November 11 2021
Purpose: view site statistics
*/
-->
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>Guardsman University &dash; Statistics</title>
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css" />
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap-theme.min.css" />
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
		<link rel="stylesheet" href="https://cdn.datatables.net/1.10.2/css/jquery.dataTables.min.css"/>
		<script src="https://cdn.datatables.net/1.10.2/js/jquery.dataTables.min.js"></script>		
		
		<style>
			body{
				font-family: 'MuseoModerno', cursive !important;
			}
			.c-content{
				text-align:center;
			}
			.b-content{
				font-weight:bold;
			}
			a{
				text-decoration: underline;
			}
			section{
				margin:30px;
			}
			.t-padding{
				padding:10px;
			}
			.head-bg{
				color: white;				
				background-color: rgba(198,19,0);
			}
			.body-bg{
				background-color:#e3e3cc;
			}
			.w-back{
				background-color:white;
			}
			.foot-bg{
				color: white;				
				background-color: rgba(0,0,0);
			}
					
			
			.no-js #loader { 
				display: none;  
			}
			.js #loader { 
				display: block; position: absolute; left: 100px; top: 0;
			}
			.se-pre-con {
			  position: fixed;
			  left: 0px;
			  top: 0px;
			  width: 100%;
			  height: 100%;
			  z-index: 9999;
			  background: url(712.gif) center no-repeat #fff;
			}				
			hr{
				border:1px solid #000;
			}
			/*.remove-container{
				max-height:900px;
				overflow:scroll;
			}
			#progressBar{
				width:300px;
			}*/
			
			
			
			.r-size{
				width:100%; height:100%;  
				max-width:400px; max-height:400px;
			}
			
		</style>
	</head>
<?php
/*
Author: Programmer Davis jsoftware7@gmail.com
Created: September 10 2021
Purpose: connect to database using PDO
*/

class DatabaseUtils 
{
  // Database connection object
  private $pdo;
  // Create a PDO object and connect to the database
  public function __construct() {
    try {
 				
			

			$dbHost = "localhost";
			$dbUser = "";
			$dbPass = "";
			$dbName = "";
		
      // Instantiate the PDO object
      $this->pdo = new PDO(
        // Use MySQL database driver
        "mysql:dbname=$dbName;host=$dbHost", 
        $dbUser, 
        $dbPass, 
        // Set some options
        array(
          // Return rows found, not changed, during inserts/updates
          PDO::MYSQL_ATTR_FOUND_ROWS => true, 
          // Emulate prepares, in case the database doesn't support it
          PDO::ATTR_EMULATE_PREPARES => true,
          // Have errors get reported as exceptions, easier to catch
          PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
          // Return associative arrays, good for JSON encoding
          PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        )
      );
    }//end try 
    catch (PDOException $e) {
        die('Database Connection Failed: ' . $e->getMessage());
    }
  }//end function_construct
  // Perform a SELECT query
  //takes sql statement and values in an array called data[]
  public function select($sql, $data = array()) {
    try {
      // Prepare the SQL statement
      $stmt = $this->pdo->prepare($sql);
      // Execute the statement
      if ($stmt->execute($data)) {
        // Return the selected data as an assoc array
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
      }
      else {
        return $e->getMessage();
      }
    }//end try
    catch (Exception $e) {
      return $e->getMessage();
    }
  }//end fuction select
  
}//end class DatabaseUtils

//select records in table
function runSQL($db,$sql,$data) {
	$x=$db->select($sql,$data);
	return $x;
}

$db = new DatabaseUtils();

//escape database output
function escaper($string) {
	return htmlentities($string, ENT_QUOTES, "UTF-8");
}//ends function 

?>
	<body class="body-bg">
		<!-- gif conatiner for 712.gif used to show that page is loading -->
		<div class="se-pre-con"></div>
		
		<section>
			<div class="container-fluid">
				<div class="row w-back">
					<div class="col-md-12" >
						<img src="guardsmanuniversitylogoresize.jpg"/>
					</div>
				</div>
			</div>
		</section>
		
		<section>
			<div class="container-fluid">
				<div class="row head-bg">
					<div class="col-md-12 c-content" >
						<h1>Statistics</h1>
					</div>
				</div>
			</div>
		</section>

	<section>
		<div class="container-fluid">
			<div class="row w-back">
				<div class="col-md-12">
					<div class="dataTable_wrapper">
                    <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                        <thead>
                            <tr>
                                <th>Statistics</th>
                                                               
                            </tr>
                        </thead>
							<?php
							try {		
							  //create sql statement
							  //run sql statement
							  $sql = "SELECT COUNT(DISTINCT userid) AS total FROM mdl_course_completions";
							  $data = array();
							  $x = runSQL($db,$sql,$data);
							} catch(Exception $e) {
							  echo $sql . "<br>" . $e->getMessage();
							}
							//display table body with db information
							echo '<tbody>
									 '; foreach($x AS $f); echo'
										<tr class="t-padding">
											<td>									
												<br><span class="b-content">Number of students Completed at least one course: </span>
												<br>'.$f['total'].'
												<br>
											
												';  echo'
											
											</td>                                        
											
										</tr>
									 ';  echo' 
									
							</tbody> ';
							?>
                    </table>
                </div><!-- /datatable wrapper --> 
				</div> <!-- col-md-12 -->
			</div>
		</div> <!-- container-fluid -->
	</section>

	
		<section>
			<div class="container-fluid">
				<div class="row foot-bg">
					<div class="col-md-12 c-content" >
						 <span>All Rights Reserved &copy: Guardsman Group</span>						
						<span><br>Telephone: 1 (876) 978-5760</span> 
					</div>
				</div>
			</div>
		</section>

	<script>
		$(document).ready(function() {
				
				//used to show that page is loading
					$(window).load(function() {
						// Animate loader off screen
						$(".se-pre-con").fadeOut("slow");
					});
					
				//initiate datatable
				$('#dataTables-example').DataTable({
							responsive: true
				});
		});	
	</script>

	</body>
</html>