<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <title>Physio::Admin</title>

</head>
<style>
    html * {
        font-size: 1em;
        color: #000;
        font-family: "Segoe UI";
    }
    .container{
        width: 100%;
    }
    .dropbtn {
        border-radius: 4px;
        background-color: lightblue;
        color: black;
        padding: 20px 55px;
        font-size: 18px;
        border: none;
        cursor: pointer;
        width: 100%;
        height: 100%;
    }
    .dropdown {
        position: relative;
        display: inline-block;
    }
    .dropdown-content {
        display: none;
        position: absolute;
        background-color: lightgray;
        min-width: 200px;
        box-shadow: gray;
        border-radius: 3px;
    }
    .dropdown-content a {
        color: black;
        padding: 12px 16px;
        text-decoration: none;
        display: block;
    }
    .dropdown-content a:hover {
        background-color: gray;
        border-radius: 3px;
    }
    .dropdown:hover .dropdown-content {
        display: block;
    }
    .dropdown:hover .dropbtn {
        background-color: cornflowerblue;
    }
</style>

<?php
    include 'Functions.php';
    session_start();

    if (!isset($_SESSION["level"]) || !isset($_SESSION["id"]) || $_SESSION["level"] < 3) {
        echo "<script> window.location.href='Login.php'; </script>";
    }
?>

<script>

    function getTable(name) {
        if (name == "patient")
            document.getElementById('table').src = "Patient/Table.php";
        else
            document.getElementById('table').src = "Employee/Table.php?type=" + name;
    }

</script>


<body>

<div class="dropdown">
    <button class="dropbtn">Staff Details</button>
    <div class="dropdown-content">
        <a onclick="getTable('doctor')">Doctors</a>
        <a onclick="getTable('nurse')">Nurses</a>
        <a onclick="getTable('trainer')">Trainers</a>
        <a onclick="getTable('receptionist')">Receptionist</a>
        <a onclick="getTable('employee')">All employees</a>
    </div>
</div>

<div class="dropdown">
    <button class="dropbtn">Make Appointment</button>
    <div class="dropdown-content">
        <a>a</a>
    </div>
</div>

<div class="dropdown">
    <button class="dropbtn">Check Availability</button>
    <div class="dropdown-content">
        <a>a</a>
    </div>
</div>

<div class="dropdown">
    <button class="dropbtn">Patient Records</button>
    <div class="dropdown-content">
        <a onclick="getTable('patient')">All Patients</a>
    </div>
</div>
<br>
<br>
<br>
<br>
<br>

<div position="relative">
    <iframe src="" frameborder="0" id="table" scrolling="auto" overflow="visible" width="100%" height="800px" display="block"></iframe>
</div>

</body>

</html>
