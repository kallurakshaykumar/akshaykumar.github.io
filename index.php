<?php
include "config.php";

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>View Records</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

  <style>
    #createbutton {
      float: right;

    }

    #viewrecord:hover {
      text-decoration: none !important;
    }

    .deleteAll {
      float: right;
    }

    input[type=text],
    input[type=number],
    input[type=email],
    input[type=file],
    input[type=date] {
      padding: 10px;
      border: 1px solid lightgrey;
      box-shadow: 0 0 15px 4px rgba(0, 0, 0, 0.04);
    }

    .add {
      background-color: #ebedec;
    }

    .search {
      width: 300px;
    }

    .deleteAll {
      margin-top: 0px;
      margin-right: 20px;
    }

    #datepicker {
      width: 60%;
    }
  </style>
</head>

<body>
  <!--SEARCH-->
  <div class="container my-3">
    <div class="form-group">
      <div class="input-group">
        <form action="search.php" method="POST">
          <input type="text" name="search" id="search" placeholder="Search" class="form-control search" />
        </form>
      </div>
    </div>
    <div id="result"></div>
    <button type="button" class="btn btn-outline-info" data-toggle="modal" data-target="#exampleModal" id="createbutton">New record</button>

    <!-- INSERT Modal -->
    <div class="modal fade my-5" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header add">
            <h5 class="modal-title" id="exampleModalLabel">Add</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form method="post" action="" id="input_form">

              <div class="row">
                <div class="col">
                  <div class="form-group">
                    <label for="name" class="col-sm-2 col-form-label">Name</label>
                    <input type="text" name="name" id="name" placeholder="Name" class="form-control" required>
                  </div>
                </div>
                <div class="col">
                  <div class="form-group">
                    <label for="number" class="col-sm-2 col-form-label">Mobile</label>
                    <input type="number" name="mobile" id="mobile" placeholder="Mobile" class="form-control" required>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col">
                  <div class="form-group">
                    <label for="email" class="col-sm-2 col-form-label">Email</label>
                    <input type="email" name="email" id="email" placeholder="Email" class="form-control" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" title="Enter valid email address" required>
                  </div>
                </div>
                <div class="col">
                  <div class="form-group">
                    <label for="email" class="col-sm-2 col-form-label">Image</label>
                    <input id="uploadImage" type="file" accept="image/*" class="form-control" name="image" height="75px" width="50px" />
                    <div id="preview"><img src="" /></div><br>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col">
                  <div class="form-group">
                    <label class="col-sm-2 col-form-label">Date of Birth</label>
                    <div class="input-group date" id="datepicker">
                      <input type="date" name="date" class="form-control">
                    </div>
                  </div>
                </div>
                <div class="col">
                  <div class="form-group">
                    <label class="col-sm-2 col-form-label">Gender</label>
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="gender" id="gridRadios1" value="Male" checked>
                      <label class="form-check-label" for="gridRadios1">
                        Male
                      </label>
                    </div>
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="gender" id="gridRadios2" value="Female">
                      <label class="form-check-label" for="gridRadios2">
                        Female
                      </label>
                    </div>
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="gender" id="gridRadios3" value="Not preferred to say">
                      <label class="form-check-label" for="gridRadios3">
                        Not preferred to say
                      </label>
                    </div>
                  </div>
                </div>

              </div>
              <div class="form-group">
                <input type="submit" name="submit" class="btn btn-primary" id="submit" value="submit">
              </div>
            </form>
            <div id="err"></div>
            <div id="postData"></div>
          </div>
        </div>
      </div>
    </div>
    <th><button type="button" id="delete_all" class="btn btn-outline-danger deleteAll">Delete All</button></th>
    <table class="table" id="myTable">
      <thead class="bg-dark text-light">
        <tr>
          <th><input type="checkbox" id="select_all"></th>
          <th scope="col">ID</th>
          <th scope="col">Image</th>
          <th scope="col">Name</th>
          <th scope="col">Mobile</th>
          <th scope="col">Email</th>
          <th scope="col">Date of Birth</th>
          <th scope="col">Gender</th>
          <th scope="col">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Action</th>
        </tr>
      </thead>
      <tbody>

        <?php
        $viewall = $conn->query("SELECT * FROM nametable");
        $number_of_rows_present = $viewall->num_rows;
        $number_of_records_per_page = 5;
        $number_of_pages = ceil($number_of_rows_present / $number_of_records_per_page);
        for ($i = 1; $i <= $number_of_pages; $i++) {
          echo '<button class="btn btn-primary mx-1 mb-3"><a href="index.php?
                page=' . $i . '" class="text-light">' . $i . '</a></button>';
        }
        //default page
        if (isset($_GET['page'])) {
          $page = $_GET['page'];
        } else {
          $page = 1;
        }
        $starting_page = ($page - 1) * $number_of_records_per_page;
        $sqlquery = "SELECT * FROM nametable LIMIT " . $starting_page . ',' . $number_of_records_per_page;
        $res = $conn->query($sqlquery);
        if ($res->num_rows > 0) {
          while ($row = $res->fetch_assoc()) {
            $em = preg_replace('/(?!^).(?=[^@]+@)/', '*', $row['email']);

            $image = '<img src="' . $row['image'] . '" class="img-thumbnail" width="75" height="100" />';

        ?>
            <tr>
              <td><input type="checkbox" class="emp_checkbox" value="<?php echo $row["id"]; ?>"></td>
              <td><?= $row['id'] ?></td>
              <td><?= $image ?></td>
              <td><?= $row['name'] ?></td>
              <td><?= $row['mobile'] ?></td>
              <td><?= $em ?></td>
              <td><?= $row['dob'] ?></td>
              <td><?= $row['gender'] ?></td>
              <td>

                <i class="fa fa-eye" style="font-size:36px;color:green;"></i>&nbsp;&nbsp;&nbsp;
                <i class="fa fa-edit" style="font-size:36px;color:cyan;" id="update" name="update" class="update btn btn-primary btn-sm" data-toggle="modal" data-target="#updateModal" onclick="GetDetails(<?php echo $row['id']; ?> );"></i> &nbsp;&nbsp;&nbsp;

                <i class="fa fa-trash-o" style="font-size:36px;color:red;" id="<?= $row['id']; ?>" name="delete" class="btn btn-danger btn-sm remove" onclick="deletedata(<?php echo $row['id']; ?>);"></i>

              </td>
            </tr>
          <?php
          }

          ?>
      </tbody>
    </table>
  <?php
        } else {
          echo "No record found";
        }
  ?>
  </div>
  <div id="table-data"></div>
  <!-- Edit Modal -->
  <div id="updateModal" class="modal fade">
    <div class="modal-dialog">
      <div class="modal-content">
        <form id="update_form" method="POST" action="">
          <div class="modal-header">
            <h4 class="modal-title">Edit User</h4>
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
          </div>
          <div class="modal-body">
            <input type="hidden" name="up_id" id="uid" class="form-control">
            <div class="form-group">
              <label>Name</label>
              <input type="text" name="up_name" id="updatename" class="form-control">
            </div>
            <div class="form-group">
              <label>Mobile</label>
              <input type="text" name="up_mobile" id="updatemobile" class="form-control">
            </div>
            <div class="form-group">
              <label>Email</label>
              <input type="email" name="up_email" id="updateemail" class="form-control">
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-info" onclick="update()">Update</button>
            <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
            <input type="hidden" id="hiddendata">

          </div>
        </form>
      </div>
    </div>
  </div>

  <!--Error and Success message-->
  <div id="error"></div>
  <div id="success"></div>

  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>


  <script>
    //DATE PICKER


    //INSERT CODE
    $(document).ready(function() {
      $('#input_form').submit(function(e) {
        e.preventDefault();
        $.ajax({
          url: "insertquery.php",
          type: "POST",
          data: $(this).serialize(),
          success: function(data) {
            $("#postData").html(data);
          },
          error: function() {
            alert("Form submission failed!");
          }
        });
      });
    });

    //UPDATE - WORKING
    function GetDetails(updateid) {
      $('#hiddendata').val(updateid);
      $.post("updaterecord.php", {
        updateid: updateid
      }, function(data, status) {
        var userid = JSON.parse(data);
        $('#updatename').val(userid.name);
        $('#updatemobile').val(userid.mobile);
        $('#updateemail').val(userid.email);
      });
      $('#updateModal').modal("show");
    }

    function update() {
      var updatename = $('#updatename').val();
      var updatemobile = $('#updatemobile').val();
      var updateemail = $('#updateemail').val();
      var hiddendata = $('#hiddendata').val();
      $.post("updaterecord.php", {
        updatename: updatename,
        updatemobile: updatemobile,
        updateemail: updateemail,
        hiddendata: hiddendata
      }, function(data, status) {
        //$('#updateModal').modal('hide');
        //displayData();
      });
    }
    //DELETE CODE - WORKING
    function deletedata(id) {
      $(document).ready(function() {
        $.ajax({
          url: 'delete.php',
          type: 'POST',
          data: {
            id: id,
            action: "delete"
          },
          success: function(response) {
            alert("Deleted");
          },
          error: function(response) {
            alert("Something went wrong");
          }
        });
      });
    }
    //CHECKBOX
    $(document).on('click', '#select_all', function() {
      $(".emp_checkbox").prop("checked", this.checked);
      $("#select_count").html($("input.emp_checkbox:checked").length + " Selected");
    });
    $(document).on('click', '.emp_checkbox', function() {
      if ($('.emp_checkbox:checked').length == $('.emp_checkbox').length) {
        $('#select_all').prop('checked', true);
      } else {
        $('#select_all').prop('checked', false);
      }
      $("#select_count").html($("input.emp_checkbox:checked").length + " Selected");
    });

    //DELETE ALL RECORDS
    // delete selected records

    $(document).ready(function() {
      $('.emp_checkbox').click(function() {
        if ($(this).is(':checked')) {
          $(this).closest('tr').addClass('removeRow');
        } else {
          $(this).closest('tr').removeClass('removeRow');
        }
      });
      $('#delete_all').click(function() {
        var checkbox = $('.emp_checkbox:checked');
        if (checkbox.length > 0) {
          var checkbox_value = [];
          $(checkbox).each(function() {
            checkbox_value.push($(this).val());
          });
          $.ajax({
            url: "deleteAll.php",
            type: "POST",
            data: {
              checkbox_value: checkbox_value
            },
            success: function(response) {
              alert("Deleting...");
            },
            error: function(response) {
              alert("Did not work");
            }
          })
        } else {
          alert("Select at least one record");
        }
      });
    });


    //SEARCH
    $(document).ready(function() {

      fill();
     
      function fill(value) {
        $.ajax({
          url: "search.php",
          method: "POST",
          data: {
            value: value
          },
          success: function(data) {
            $('#result').html(data);
          }
        });
      }
      $('#search').keyup(function() {
        var search = $(this).val();
        if (search != '') 
        {
          fill(search);
        } 
        else 
        {
          alert("No data found");
        }
      });
    });
    
    //IMAGE UPLOAD
    $(document).ready(function(e) {
      $("#input_form").on('submit', (function(e) {
        e.preventDefault();
        $.ajax({
          url: "insertquery.php",
          type: "POST",
          data: new FormData(this),
          contentType: false,
          cache: false,
          processData: false,
          beforeSend: function() {
            //$("#preview").fadeOut();
            $("#err").fadeOut();
          },
          success: function(data) {
            if (data == 'invalid') {
              // invalid file format.
              $("#err").html("Invalid File !").fadeIn();
            } else {
              // view uploaded file.
              $("#preview").html(data).fadeIn();
              $("#input_form")[0].reset();
            }
          },
          error: function(e) {
            $("#err").html(e).fadeIn();
          }
        });
      }));
    });
  </script>

  <!--<script src="js/jquery-1.10.2.js" type="text/javascript"></script>-->
</body>

</html>