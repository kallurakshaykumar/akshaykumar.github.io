<?php
include "config.php";
if(isset($_POST['action']))
{
    if($_POST['action'] == "delete")
    {
        $id = $_POST['id'];
        $delquery = $conn->query("DELETE FROM nametable WHERE id=$id");
        header('Location: index.php');
    }
}
else
{
    echo "Cannot delete the record";
}
?>