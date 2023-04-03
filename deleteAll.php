<?php
include "config.php";

if(isset($_POST["checkbox_value"]))
{
    for($i = 0; $i<count($_POST['checkbox_value']); $i++)
    {
        $d = "DELETE FROM nametable WHERE id = '".$_POST['checkbox_value'][$i]."'";
        $stmt = $conn->query($d);
        
    }
}
else
{
    echo "Checkbox_value not set";
}
?>