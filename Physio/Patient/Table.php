<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <title>Physio::Admin Page</title>
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
        table {
            width: 100%;
            border-radius: 2px;
            border: 2px solid black;
            border-collapse: collapse;
        }
        tr.name {
            background-color: lightblue;
        }
        tr.even {
            background-color: white;
        }
        tr.odd{
            background-color: lightgray;
        }
        th, td {
            border: 1px solid darkgray;
            text-align: left;
            padding: 2px;
        }
        tr:hover {
            background-color: slategray;
        }
        .edit-button{
            background: #e7e7e7;
            border: 0;
            padding: 4px 10px;
            border-radius: 3px;
            color: black;
            text-transform: uppercase;
        }
        input {
            width = 10px;
            padding = 0px 0px;
        }
        i {
            border: solid cornflowerblue;
            display: inline-block;
            padding: 3px;
            float: right;
        }
        .up {
            border-width: 4px 0 0 4px;
            transform: rotate(45deg);
            -webkit-transform: rotate(45deg);
        }
        .down {
            border-width: 0 4px 4px 0;
            transform: rotate(45deg);
            -webkit-transform: rotate(45deg);
        }
    </style>


    <?php

    include '../Functions.php';
    session_start();

    if (!isset($_SESSION["level"]) || !isset($_SESSION["id"]) || $_SESSION["level"] < 3) {
        echo "<script> window.location.href='Login.php'; </script>";
    }

    $conn = connectDB();

    if (isset($_GET['sort'])) {
        $query = "SELECT * FROM patient ORDER BY ". $_GET['sort'] ." ". $_GET['order'];
    }
    else
        $query = "SELECT * FROM patient";

    $result = $conn->query($query);

    $table = query2array($result);

    echo "<table>";
    echo '<tr class="name">';
    foreach ($table[0] as $name) {
        echo '<td>' . htmlspecialchars($name) .
            '<i class="up" onclick="sort(\''. $name .'\', \'ASC\')"></i> <br>
            <i class="down" onclick="sort(\''. $name .'\', \'DESC\')"></i></td>';
    }
    echo '<td> </td>';
    echo '</tr>';


    $count = 0;
    for ($count = 1; $count < count($table); $count++) {
        if ($count % 2 == 0) echo '<tr class="even">';
        else echo '<tr class="odd">';

        foreach($table[$count] as $field) {
            echo '<td>'.htmlspecialchars($field) .'</td>';
        }
        echo '<td> <input type="button" value="Edit" class="edit-button" onclick="edit('. $count .')"> </td>';
        echo '</tr>';
    }
    echo "</table>";

    $_SESSION['table'] = $table;
    ?>



    <script>
        var $dialog

        function edit(row) {
            var url = "Update.php?row=" + row;

            $dialog = $('<div position="relative"></div>')
                .html('<iframe style="border: 0px; " src="' + url + '" overflow="visible" width="100%" height="100%"></iframe>')
                .dialog({
                    autoOpen: false,
                    modal: true,
                    height: 600,
                    width: 500,
                    title: "Edit Entry",
                    draggable: false,
                    closeOnEscape: false,
                });
            $dialog.dialog('open');
        }

        function closeDialog() {
            location.reload();
            $dialog.dialog("close");
            return false;
        }

        function sort(name, order) {
            var url = "Table.php?sort="+ name +"&order="+ order;
            window.location.href = url;
        }

    </script>

</head>

<body>



</body>


</html>