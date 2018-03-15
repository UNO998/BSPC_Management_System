<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <title>Physio::Login</title>

    <style>
        #frmLogin {
            padding: 20px 60px;
            background: #B6E0FF;
            color: #555;
            border-radius: 4px;
            margin: 0 auto;
            width: 250px;
        }
        .frmLogin input {
            margin: 0 auto;
            width: 100px;
            align-self: center;
        }
        .field-group {
            margin:15px 0px;
        }
        .input-field {
            padding: 8px;width: 200px;
            border: #A3C3E7 2px solid;
            border-radius: 4px;
            left: 50px;
        }
        .form-submit-button {
            background: #65C370;
            border: 0;
            padding: 8px 20px;
            border-radius: 4px;
            color: #FFF;
            text-transform: uppercase;
        }
        .form-register-button{
            background: #008CBA;
            border: 0;
            padding: 8px 20px;
            border-radius: 4px;
            color: #FFF;
            text-transform: uppercase;
        }
        .member-dashboard {
            padding: 40px;
            background: #D2EDD5;
            color: #555;
            border-radius: 4px;
            display: inline-block;
            text-align:center;
        }
        .logout-button {
            color: #09F;
            text-decoration: none;
            background: none;
            border: none;
            padding: 0px;
            cursor: pointer;
        }
        .error-message {
            color:#FF0000;
        }
        .demo-content label{
            width:auto;
        }
        label.required {
            color: red;
        }
        html * {
            font-size: 1em;
            color: #000;
            font-family: "Segoe UI";
        }

    </style>

</head>


<?php

session_start();

include 'Functions.php';

$message="";
$username="";
if (isset($_SESSION["username"])) {
    $username = $_SESSION["username"];
    unset($_SESSION["username"]);
}

if (!empty($_POST["login"])) {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $conn = connectDB();
    $result = mysqli_query($conn, "SELECT * FROM account WHERE username='" . $_POST["username"] . "' and password = '" . $_POST["password"] . "'");
    $row = mysqli_fetch_array($result);

    if (is_array($row)) {
        $message = "Login";
        $_SESSION["level"] = $row['author ity_level'];

        if ($row['link_employee'] == null) {
            $_SESSION["id"] = $row['link_patient'];
        }
        else {
            $_SESSION["id"] = $row['link_employee'];
            if ($_SESSION["level"] == 3) {
                echo "<script> window.location.href='Admin.php'; </script>";
            }
        }
    } else {
        $message = "Username or Password Incorrect!";
    }
}
?>

<body>
    <form id="frmLogin" action = "<?php echo htmlspecialchars($_SERVER['PHP_SELF']);
    ?>" method = "post">
        <div>Welcome to Physio! Please Login.</div>
        <br>
        <div class="error-message" id="message"><?php if(isset($message)) echo $message; ?></div>
        <br>

        <div class="field-group">
            <div><input name="username" type="text" class="input-field" placeholder="Username" maxlength="30" required autofocus
                        value="<?php echo $username; ?>"></div>
        </div>

        <div class="field-group">
            <div><input name="password" type="password" class="input-field" placeholder="Password" required maxlength="30"> </div>
        </div>

        <div class="field-group">
            <div><input type="submit" name="login" value="Login" class="form-submit-button"></span> &emsp;
                 <input type="button" onclick="location.href='Register.php'"  value="Register" class="form-register-button"></span></div>
        </div>

    </form>

</body>

</html>
