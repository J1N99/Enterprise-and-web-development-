<?php
if (isset($_POST['submit'])) {
    $department = $_POST['department'];
    require_once("dbConnection.inc.php");
    require_once("functions.inc.php");

    if (departmenttaken($conn, $department) !== false) {        
        header("location:../position/admin/department.php?error=departmenttaken");
        exit(); //stop
    }

    createdepartment($conn, $department);
}
