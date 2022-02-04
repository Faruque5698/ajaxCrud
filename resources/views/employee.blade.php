<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

</head>
<body>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>Laravel AJax CRUD
                        <a href="#" data-bs-toggle="modal" data-bs-target="#AddEmployeeModal" class="btn btn-primary btn-sm float-end">Add Employee</a>
                    </h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">

                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Name</th>
                                    <th>Phone</th>
                                    <th>Image</th>
                                    <th>Edit</th>
                                    <th>Delete</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="AddEmployeeModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Employee</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="" id="AddEmployeeForm" method="POST" enctype="multipart/form-data">
                @csrf
            <div class="modal-body">
                <div class="form-group mb-3">
                    <label for="">Name</label>
                    <input type="text" class="form-control" name="name">
                </div>
                <div class="form-group mb-3">
                    <label for="">Phone</label>
                    <input type="text" class="form-control" name="phone">
                </div>
                <div class="form-group mb-3">
                    <label for="">Image</label>
                    <input type="file" class="form-control" name="image">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="EditEmployeeModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Employee</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="" id="UpdateEmployeeForm" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <input type="hidden" id="emp_id" name="emp_id">
                    <div class="form-group mb-3">
                        <label for="">Name</label>
                        <input type="text" id="edit_name" class="form-control" name="name">
                    </div>
                    <div class="form-group mb-3">
                        <label for="">Phone</label>
                        <input type="text" id="edit_phone" class="form-control" name="phone">
                    </div>
                    <div class="form-group mb-3">
                        <label for="">Image</label>
                        <input type="file" class="form-control" name="image">
{{--                        <img src="" alt="" id="image" width="100px" height="100px" >--}}
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $(document).ready(function (){
        fetchEmployee();
        function fetchEmployee(){
            $.ajax({
                type:"GET",
                url:"/fetch-employee",
                dataType:"json",
                success:function (response){
                    // console.log(response.employee);

                    $('tbody').html("");

                    $.each(response.employee, function (key, employee){
                        $('tbody').append('<tr>\
                            <td>'+employee.id+'</td>\
                        <td>'+employee.name+'</td>\
                        <td>'+employee.phone+'</td>\
                        <td><img src="'+employee.image+'" alt="" width="50px" height="50px"></td>\
                        <td><button type="button"value="'+employee.id+'" class="edit_btn btn btn-success btn-sm">Edit</button></td>\
                        <td><button type="button"value="'+employee.id+'" class="delete_btn btn btn-danger btn-sm">Delete</button></td>\
                    </tr>');
                    })

                }
            })
        }


        $(document).on('click', '.edit_btn', function (e) {
            e.preventDefault();

            let emp_id = $(this).val();

            $('#EditEmployeeModal').modal('show');

            $.ajax({
                type: "GET",
                url: "/edit-employee/" + emp_id,
                success: function (response) {

                    if (response.status == 404) {
                        alert(response.message);
                        $('#EditEmployeeModal').modal('hide');
                    } else {
                        $('#edit_name').val(response.employee.name);
                        $('#edit_phone').val(response.employee.phone);
                        $('#emp_id').val(response.employee.id);
                        $("#image").attr("src", response.employee.image);
                        // console.log(response.employee.name);
                    }

                }
            });
        });
            $(document).on('click', '.delete_btn', function (e){
            e.preventDefault();

            let emp_id = $(this).val();



            $.ajax({
                type:"GET",
                url:"/delete-employee/"+emp_id,
                success:function (response){
                    fetchEmployee();
                    alert(response.message);

                }
            })



        });


        $(document).on('submit', '#UpdateEmployeeForm', function (e){
            e.preventDefault();

            // let id = $('#emp_id').val();
            let EditFormData = new FormData($('#UpdateEmployeeForm')[0]);

            $.ajax({
                type:"POST",
                url:"/update-employee/",
                data:EditFormData,
                contentType:false,
                processData:false,
                success:function (response){
                    if(response.status == 200){
                        alert(response.message);
                        $('#UpdateEmployeeForm').find('input').val('');
                        $('#EditEmployeeModal').modal('hide');
                        fetchEmployee();

                    }
                }
            })
        })



        $(document).on('submit', '#AddEmployeeForm', function (e){
            e.preventDefault();

            let formData = new FormData($('#AddEmployeeForm')[0]);
            $.ajax({
                type:"POST",
                url:"/employee",
                data:formData,
                contentType:false,
                processData:false,
                success:function (response){
                    if(response.status == 200){
                        $('#AddEmployeeForm').find('input').val('');
                        $('#AddEmployeeModal').modal('hide');
                        fetchEmployee();
                    }
                }
            })

        })
    })
</script>

</body>
</html>
