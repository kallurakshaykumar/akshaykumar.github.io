<?php
include "config.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Search</title>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">
  	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
</head>
<body>
<table class="table" id="tab2">
  <thead>
    <tr>
      <th scope="col">ID</th>
      <th scope="col">Image</th>
      <th scope="col">Name</th>
      <th scope="col">Mobile</th>
      <th scope="col">Email</th>
      <th scope="col">Date of Birth</th>
      <th scope="col">Gender</th>
    </tr>
  </thead>
  <?php 
  if(isset($_REQUEST["value"]))
  {
	  $search = $_REQUEST['value'];
	  $sql = "SELECT * FROM nametable WHERE id LIKE '%$search%' OR name LIKE '%$search%' OR mobile LIKE '%$search%' OR email LIKE '%$search%' OR dob LIKE '%$search%' OR gender LIKE '%$search%'";
	  $result = $conn->query($sql);
  }
if ($result->num_rows > 0) 
{
  while ($row = $result->fetch_assoc()) 
  {
    $image = '<img src="' . $row['image'] . '" class="img-thumbnail" width="75" height="100" />';
?>
	<tbody>
		<tr>
			<td><?= $row['id'] ?></td>
      <td><?= $image ?></td>
			<td><?= $row['name'] ?></td>
			<td><?= $row['mobile'] ?></td>
			<td><?= $row['email'] ?></td>
      <td><?= $row['dob'] ?></td>
      <td><?= $row['gender'] ?></td>
		</tr>
  </tbody>
<?php
  }
}
?>
</table>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
</body>
</html>