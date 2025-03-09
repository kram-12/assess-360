<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Faculty | Home</title>
    <style>
        
        @import url('https://fonts.googleapis.com/css?family=Work+Sans:400,600');
body {
	margin: 0;
	background: #fff;
	font-family: 'Work Sans', sans-serif;
	font-weight: 800;
}

button {
        width: 100px;
        height: 50px;
        font-family: 'Work Sans', sans-serif;
        font-size: 0.938em;
        outline: none;
        border: none;
        margin:10px;
        background-color: #12192C;
        color: #fff;
        border-radius: .5rem;
        cursor: pointer;
        transition: .3s;
}

.dash_button {
        width: 100px;
        height: 30px;
        font-family: 'Work Sans', sans-serif;
        font-size: 0.938em;
        outline: none;
        border: none;
        margin:10px;
        background-color: #55d6aa;
        color: #000;
        border-radius: .5rem;
        cursor: pointer;
        transition: .3s;
}

.container {
	width: 80%;
	margin: 0 auto;
}

header {
  background: #55d6aa;
}

header::after {
  content: '';
  display: table;
  clear: both;
}

.logo {
  float: left;
  padding: 10px 0;
}

nav {
  float: right;
}

nav ul {
  margin: 0;
  padding: 0;
  list-style: none;
}

nav li {
  display: inline-block;
  margin-left: 70px;
  padding-top: 35px;

  position: relative;
}

nav a {
  color: #444;
  text-decoration: none;
  text-transform: uppercase;
  font-size: 14px;
}

nav a:hover {
  color: #000;
  cursor: pointer;
}

nav a::before {
  content: '';
  display: block;
  height: 5px;
  background-color: #444;

  position: absolute;
  top: 0;
  width: 0%;

  transition: all ease-in-out 250ms;
}

nav a:hover::before {
  width: 100%;
}

table {
    width: 80%;
    border-collapse: collapse;
}
th, td {
    padding: 12px; 
    text-align: center;
    border: 1px solid #dddddd;
}
th {
    font-weight: bold;
}
.prof,#score{
        top: 3vw;
        position: fixed;
            width: 50vw !important;
            margin-left: 25vw !important;
            margin-right: 25vw !important;
            background-color: #fff !important;
            display: none !important;
            border-radius: 10px;
            margin-top: 2vw;
            z-index: 1;
            padding: 1vw;
            padding-left: 2vw;
            color: #042A38;
}
#delq,#addq,#viewq{
        width: 50vw;
        margin-left: 5vw;
        margin-right: 5vw;
        justify-content: center;
    }
</style>
</head>
<body>
    <header>
        <div class="container">
          <h2 class="logo">Assess 360°</h2>
          
          <nav>
            <ul>
                <li onclick="dash()"><a>Dashboard</a></li>
                <li onclick="prof()"><a>Profile</a></li>
                <li onclick="score()"><a>Quizzes</a></li>
                <li onclick="lo()"><a>Sign Out</a></li>
            </ul>
          </nav>
        </div>
    </header>
    <?php
session_start();
require_once 'sql.php';
                $conn = mysqli_connect($host, $user, $ps, $project);if (!$conn) {
    echo "<script>alert(\"Database Error! Retry after some time!\")</script>";
} else {
    $type1 = $_SESSION["type"];
    $email1 = $_SESSION["email"];
    $sql = "select * from profile_view where email='{$email1}'";
        $res =   mysqli_query($conn, $sql);
        if ($res == true) {
            global $dbmail, $dbpw;
            while ($row = mysqli_fetch_array($res)) {
                $dbmail = $row['email'];
                $dbname = $row['name'];
                $dbfaculty_id = $row['id'];
                $dbphno = $row['ph_no'];
                $dbgender = $row['gender'];
                $dbdob = $row['dob'];
                $dbdept = $row['dept'];
                $dbtype = $row['member_type'];
            }
        }
    if (isset($_POST['submit'])) {
        $qname = ($_POST['quiz_name']);
        $_SESSION["qname"]=$qname;
        $sql1 = "insert into quiz(quiz_name,email) values('$qname','$email1')";
        $res1 = mysqli_query($conn, $sql1);
        if ($res1 == true) {
            $sql = "select quiz_id from quiz where quiz_name='" . $qname . "';";
            $res = mysqli_query($conn, $sql);
            if ($res == true) {
                header("location: add_questions.php");
            } else {
                echo "<script>alert(\"Some error occured!\");</script>";
            }
        } else {
            echo "<script>alert(\"Name already exists!\");</script>";
        }
    }
    if (isset($_POST['submit1'])) {
        $qid1 = ($_POST['quiz_id']);
        $sql_temp = "SELECT * FROM quiz WHERE quiz_id = '$qid1' and email = '$dbmail' ";
        $result = $res=mysqli_query($conn,$sql_temp);
        if (!($result->num_rows > 0) ){
            echo "<script>alert(\"No quiz associated with the ID!\");</script>";
        } else {
        $sql1 = "delete from questions where quiz_id='{$qid1}'";
        $res1 = mysqli_query($conn, $sql1);
        $sql2 = "delete from quiz where quiz_id='{$qid1}'";
        $res2 = mysqli_query($conn, $sql2);
        if ($res1 == true && $res2 == true) {
            echo "<script>alert(\"Quiz successfully deleted!\");</script>";
        } else {
            echo "<script>alert(\"Unknown error occured during deletion of quiz!\");</script>";

        }
    }
    }
    if (isset($_POST['submit2'])) {
        $qid1 =$_POST['quiz_id'];
        $sql1 = "select quiz_id from quiz where quiz_id='{$qid1}'";
        $res1 = mysqli_query($conn, $sql1);
        if ($res1 == true) {
            echo "<script>window.location.replace(\"view_quiz.php?qid=".$qid1."\");</script>";
        } else {
            echo "<script>alert(\"Unknown error occured during viweing of quiz!\");</script>";

        }
    }
}
?>
    <br><br>
    <center><h1 style="font-size:2vw;">Welcome&nbsp;<?php echo $dbname ?><br><br>Dashboard</h1></center>
    <section>
    <center> <button onclick="addquiz()">Add Quiz</button><button onclick="delquiz()">Delete Quiz</button><button onclick="viewq()">View Quiz</button></center>
    </section>
    <br>
    <center>
        <fieldset id="addq" style="display:none;">
            <form style="width: 30vw" method="post">
                <h1>Add quiz</h1>
                <label for="quiz_name">Quiz Name:</label>
                <input type="text" name="quiz_name" placeholder="Enter Quiz Name" required><br><br>
                <input type="submit" name="submit" value="Submit" class="dash_button">
                  
            </form>
        </fieldset>  
    </center>
    <center>
            <fieldset id="delq" style="display:none;">
                <form style="margin: 1vw;width: 30vw" method="post">
                        <h1>Delete Quiz</h1>
                        <label for="quiz_id">Quiz Id:</label>
                        <input type="number" name="quiz_id" placeholder="Enter Quiz ID" required>&nbsp;<h7 onclick="score()" style="color: #000;text-decoration:underline">Get Quiz ID</h7><br><br>
                        <input type="submit" name="submit1" value="Submit" class="dash_button">
                    
                </form>
            </fieldset></center>
            <center>
            <fieldset id="viewq" style="display:none;">
                <form style="margin: 1vw;width: 30vw" method="post">
                    
                        <h1>View Quiz</h1>
                        <label for="quiz_id">Quiz Id:</label>
                        <input type="number" name="quiz_id" placeholder="Enter Quiz ID" required>&nbsp;<h7 onclick="score()" style="color: #000;text-decoration:underline">Get Quiz ID</h7><br><br>
                        <input type="submit" name="submit2" value="Submit" class="dash_button">
                    
                </form>
            </fieldset></center>

    <section class="prof" id="prof" style="display: none;">
    <fieldset>
    <center>
                <p><b>Type of User&nbsp;:&nbsp;<?php echo $dbtype ?></b></p>
                <p><b>Name&nbsp;:&nbsp;<?php echo $dbname ?></b></p>
                <p><b>Faculty ID&nbsp;:&nbsp;<?php echo $dbfaculty_id ?></b></p>
                <p><b>Department&nbsp;:&nbsp;<?php echo $dbdept ?></b></p>
                <p><b>e-Mail&nbsp;:&nbsp;<?php echo $dbmail ?></b></p>
                <p><b>Phone Number&nbsp;:&nbsp;<?php echo $dbphno ?></b></p>
                <p><b>Gender&nbsp;:&nbsp;<?php echo $dbgender ?></b></p>
                <p><b>Date of Birth&nbsp;:&nbsp;<?php echo $dbdob ?></b></p>
                
    </center>
    </fieldset>
    </section>
    <section id="score" style="display:none;">
    <fieldset>
    <?php 
            $sql ="select * from quiz_attempt_view where email='{$email1}'";
            $res=mysqli_query($conn,$sql);
            if($res)
            {
                echo "<center><h1>List of Quizes added by You</h1>";
                echo "<table id=\"sc\"><thead><tr><td>Quiz ID</td><td>Quiz Title</td><td>Created on</td><td>Attempts Count</td></tr></thead>";
                while ($row = mysqli_fetch_assoc($res)) {                
                    echo "<tr><td>".$row["quiz_id"]."</td><td>".$row["quiz_name"]."</td><td>".$row["date_created"]."</td><td>".$row["attempt_count"]."</td></tr>"; 
                }
                echo "</table></center><br><br>";
            }
            ?>
      </fieldset>
      </section>

      <section>
        <center>
            <?php
            $sql="select quiz_name,s.name,score,total_score from student s,faculty f,score sc,quiz q where q.quiz_id=sc.quiz_id and s.email=sc.email and q.email=f.email and q.email='{$email1}' ORDER BY score DESC";
            $res=mysqli_query($conn,$sql);
            if($res)
            {
                echo "<center><h1 style=\"font-size: 3vw\">Leaderboard</h1></center>";
                echo "<table id=\"le\"><thead><tr><td>Quiz Title</td>&nbsp;<td>Student Name</td><td>Score Obtained</td><td>Max Score</td></tr></thead>";
                while ($row = mysqli_fetch_assoc($res)) {                
                    echo "<tr><td>".$row["quiz_name"]."</td><td>".$row["name"]."</td><td>".$row["score"]."</td><td>".$row["total_score"]."</td></tr>"; 
                }
                echo "</table><br><br>";
            }
            else{
                echo mysqli_error($conn);
            }
            ?>
        </center>
      </section>
    </div>
    <?php require("footer.php");?>
</body>
<?php
echo '<script>' .
    "function prof(){" .
    "document.getElementById(\"prof\").style=\"display: block !important;\";" .
    "document.getElementById(\"score\").style=\"display: none !important;\";" .
    "}" .
    "function score(){" .
    "document.getElementById(\"prof\").style=\"display: none !important;\";" .
    "document.getElementById(\"score\").style=\"display: block !important;\";" .
    "}" .
    "function dash(){" .
    "document.getElementById(\"prof\").style=\"display: none !important;\";" .
    "document.getElementById(\"score\").style=\"display: none !important;\";" .
    "window.location.replace(\"faculty_home.php\");".
    "}" .
    "function lo(){" .
    "alert(\"Thank You for Using Assess 360°\");";
    //session_unset();
//session_destroy();
echo "window.location.replace(\"index.php\");" .
    "}" .
    "function addquiz(){" .
    "document.getElementById(\"addq\").style=\"display: initial;\";" .
    "document.getElementById(\"delq\").style=\"display: none;\";" .
    "document.getElementById(\"viewq\").style=\"display: none;\";" .

    "}" .
    "function delquiz(){" .
        "document.getElementById(\"delq\").style=\"display: initial;\";" .
        "document.getElementById(\"addq\").style=\"display: none;\";" .
        "document.getElementById(\"viewq\").style=\"display: none;\";" .
        "}" .
        "function viewq(){" .
            "document.getElementById(\"viewq\").style=\"display: initial;\";" .
            "document.getElementById(\"delq\").style=\"display: none;\";" .
            "document.getElementById(\"addq\").style=\"display: none;\";" .
            "}" .

    "</script>";
?>

</html>