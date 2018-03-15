<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/html">
<head>

    <meta charset="UTF-8">
    <title>Physio::Registration</title>

    <style>
        #frmRegister {
            padding: 20px 60px;
            background: #B6E0FF;
            color: #555;
            border-radius: 4px;
            margin: 0 auto;
            width: 300px;
        }
        select{
            padding: 8px;
            width: 100px;
        }
        fieldset {
            border: 0;
            background: lightcyan;
            border-radius: 4px;
            width: 200px;
        }
        .field-group {
            margin:15px 0px;
        }
        .input-field {
            width: 250px;
        }
        input {
            padding: 8px;
            border: #A3C3E7 2px solid;
            border-radius: 4px;
            display: inline;
        }
        .form-submit-button {
            background: #65C370;
            border: 0;
            padding: 8px 20px;
            border-radius: 4px;
            color: #FFF;
            text-transform: uppercase;
        }
        .form-cancel-button{
            background: #e7e7e7;
            border: 0;
            padding: 8px 20px;
            border-radius: 4px;
            color: black;
            text-transform: uppercase;
        }
        .error-message {
            text-align:center;
            color:#FF0000;
        }
        html * {
            font-size: 1em;
            color: #000;
            font-family: "Segoe UI";
        }
    </style>

</head>


<script>

    function showEmp() {
        document.getElementById("patient").disabled = true;
        document.getElementById("employee").disabled = false;
        document.getElementById("patient").style = "display: none";
        document.getElementById("employee").style = "display: block";
    }

    function showPat() {
        document.getElementById("employee").disabled = true;
        document.getElementById("patient").disabled = false;
        document.getElementById("employee").style = "display: none";
        document.getElementById("patient").style = "display: block";
    }

</script>


<?php

session_start();

include 'Functions.php';

$message="";

if (!empty($_POST["register"]) && $_POST["type"] == "employee") {
    $username = $_POST["username"];
    $password = $_POST["password"];
    $password2 = $_POST["password2"];
    $empID = $_POST["empID"];
    $fname = strtoupper($_POST["empName1"]);
    $lname = strtoupper($_POST["empName2"]);
    $type = $_POST["type"];

    $conn = connectDB();
    $query = "SELECT empID FROM employee WHERE empID=".$empID." and fname='".$fname."' and lname='".$lname."'";
    $result = $conn->query($query);

    if ($result) {
        $row = $result->fetch_assoc();
        $insert = "INSERT INTO account (username, password, authority_level, link_employee)
                VALUES ('" . $username . "', '" . $password . "', 1, " . $row['empID'] . ")";
        if ($conn->query($insert) == TRUE) {
            $_SESSION["username"] = $username;
            echo "<script>
                  alert('Register Successfully!');
                  window.location.href='Login.php';
                  </script>";
        } else {
            $message = "Error: " . $conn->error;
        }
    }
    else {
        $message = "Employee ID or name incorrect!";
    }
}

else if (!empty($_POST["register"]) && $_POST["type"] == "patient") {
    $username = $_POST["username"];
    $password = $_POST["password"];
    $password2 = $_POST["password2"];
    $pfname = strtoupper($_POST["name1"]);
    $plname = strtoupper($_POST["name2"]);
    $SIN = $_POST["SIN"];
    $gender = $_POST["gender"];
    $phone = $_POST["phone"];
    $email = $_POST["email"];
    $birthday = $_POST["birthday"];
    $street = $_POST["street"];
    $city = $_POST["city"];
    $province = $_POST["province"];
    $type = $_POST["type"];

    $conn = connectDB();

    $insert = "INSERT INTO patient (SIN, fname, lname, phone, email, gender, street_address, city, province, birthday)
          VALUES (".$SIN.", '".$pfname."','".$plname."', '".$phone."', '".$email."', '".$gender."', '".$street."', '"
          .$city."', '".$province."', '".$birthday."')";

    if ($conn->query($insert) == TRUE) {
        $result = mysqli_query($conn, "SELECT personal_health_no FROM patient WHERE SIN=".$SIN);
        $row = mysqli_fetch_array($result);
        $insert = "INSERT INTO account (username, password, link_patient, authority_level)
                VALUES ('".$username."', '".$password."', ".$row['personal_health_no'].", 1)";
        if ($conn->query($insert) == TRUE) {
            $_SESSION["username"] = $username;
            echo "<script>
                 alert('Register Successfully!');
                 window.location.href='Login.php';
                 </script>";
        }
        else {
            $message = "The username already exists!";
            mysqli_query($conn, "DELETE FROM patient WHERE SIN=".$SIN);
        }
    }
    else
        $message = "The SIN is already registered!";
}

?>


<body>
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);
            ?>" method="post" id="frmRegister">
        Registration:<br>
        (All fields are required)<br>
        <div class="error-message"><?php if(isset($message)) echo $message; ?></div>
        <br>

        <div class="field-group">
            <div><input name="username" type="text" class="input-field" align="right" placeholder="Username"
                        value="<?php if(isset($username)) echo $username; ?>" required autofocus> </div>
        </div>

        <div class="field-group">
            <div><input name="password" type="password" align="right" class="input-field" placeholder="Password" required></div>
        </div>

        <div class="field-group">
            <div><input name="password2" type="password" align="right" class="input-field" placeholder="Confirm Password" required></div>
        </div>

        <br>
        Register as:
        <br>

        <div class="field-group">
            <input type="radio" name="type" value="patient" onclick="showPat();" required> Patient
            <input type="radio" name="type" value="employee" onclick="showEmp();" required> Employee<br>
        </div>

        <fieldset class="field-group" id="employee" style="display: none" disabled="true">
            <br>
            <div>
                <input name="empName1" type="text" placeholder="First Name" size="14px" required
                       value="<?php if(isset($fname)) echo $fname?>">
                <input name="empName2" type="text" placeholder="Last Name" size="9px" required
                       value="<?php if(isset($lname)) echo $lname?>">
            </div><br>
            <div><input name="empID" type="text" class="input-field" placeholder="Employee ID" required
                        value="<?php if(isset($empID)) echo $empID; ?>"></div><br>
        </fieldset>


        <fieldset class="field-group" id="patient" style="display: none" disabled="true">
            <br>
            <div>
                <input name="name1" type="text" placeholder="First Name" size="14px" required value="<?php if(isset($pfname)) echo $pfname; ?>">
                <input name="name2" type="text" placeholder="Last Name" size="9px" required value="<?php if(isset($plname)) echo $plname; ?>">
            </div><br>
            <div><input name="SIN" type="text" class="input-field" placeholder="SIN (Social Insurance No.)" required></div><br>
            <div><label for="gender">Gender:</label>
                <input type="radio" name="gender" value="M" <?php if(isset($gender)) {if ($gender=="M") echo "checked"; else echo "";} else echo "checked"; ?> > Male
                <input type="radio" name="gender" value="F" <?php if(isset($gender)) {if ($gender=="F") echo "checked"; else echo "";} else echo ""; ?> > Female </div><br>
            <div><input name="phone" type="text" class="input-field" placeholder="Phone" required value="<?php if(isset($phone)) echo $phone; ?>"></div><br>
            <div><input name="email" type="text" class="input-field" placeholder="Email" required value="<?php if(isset($email)) echo $email; ?>"></div><br>
            <div><input name="birthday" type="text" onfocus="(this.type='date')" onblur="(this.type='text')" required
                       class="input-field" placeholder="Birthday" value="<?php if(isset($birthday)) echo $birthday; ?>"></div><br>
            <div><input name="street" type="text" class="input-field" placeholder="Street Address" required value="<?php if(isset($street)) echo $street; ?>"></div>
                <div><label></label>
                    <input name="city" type="text" class="input-field" placeholder="city" required value="<?php if(isset($city)) echo $city; ?>"></div>
                <div><label></label>
                    <select name="province" required>
                        <option value="" hidden selected>Province</option>
                        <option value="AB">AB</option>
                        <option value="BC">BC</option>
                        <option value="MB">MB</option>
                        <option value="NB">NB</option>
                        <option value="NL">NL</option>
                        <option value="NS">NS</option>
                        <option value="NT">NT</option>
                        <option value="NU">NU</option>
                        <option value="ON">ON</option>
                        <option value="PE">PE</option>
                        <option value="QC">QC</option>
                        <option value="SK">SK</option>
                        <option value="YT">YT</option>
                    </select></div><br>
        </fieldset><br>


        <div class="field-group">
            <div><input type="submit" name="register" value="Register" class="form-submit-button"></span> &emsp;&emsp;&emsp;&emsp;
                <input type="button" onclick="location.href='Login.php'"  value="Cancel" class="form-cancel-button">
                </span></div>
        </div>


    </form>
</body>

</html>
