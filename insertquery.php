<?php
include "config.php";

echo json_encode($_POST);
echo json_encode($_FILES);
extract(($_POST));
extract($_FILES);
$name = $_POST['name'];
$mobile = $_POST['mobile'];
$email = $_POST['email'];
$dob = $_POST['dob'];
$gender = $_POST['gender'];

/* Extension */
$extension = pathinfo($location,PATHINFO_EXTENSION);
$extension = strtolower($extension);
/* Allowed file extensions */
$allowed_extensions = array("jpg","jpeg","png");
$location = "uploads/".$filename;
if(!empty($_POST['name']) || !empty($_POST['mobile']) || !empty($_POST['email']) || !empty($_POST['dob']) || $_FILES['image'] || $_POST['gender'])
{
    $img = $_FILES['image']['name'];
    $tmp = $_FILES['image']['tmp_name'];
    $ext = strtolower(pathinfo($img, PATHINFO_EXTENSION));
    // can upload same image using rand function
    $final_image = rand(1000,1000000).$img;
    if(in_array($ext, $allowed_extensions))
    {  
        $path = $path.strtolower($final_image);
        if(move_uploaded_file($tmp,$path))
        {
            echo "<img src='$path' />";
            $name = $_POST['name'];
            $mobile = $_POST['mobile'];
            $email = $_POST['email'];
            $dob=date('Y-m-d', strtotime($_POST['date']));
            //$dob = $_POST['dob'];
            $gender = $_POST['gender'];
            $insertquery = $conn->query("INSERT INTO nametable (name, mobile, email, dob, image, gender) VALUES ('$name', '$mobile', '$email', '$dob', '$path', '$gender')");
        }
        else
        {
            printf("Image has not been moved\n");
        }
    }
    else
    {
        printf("invalid image extension\n");
    }
}
else
{
    printf("Something went wrong\n");
}

if($insertquery == TRUE)
{
    printf("Record submitted\n");
}
else
{
    printf("Submission failed\n");
}
