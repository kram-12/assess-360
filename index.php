<?php session_start();?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <?php
        if (isset($_POST['login'])) {
            if (isset($_POST['usertype']) && isset($_POST['email']) && isset($_POST['pass'])) {        
                require_once 'sql.php';
                $conn = mysqli_connect($host, $user, $ps, $project);if (!$conn) {
                    echo "<script>alert(\"Database Error! Retry after some time!\")</script>";
                }
                $type = mysqli_real_escape_string($conn, $_POST['usertype']);
                $email = mysqli_real_escape_string($conn, $_POST['email']);
                $password = mysqli_real_escape_string($conn, $_POST['pass']);
                $password = crypt($password, 'kalyanrampoonamalli');
                $sql = "select * from login_details where email='{$email}'";
                $res =   mysqli_query($conn, $sql);
                if ($res == true) {
                    global $dbmail, $dbpass;
                    while ($row = mysqli_fetch_array($res)) {
                        $dbpass = $row['pass'];
                        $dbmail = $row['email'];
                        $_SESSION["name"] = $row['name'];
                        $_SESSION["type"] = $type;
                        $_SESSION["email"] = $dbmail;
                    }
                    if ($dbpass === $password) {
                        if ($type === 'student') {
                            header("location:student_home.php");
                        } elseif ($type === 'faculty') {
                            header("Location:faculty_home.php");
                        }
                    } elseif ($dbpass !== $password && $dbmail === $email) {
                        echo "<script>alert('Incorrect Password');</script>";
                    } elseif ($dbpass !== $password && $dbmail !== $email) {
                        echo "<script>alert('E-mail Not Found In Database');</script>";
                    }
                }
            }
        }
        ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
        height: 100vh;
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
        font-size: var(--big-font-size);
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

      .form__div-one {
        margin-bottom: 3rem;
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
        width: 100%;
        padding: 1rem;
        font-family: var(--body-font);
        font-size: var(--normal-font-size);
        outline: none;
        border: none;
        margin-bottom: 3rem;
        background-color: var(--first-color);
        color: #fff;
        border-radius: .5rem;
        cursor: pointer;
        transition: .3s;
      }

      .form__button:hover {
        box-shadow: 0px 15px 36px rgba(0, 0, 0, .15);
      }

      /*=== Form social===*/
      .form__signup {
        text-align: center;
      }

      .form__signup-text {
        display: block;
        font-size: var(--normal-font-size);
        margin-bottom: 1rem;
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
    </style>
    <!-- ===== BOX ICONS ===== -->
    <link href='https://cdn.jsdelivr.net/npm/boxicons@2.0.5/css/boxicons.min.css' rel='stylesheet'>
    <title>Assess 360°</title>
  </head>
  <body>
    
    <div class="l-form">
      <div class="shape1"></div>
      <div class="shape2"></div>
      <center>
        <br>
        <h1 style="font-family: var(--body-font);">Assess 360°</h1>
      </center>
      <div class="form">
        <img src="images/login_img.jpg" alt="login_form_img" class="form__img">
        <form action="" class="form__content" method="POST">
          <h1 class="form__title">Welcome</h1>
          <div align="center">
            <input type="radio" id="student" name="usertype" value="student" checked>
            <label for="student">Student</label>
            <input type="radio" id="faculty" name="usertype" value="faculty">
            <label for="faculty">Faculty</label>
          </div>
          <br>
          <br>
          <div class="form__div form__div-one">
            <div class="form__icon">
              <i class='bx bx-user-circle'></i>
            </div>
            <div class="form__div-input">
              <label for="" class="form__label">e-mail</label>
              <input type="email" class="form__input" name="email" required>
            </div>
          </div>
          <div class="form__div">
            <div class="form__icon">
              <i class='bx bx-lock'></i>
            </div>
            <div class="form__div-input">
              <label for="" class="form__label">Password</label>
              <input type="password" class="form__input" name="pass" required>
            </div>
          </div>
          <a href="password_reset.php" class="form__forgot">Forgot Password?</a>
          <input type="submit" class="form__button" name ="login" value="Login">
          <div class="form__signup">
            <span class="form__signup-text">New User?</span>
            <button onclick="location.href='sign_up.php'" type="button" class="form__button">Sign Up</button>
          </div>
        </form>
      </div>
    </div>
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
    </script>
    <?php require("footer.php"); ?>
  </body>
</html>