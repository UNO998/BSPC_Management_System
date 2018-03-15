<?php

function connectDB() {
    $db = new mysqli("localhost", "root", "1234", "physio");
return $db;
}

function query2array($result) {
    $query = array();

    $tablename = array();
    while($name = $result->fetch_field()) {
        array_push($tablename, $name->name);
    }

    $tablename = removeDuplicateName($tablename);

    array_push($query, $tablename);

    while ($row = $result->fetch_assoc()) {
        $rowvalue = array();
        foreach($row as $field) {
            array_push($rowvalue, $field);
        }
        array_push($query, $rowvalue);
    }

    return $query;
}

function removeDuplicateName($name) {
    $temp = array();

    foreach ($name as $a) {
        $dupl = false;

        foreach($temp as $b) {
            if ($a == $b) {
                $dupl = true;
                break;
            }
        }

        if(!$dupl) array_push($temp, $a);
    }

    return $temp;
}

function contain($array, $name) {
    foreach ($array as $field) {
        if ($name == $field) return true;
    }
    return false;
}

?>