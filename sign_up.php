<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <?php
function validatePassword($password) {
  if (strlen($password) < 8) {
      return false;
  }
  if (!preg_match('/[A-Z]/', $password)) {
      return false;
  }
  if (!preg_match('/[a-z]/', $password)) {
      return false;
  }
  if (!preg_match('/[^\w]/', $password)) {
      return false;
  }
  if (!preg_match('/[0-9]/', $password)) {
      return false;
  }
  return true;
}

if (isset($_POST['studsu'])) {
    session_start();
    if (isset($_POST['name1']) && isset($_POST['reg1']) && isset($_POST['email1']) && isset($_POST['phno1']) && isset($_POST['dept1']) && isset($_POST['dob1']) && isset($_POST['gender1']) && isset($_POST['password1']) && isset($_POST['cpassword1'])) {
        require_once 'sql.php';
        $conn = mysqli_connect($host, $user, $ps, $project);       
        if (!$conn) {
            echo "<script>alert(\"Database Error! Retry after some time!\")</script>";
        }
        $name1 = mysqli_real_escape_string($conn, $_POST['name1']);
        $reg1 = mysqli_real_escape_string($conn, $_POST['reg1']);
        $email1 = mysqli_real_escape_string($conn, $_POST['email1']);
        $phno1 = mysqli_real_escape_string($conn, $_POST['phno1']);
        $dept1 = mysqli_real_escape_string($conn, $_POST['dept1']);
        $dob1 = mysqli_real_escape_string($conn, $_POST['dob1']);
        $gender1 = mysqli_real_escape_string($conn, $_POST['gender1']);
        $password1 = mysqli_real_escape_string($conn, $_POST['password1']);
        $cpassword1 = mysqli_real_escape_string($conn, $_POST['cpassword1']);
        if(!validatePassword($password1)){
          echo "<script>
                alert('Invalid Password!');
                window.location.replace(\"sign_up.php\");</script>";
            session_destroy();
        }
        $password1 = crypt($password1,'kalyanrampoonamalli');
        $cpassword1 = crypt($cpassword1,'kalyanrampoonamalli');
        if ($password1 == $cpassword1) {
            $sql = "insert into login_details(email,pass)values('$email1','$password1');";
            if (mysqli_query($conn, $sql)) {
                $sql2 = "insert into student (reg_no,name,email,ph_no,dept,gender,dob) values('$reg1','$name1','$email1','$phno1','$dept1','$gender1','$dob1')";
                if (mysqli_query($conn, $sql2)) {
                echo "<script>
                alert('Successfully Signed Up!');
                window.location.replace(\"index.php\");</script>";
                session_destroy();
                }
                else{
                  echo "<script>
                alert('Unknown Error, Try again Later!');
                window.location.replace(\"index.php\");</script>";
                session_destroy();
                }
            } else {
                echo "<script>
                alert('User details already exists in Database!');
                window.location.replace(\"index.php\");</script>";
                session_destroy();
            }
        } else {
            echo "<script>
                alert('Password not matched!');
                window.location.replace(\"sign_up.php\");</script>";
            session_destroy();
        }
    }
}

if (isset($_POST['facultysu'])) {
    session_start();
    if (isset($_POST['name2']) && isset($_POST['faculty_id']) && isset($_POST['mail2']) && isset($_POST['phno2']) && isset($_POST['dept2']) && isset($_POST['dob2']) && isset($_POST['gender2']) && isset($_POST['password2']) && isset($_POST['cpassword2'])) {
require 'sql.php';
        $conn = mysqli_connect($host, $user, $ps, $project);        
        if (!$conn) {
            echo "<script>alert(\"Database Error! Retry after some time!\")</script>";
        }
        $name2 = mysqli_real_escape_string($conn, $_POST['name2']);
        $usn2 = mysqli_real_escape_string($conn, $_POST['faculty_id']);
        $mail2 = mysqli_real_escape_string($conn, $_POST['mail2']);
        $phno2 = mysqli_real_escape_string($conn, $_POST['phno2']);
        $dept2 = mysqli_real_escape_string($conn, $_POST['dept2']);
        $dob2 = mysqli_real_escape_string($conn, $_POST['dob2']);
        $gender2 = mysqli_real_escape_string($conn, $_POST['gender2']);
        $password2 = mysqli_real_escape_string($conn, $_POST['password2']);
        $cpassword2 = mysqli_real_escape_string($conn, $_POST['cpassword2']);
        if(validatePassword($password2)){
          echo "<script>
                alert('Invalid Password!');
                window.location.replace(\"sign_up.php\");</script>";
            session_destroy();
        }
        $password2 = crypt($password2,'kalyanrampoonamalli');
        $cpassword2 = crypt( $cpassword2,'kalyanrampoonamalli');
        if ($password2 == $cpassword2 && validatePassword($password2)) {
            $sql = "insert into login_details(email,pass)values('$mail2','$password2');";
            if (mysqli_query($conn, $sql)) {
                $sql2 = "insert into faculty (faculty_id,name,email,ph_no,dept,gender,dob) values('$usn2','$name2','$mail2','$phno2','$dept2','$gender2','$dob2')";
                if (mysqli_query($conn, $sql2)) {
                echo "<script>
                alert('Successfully Signed Up!');
                window.location.replace(\"index.php\");</script>";
                session_destroy();
                }
                else{
                  echo "<script>
                alert('Unknown Error, Try again Later!');
                window.location.replace(\"index.php\");</script>";
                session_destroy();
                }
            } else {
                echo "<script>
                alert('User details already exists in database');
                window.location.replace(\"index.php\");</script>";
                session_destroy();
            }
        } else {
            echo "<script>
                alert('Password not matched!');
                window.location.replace(\"signup.php\");</script>";
            session_destroy();
        }
    }
}
?>

    <!-- ===== CSS ===== -->
    <style>
      /*===== GOOGLE FONTS =====*/
      @import url('https://fonts.googleapis.com/css?family=Work+Sans:400,600');

      /*===== VARIABLES CSS =====*/
      /*=== Colores ===*/
      :root {
        --first-color: #12192C;
        --text-color: #8590AD;
      }

      /*=== Fuente y tipografia ===*/
      :root {
        --body-font: 'Work Sans', sans-serif;
        --big-font-size: 2rem;
        --normal-font-size: 0.938rem;
        --smaller-font-size: 0.875rem;
      }

      @media screen and (min-width: 768px) {
        :root {
          --big-font-size: 2.5rem;
          --normal-font-size: 1rem;
        }
      }

      /*===== BASE =====*/
      *,
      ::before,
      ::after {
        box-sizing: border-box;
      }

      body {
        margin: 0;
        padding: 0;
        font-family: var(--body-font);
        color: var(--first-color);
      }

      h1 {
        margin: 0;
      }

      a {
        text-decoration: none;
      }

      img {
        max-width: 100%;
        height: auto;
      }

      /*===== FORM =====*/
      .l-form {
        position: relative;
        height: 100vh;
        overflow: hidden;
      }

      /*=== Shapes ===*/
      .shape1,
      .shape2 {
        position: absolute;
        width: 200px;
        height: 200px;
        border-radius: 50%;
      }

      .shape1 {
        top: -7rem;
        left: -3.5rem;
        background: linear-gradient(180deg, var(--first-color) 0%, rgba(196, 196, 196, 0) 100%);
      }

      .shape2 {
        bottom: -6rem;
        right: -5.5rem;
        background: linear-gradient(180deg, var(--first-color) 0%, rgba(196, 196, 196, 0) 100%);
        transform: rotate(180deg);
      }

      /*=== Form ===*/
      .form {
        height: 74vh;
        display: grid;
        justify-content: center;
        align-items: center;
        padding: 0 1rem;
      }

      .form__content {
        width: 290px;
      }

      .form__img {
        display: none;
      }

      .form__title {
        font-weight: 500;
        margin-bottom: 2rem;
      }

      .form__div {
        position: relative;
        display: grid;
        grid-template-columns: 7% 93%;
        margin-bottom: 1rem;
        padding: .25rem 0;
        border-bottom: 1px solid var(--text-color);
      }

      /*=== Div focus ===*/
      .form__div.focus {
        border-bottom: 1px solid var(--first-color);
      }

      .form__icon {
        font-size: 1.5rem;
        color: var(--text-color);
        transition: .3s;
      }

      /*=== Icon focus ===*/
      .form__div.focus .form__icon {
        color: var(--first-color);
      }

      .form__label {
        display: block;
        position: absolute;
        left: .75rem;
        top: .25rem;
        font-size: var(--normal-font-size);
        color: var(--text-color);
        transition: .3s;
      }
      .form__label_dept {
        display: block;
        position: absolute;
        left: 2rem;
        top: .1rem;
        font-size: var(--normal-font-size);
        color: var(--text-color);
      }

      /*=== Label focus ===*/
      .form__div.focus .form__label {
        top: -1.5rem;
        font-size: .875rem;
        color: var(--first-color);
      }

      .form__div-input {
        position: relative;
      }

      .form__input {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        border: none;
        outline: none;
        background: none;
        padding: .5rem .75rem;
        font-size: 1.2rem;
        color: var(--first-color);
        transition: .3s;
      }

      .form__forgot {
        display: block;
        text-align: right;
        margin-bottom: 2rem;
        font-size: var(--normal-font-size);
        color: var(--text-color);
        font-weight: 500;
        transition: .5;
      }

      .form__forgot:hover {
        color: var(--first-color);
        transition: .5s;
      }

      .form__button {
        width: 100px;
        padding: 1rem;
        font-family: var(--body-font);
        font-size: var(--normal-font-size);
        outline: none;
        border: none;
        margin:10px;
        background-color: var(--first-color);
        color: #fff;
        border-radius: .5rem;
        cursor: pointer;
        transition: .3s;
      }

      .cancel{
        font-size: var(--normal-font-size);
        color: var(--first-color);
        cursor: pointer;
      }

      .form__button:hover {
        box-shadow: 0px 15px 36px rgba(0, 0, 0, .15);
      }

      .form__social {
        text-align: center;
      }

      .form__social-text {
        display: block;
        font-size: var(--normal-font-size);
        margin-bottom: 1rem;
      }

      .form__social-icon {
        display: inline-flex;
        justify-content: center;
        align-items: center;
        width: 30px;
        height: 30px;
        margin-right: 1rem;
        padding: .5rem;
        background-color: var(--text-color);
        color: #fff;
        font-size: 1.25rem;
        border-radius: 50%;
      }

      .form__social-icon:hover {
        background-color: var(--first-color);
      }

      /*===== MEDIA QUERIS =====*/
      @media screen and (min-width: 968px) {
        .shape1 {
          width: 400px;
          height: 400px;
          top: -11rem;
          left: -6.5rem;
        }

        .shape2 {
          width: 300px;
          height: 300px;
          right: -6.5rem;
        }

        .form {
          grid-template-columns: 1.5fr 1fr;
          padding: 0 2rem;
        }

        .form__content {
          width: 320px;
        }

        .form__img {
          display: block;
          width: 700px;
          justify-self: center;
        }
      }

      .stud,
      .fac {
        display: none;
      }
      
    </style>
    <!-- ===== BOX ICONS ===== -->
    <link href='https://cdn.jsdelivr.net/npm/boxicons@2.0.5/css/boxicons.min.css' rel='stylesheet'>
    <title>Sign Up</title>
  </head>
  <body>
    
    <div class="l-form">
      <div class="shape1"></div>
      <div class="shape2"></div>
      <center>
        <br>
        <h1>Assess 360°</h1>
      </center>
      <br><br>
      <div>
        <center> <button class="form__button" onclick="stud()">Student</button><button class="form__button" onclick="staff()">Faculty</button></center>
      </div>
      <div class="stud" id="stud">
      <div class="form">
        <img src="images/login_img.jpg" alt="login_form_img" class="form__img">
        <form action="" class="form__content" method="POST" name="student">
          <h1 class="form__title">Sign Up as Student</h1>
          <div class="form__div">
            <div class="form__icon">
              <i class='bx bx-user-circle'></i>
            </div>
            <div class="form__div-input">
              <label for="name1" class="form__label">Name</label>
              <input type="text" class="form__input" name="name1" required>
            </div>
          </div>
          <br>
          <div class="form__div">
            <div class="form__icon">
              <i class='bx bx-user-pin'></i>
            </div>
            <div class="form__div-input">
              <label for="reg1" class="form__label">Registration Number</label>
              <input type="text" class="form__input" name="reg1" required>
            </div>
          </div>
          <br>
          <div class="form__div">
            <div class="form__icon">
              <i class='bx bx-mail-send'></i>
            </div>
            <div class="form__div-input">
              <label for="email1" class="form__label">e-Mail</label>
              <input type="email" class="form__input" name="email1" required>
            </div>
          </div>
          <br>
          <div class="form__div">
            <div class="form__icon">
              <i class='bx bx-phone'></i>
            </div>
            <div class="form__div-input">
              <label for="phno1" class="form__label">Phone Number</label>
              <input type="text" class="form__input" name="phno1" required>
            </div>
          </div>
          <br>
          <div class="form__div">
            <div class="form__icon">
              <i class='bx bx-book-bookmark' ></i>  
              <label for="dept1" class="form__label_dept" style="top: 0.4em;">Department</label>
              <select style="margin-left: 120px;" class="form__label" name="dept1" required>
                <option value="CSE">CSE</option>
                <option value="ECE">ECE</option>
                <option value="MECH">MECH</option>
                <option value="MGT">MGT</option>
              </select>
            </div>
          </div>
          <br>
          <div class="form__div">
            <div class="form__icon">
              <i class='bx bx-cake'></i>
              <input type="date" class="form__label" name="dob1" style="margin-left: 20px" required>
            </div>
          </div>
          <br>
          <div class="form__div">
            <div class="form__icon">
              <i class='bx bx-male'></i>
            </div>
            <div class="form__div-input" style="top: 0.1em;">
              <input type="radio" name="gender1" value="M" required ><label style="color: var(--text-color);" >Male</label>
              <input type="radio" name="gender1" value="F" required ><label style="color: var(--text-color);" >Female</label>
            </div>
          </div>
          <br>
          <div class="form__div">
            <div class="form__icon">
              <i class='bx bx-lock'></i>
            </div>
            <div class="form__div-input">
              <label for="password1" class="form__label">Password</label>
              <input type="password" class="form__input" name="password1" required>
            </div>
          </div>
          <br>
          <div class="form__div">
            <div class="form__icon">
              <i class='bx bx-lock'></i>
            </div>
            <div class="form__div-input">
              <label for="cpassword1" class="form__label">Confirm Password</label>
              <input type="password" class="form__input" name="cpassword1" required>
            </div>
          </div>
          <center>
          <input type="submit" class="form__button" name ="studsu" value="Sign Up">
          </center>
        </form>
      </div>
      </div>

      <div class="fac" id="fac">
        <div class="form">
        <img src="images/login_img.jpg" alt="login_form_img" class="form__img">
        <form action="" class="form__content" method="POST" name="faculty_su">
          <h1 class="form__title">Sign Up as Faculty</h1>
          <div class="form__div">
            <div class="form__icon">
              <i class='bx bx-user-circle'></i>
            </div>
            <div class="form__div-input">
              <label for="name2" class="form__label">Name</label>
              <input type="text" class="form__input" name="name2" required>
            </div>
          </div>
          <br>
          <div class="form__div">
            <div class="form__icon">
              <i class='bx bx-user-pin'></i>
            </div>
            <div class="form__div-input">
              <label for="faculty_id" class="form__label">Faculty ID</label>
              <input type="text" class="form__input" name="faculty_id" required>
            </div>
          </div>
          <br>
          <div class="form__div">
            <div class="form__icon">
              <i class='bx bx-mail-send'></i>
            </div>
            <div class="form__div-input">
              <label for="mail2" class="form__label">e-Mail</label>
              <input type="email" class="form__input" name="mail2" required>
            </div>
          </div>
          <br>
          <div class="form__div">
            <div class="form__icon">
              <i class='bx bx-phone'></i>
            </div>
            <div class="form__div-input">
              <label for="phno2" class="form__label">Phone Number</label>
              <input type="text" class="form__input" name="phno2" required>
            </div>
          </div>
          <br>
          <div class="form__div">
            <div class="form__icon">
              <i class='bx bx-book-bookmark' ></i>  
              <label for="dept2" class="form__label_dept" style="top: 0.4em;">Department</label>
              <select style="margin-left: 120px;" class="form__label" name="dept2" required>
                <option value="CSE">CSE</option>
                <option value="ECE">ECE</option>
                <option value="MECH">MECH</option>
                <option value="MGT">MGT</option>
              </select>
            </div>
          </div>
          <br>
          <div class="form__div">
            <div class="form__icon">
              <i class='bx bx-cake'></i>
              <input type="date" class="form__label" name="dob2" style="margin-left: 20px" required>
            </div>
          </div>
          <br>
          <div class="form__div">
            <div class="form__icon">
              <i class='bx bx-male'></i>
            </div>
            <div class="form__div-input" style="top: 0.1em;">
              <input type="radio" name="gender2" value="M" required ><label style="color: var(--text-color);" >Male</label>
              <input type="radio" name="gender2" value="F" required ><label style="color: var(--text-color);" >Female</label>
            </div>
          </div>
          <br>
          <div class="form__div">
            <div class="form__icon">
              <i class='bx bx-lock'></i>
            </div>
            <div class="form__div-input">
              <label for="password2" class="form__label">Password</label>
              <input type="password" class="form__input" name="password2" required>
            </div>
          </div>
          <br>
          <div class="form__div">
            <div class="form__icon">
              <i class='bx bx-lock'></i>
            </div>
            <div class="form__div-input">
              <label for="cpassword2" class="form__label">Confirm Password</label>
              <input type="password" class="form__input" name="cpassword2" required>
            </div>
          </div>
          <center>
          <input type="submit" class="form__button" name ="facultysu" value="Sign Up">
          </center>
        </form>
      </div>
      </div>
      <br>
      <center><u><a href="index.php" class="cancel">Cancel</a></u></center>
      </div>

    <?php require("footer.php");?>

    <!-- ===== MAIN JS ===== -->
    <script>
      /*===== FOCUS =====*/
      const inputs = document.querySelectorAll(".form__input")
      /*=== Add focus ===*/
      function addfocus() {
        let parent = this.parentNode.parentNode
        parent.classList.add("focus")
      }
      /*=== Remove focus ===*/
      function remfocus() {
        let parent = this.parentNode.parentNode
        if (this.value == "") {
          parent.classList.remove("focus")
        }
      }
      /*=== To call function===*/
      inputs.forEach(input => {
        input.addEventListener("focus", addfocus)
        input.addEventListener("blur", remfocus)
      })

      function stud() {
        document.getElementById('stud').style = "display:initial";
        document.getElementById('fac').style = "display:hidden";
      }

      function staff() {
        document.getElementById('stud').style = "display:hidden";
        document.getElementById('fac').style = "display:initial";
      }
    </script>
  </body>
</html>