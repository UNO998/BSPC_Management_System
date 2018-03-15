<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <title></title>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
    <script src="http://ajax.aspnetcdn.com/ajax/jquery.ui/1.8.9/jquery-ui.js" type="text/javascript"></script>
    <link href="http://ajax.aspnetcdn.com/ajax/jquery.ui/1.8.9/themes/blitzer/jquery-ui.css"
          rel="stylesheet" type="text/css" />

    <style>
        html * {
            font-size: 1em;
            color: #000;
            font-family: "Segoe UI";
        }
        select{
            padding: 8px;
            width: 100px;
        }
        .input-field {
            padding: 8px;width: 200px;
            border: #A3C3E7 2px solid;
            border-radius: 4px;
            left: 50px;
            display: inline;
        }
        .submit-button {
            background: #65C370;
            border: 0;
            padding: 8px 20px;
            border-radius: 4px;
            color: #FFF;
            text-transform: uppercase;
        }
        .cancel-button{
            background: #e7e7e7;
            border: 0;
            padding: 8px 20px;
            border-radius: 4px;
            color: black;
            text-transform: uppercase;
        }
        table {
            width: 100%;
            border-radius: 2px;
            border-collapse: collapse;
        }
        tr.even {
            background-color: white;
        }
        tr.odd{
            background-color: lightgray;
        }
        th, td {
            border-radius: 3px;
            width: 100%;
            text-align: left;
            padding: 2px;
        }
        tr:hover {
            background-color: slategray;
        }

    </style>


    <?php

    include '../Functions.php';
    session_start();

    if (!isset($_SESSION["level"]) || !isset($_SESSION["id"]) || $_SESSION["level"] < 3) {
        echo "<script> window.location.href='Login.php'; </script>";
    }

    if (isset($_GET['row'])) {
        $row = $_GET['row'];
        $_SESSION['row'] = $row;
        $table = $_SESSION['table'];

        echo "<form action='Update.php' method='post'><table>";

        $display = 0;
        for ($i = 0; $i < count($table[0]); $i++) {
            $name = $table[0][$i];
            $value = $table[$row][$i];

            if ($name == "empID" || $name == "entry_date" || $name == "type")
                echo '<input name="' . $name . '" type="hidden" class="input-field" value="' . $value . '">';
            else {
                if ($display%2 == 0) echo '<tr class="even">';
                else echo '<tr class="odd">';

                echo '<td>' . $name . '</td>';

                if ($name == "gender") {
                    if ($value == "M")
                        echo '<td><input type="radio" name="gender" value="M" checked> Male
                           <input type="radio" name="gender" value="F"> Female </td>';
                    else
                        echo '<td><input type="radio" name="gender" value="M"> Male
                           <input type="radio" name="gender" value="F" checked> Female </td>';
                }
                else if ($name == "province") {
                    $province = array("AB", "BC", "MB", "NB", "NL", "NS", "NT", "NU", "ON", "PE", "QC", "SK", "YT");
                    echo '<td><select name="province">';
                    foreach ($province as $p) {
                        if ($value == $p) echo '<option selected value="' . $p . '">' . $p . '</option>';
                        else echo '<option value="' . $p . '">' . $p . '</option>';
                    }
                    echo '</select></td>';
                }
                else if ($name == "birthday") {
                    echo '<td><input name="' . $name . '" type="date" class="input-field" value="' . $value . '"></td>';
                }
                else
                    echo '<td><input name="' . $name . '" type="text" class="input-field" value="' . $value . '"></td>';
                echo '</tr>';
                $display++;
            }
        }

        echo '<input type="submit" class="submit-button" value="Update" name="submit"></table></form>';
    }


    else if (isset($_POST['submit'])) {
        $conn = connectDB();
        $table = $_SESSION['table'];
        $row = $_SESSION['row'];
        $type = $_POST['type'];
        $ID = $_POST['empID'];

        $result = $conn->query("SELECT * FROM employee WHERE empID=". $ID);
        $fields = query2array($result);
        $fields = $fields[0];

        $index = 0;
        foreach ($table[0] as $name) {
            if ($table[$row][$index] != $_POST[$name]) {
                if (contain($fields, $name)) $query = "UPDATE employee SET ". $name ."='". $_POST[$name] ."' WHERE empID=". $ID;
                else $query = "UPDATE ". $type ." SET ". $name ."='". $_POST[$name] ."' WHERE empID=". $ID;
                $update = $conn->query($query);
            }
            $index ++;
        }

        echo "<script>window.parent.closeDialog();</script>";
    }

    ?>


</head>

<body>

</body>


</html>