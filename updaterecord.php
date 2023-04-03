<?php
include "config.php";
if(isset($_POST['updateid']))
{
    $user_id = $_POST['updateid'];
    $selquery = $conn->query("SELECT * FROM `nametable` WHERE `id`='$user_id'");
    if($selquery->num_rows>0)
    {
        $response = array();
        while($row=$selquery->fetch_assoc())
        {
            $response = $row;
        }
        echo json_encode($response);
    }
    else
    {
        echo "Some Error!";
    }
}

if(isset($_POST['hiddendata']))
{
    $uid = $_POST['hiddendata'];
    $name = $_POST['updatename'];
    $mobile = $_POST['updatemobile'];
    $email = $_POST['updateemail'];
    $dob = $_POST['updatedob'];
    $update = $conn->query("UPDATE `nametable` SET `name`='$name', `mobile`='$mobile', `email`='$email', `dob`='$dob' WHERE id='$uid'");
    if($update == TRUE)
    {
        echo "Record updated";
    }
    else
    {
        echo "Record is not updated. Try again";
    }
}
?>