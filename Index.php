<?php require 'DatabaseConnection.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Members Tree</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
   
    <style>  
        .container{
           padding: 5% 20%;
           border: 2px solid black;
           margin-top: 20px;
        } 
        .container h1{
           padding: 2px;
           text-align: center;
           /* border: 2px solid black; */
           /* margin-top: 20px; */
        }  
        /* .tree-container{
            padding-left: 40px;
        }   */
    </style>
</head>
<body>
<div class="container">
    <h1>Members Tree</h1>
    <div id="tree-container">
        <?php include 'GetMembers.php'; ?>
    </div>

    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#AddMemberModal" data-whatever="@mdo">Add Member</button>

    <div class="modal fade" id="AddMemberModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Member</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="addMemberForm">
          <div class="form-group">
            <label for="recipient-name" class="col-form-label">Select Parent :</label>
            <select name="parent-select" id="parent-select" class="form-control">
                <option value="">select Parent</option>
            </select>
          </div>
          <div class="form-group">
            <label for="member-name" class="col-form-label">Name of Member :</label>
            <input type="text" class="form-control" id="member-name" required>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="add-member">Save</button>
      </div>
    </div>
  </div>
</div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
   
    <script>
        $(document).ready(function() {

            function loadParents() {
                $.ajax({
                    url: "GetParents.php",
                    type: "GET",
                    success: function(data) {
                        $("#parent-select").html(data);
                    }
                });
            }

            function refreshTree() {
                $.ajax({
                    url: "GetMembers.php",
                    type: "GET",
                    success: function(data) {
                        $("#tree-container").html(data);
                    }
                });
            }

            $(document).on("click", "#add-member", function() {
                let name = $("#member-name").val();
                let parentId = $("#parent-select").val();

                if (name) {
                    $.ajax({
                        url: "AddMember.php",
                        type: "POST",
                        data: { name: name, parent_id: parentId },
                        success: function(response) {
                            // alert(response);
                            $("#AddMemberModal").modal("hide");
                            $("#addMemberForm")[0].reset();
                            refreshTree();
                            loadParents(); 
                        }
                    });
                    } else {
                        alert("Please enter member name!");
                    }
                });

    loadParents();
    refreshTree();
    });
    </script>

</body>
</html>
