@extends('layouts.app')

@section('content')

<!-- add student Modal -->
<div class="modal fade" id="AddStudentModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Add student</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">

            <ul id="saveform_errList"></ul>

          <div class="form-group mb-3">
              <label for="">Name</label>
              <input type="text" class="name form-control">
          </div>
          <div class="form-group mb-3">
            <label for="">Email</label>
            <input type="text" class="email form-control">
        </div>
        <div class="form-group mb-3">
            <label for="">Phone</label>
            <input type="text" class="phone form-control">
        </div>
        <div class="form-group mb-3">
            <label for="">Course</label>
            <input type="text" class="course form-control">
        </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary add_student">Save</button>
        </div>
      </div>
    </div>
  </div>
  <!-- End add student Modal -->
  <!-- Edit student Modal -->
  <div class="modal fade" id="EditStudentModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Edit & update student</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">

            <ul id="updateform_errList"></ul>

          <input type="hidden" id="edit_stu_id">
          <div class="form-group mb-3">
              <label for="">Name</label>
              <input type="text" id="edit_name" class="name form-control">
          </div>
          <div class="form-group mb-3">
            <label for="">Email</label>
            <input type="text" id="edit_email" class="email form-control">
        </div>
        <div class="form-group mb-3">
            <label for="">Phone</label>
            <input type="text" id="edit_phone" class="phone form-control">
        </div>
        <div class="form-group mb-3">
            <label for="">Course</label>
            <input type="text" id="edit_course" class="course form-control">
        </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary update_student">Update</button>
        </div>
      </div>
    </div>
  </div>
  <!-- End Edit student Modal -->

    <!-- delete student Modal -->
    <div class="modal fade" id="DeleteStudentModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Delete student</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <input type="hidden" id="delete_stu_id">
              <h4>Are you sure?</h4>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary delete_student_btn">Yes delete</button>
            </div>
          </div>
        </div>
      </div>
      <!-- End delete student Modal -->

<div class="container py-5">
    <div class="row">
        <div class="col-md-12">
            <div id="success_message"></div>
            <div class="card">
                <div class="card-header">
                     <h4>Student Data</h4>
                     <a href="#" class="btn btn-primary float-end btn-sm" data-bs-toggle="modal" data-bs-target="#AddStudentModal">Add Student</a>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Course</th>
                                <th>edit</th>
                                <th>delete</th>

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

@endsection

@section('scripts')

<script>
    $(document).ready(function () {

        getstudent(); //to view i have to call the function outside

        function getstudent(){
            $.ajax({
                type: "GET",
                url: "/get-student",
                dataType: "json",
                success: function (response) {
                    // console.log(response.students);
                    $('tbody').html("");//when geting data firsst empty the table then get data
                    $.each(response.students, function (key, item) {
                        $('tbody').append(
                            '<tr>\
                                <td>'+item.id+'</td>\
                                <td>'+item.name+'</td>\
                                <td>'+item.email+'</td>\
                                <td>'+item.phone+'</td>\
                                <td>'+item.course+'</td>\
                                <td><button type="button" value="'+item.id+'" class="edit_student btn btn-primary btn-sm">Edit</button></td>\
                                <td><button type="button" value="'+item.id+'" class="delete_student tbtn btn-danger btn-sm">Delete</button></td>\
                            </tr>');
                    });
                }
            });
        } //end get student

        $(document).on('click','.delete_student' ,function (e) { //click on delete
            e.preventDefault();

            var stu_id = $(this).val(); //value comming from line 142
            $('#delete_stu_id').val(stu_id); //modal show korle input field e ei id show korbe
            $('#DeleteStudentModal').modal('show');

            $(document).on('click','.delete_student_btn', function (e) {//clock on delete btn
                e.preventDefault();

                $(this).text("Deleting");//when click on yes delete deleting will show on button
                var stu_id = $('#delete_stu_id').val();
                $.ajax({
                type: "GET",
                url: "/delete/"+stu_id,
                success: function (response) {

                        $('#success_message').html("");//making field empty
                        $('#success_message').addClass('alert alert-danger');
                        $('#success_message').text(response.message);
                        $('#DeleteStudentModal').modal('hide');
                        $('.delete_student_btn').text("Yes delete"); //after show deleting it will reset as yes delete
                        getstudent();

                }
            });
            });
            // alert(stu_id);
            // $.ajax({
            //     type: "GET",
            //     url: "/delete/"+stu_id,
            //     success: function (response) {
            //         if(response.status == 200){
            //             $('#success_message').html("");//making field empty
            //             $('#success_message').addClass('alert alert-success');
            //             $('#success_message').text(response.message);

            //             getstudent();
            //         }else{
            //             $('#success_message').html("");//making field empty
            //             $('#success_message').addClass('alert alert-danger');
            //             $('#success_message').text(response.message);
            //         }
            //     }
            // });
        });

        $(document).on('click', '.edit_student', function (e) {
            e.preventDefault();
            var stu_id = $(this).val(); //value comming from line 141
            // console.log(stu_id);
            $('#EditStudentModal').modal('show');
            $.ajax({
                type: "GET",
                url: "/edit-student/"+stu_id,
                success: function (response) {
                    // console.log(response);
                    if(response.status == 404){
                        $('#success_message').html("");//making field empty
                        $('#success_message').addClass('alert alert-danger');
                        $('#success_message').text(response.message);
                    }else{ //value pele
                        $('#edit_name').val(response.student.name);  //response .student comming from controller//name database field name
                        $('#edit_email').val(response.student.email);//data modal er field e bose jabe
                        $('#edit_phone').val(response.student.phone);
                        $('#edit_course').val(response.student.course);
                        $('#edit_stu_id').val(stu_id);
                    }
                }
            });

        });

        $(document).on('click', '.update_student', function (e) {
            e.preventDefault(); //stop the loadin of page
            var stu_id = $('#edit_stu_id').val();

            var data ={
                'name' : $('#edit_name').val(),
                'email' : $('#edit_email').val(),
                'phone' : $('#edit_phone').val(),
                'course' : $('#edit_course').val(),
            }

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: "PUT",
                url: "/update-student/"+stu_id,
                data: data,
                dataType: "json",
                success: function (response) {
                    // console.log(response);
                    if(response.status == 400){ //modal e error show korbe
                        $('#updateform_errList').html(""); //make error list empty
                        $('#updateform_errList').addClass('alert alert-danger');
                        $.each(response.errors, function (key, err_values) { //response.errors thke jei value asbe seta err_values e jabe
                            $('#updateform_errList').append('<li>'+err_values+'</li>');  //this id is in above//for each akare value asbe and uporer ul e show hobe

                        });
                    }else if(response.status == 404){//div e error show korbe

                        $('#updateform_errList').html(""); //whatever error comes making error list empty//
                        $('#success_message').addClass('alert alert-danger') //div e msg show korbe
                        $('#success_message').text(response.message)

                    }else{

                        $('#updateform_errList').html(""); //whatever error comes making error list empty//
                        $('#success_message').html("");
                        $('#success_message').addClass('alert alert-success') //div e msg show korbe
                        $('#success_message').text(response.message)
                        $('#EditStudentModal').modal('hide'); //after succes hiding modal


                        $('#EditStudentModal').find('input').val("");//after succesfully input //making input field empty
                        getstudent();

                    }//end if
                }
            });

        });

        $(document).on('click', '.add_student' , function (e) {
            e.preventDefault();

            var data = {
                'name': $('.name').val(),
                'email': $('.email').val(),
                'phone': $('.phone').val(),
                'course': $('.course').val(),
            }
            // console.log(data);

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: "POST",
                url: "/add-student",
                data: data,
                dataType: "json",
                success: function (response) {
                    // console.log(response);
                    if(response.status == 400){ //controller e response 400 pele//modal e error show korbe
                        $('#saveform_errList').html(""); //make error list empty
                        $('#saveform_errList').addClass('alert alert-danger');
                        $.each(response.errors, function (key, err_values) {
                            $('#saveform_errList').append('<li>'+err_values+'</li>');  //this id is in above

                        });

                    }
                    else{
                        $('#saveform_errList').html(""); //whatever error comes making error list empty//
                        $('#success_message').addClass('alert alert-success') //div e msg show korbe
                        $('#success_message').text(response.message)
                        $('#AddStudentModal').modal('hide'); //after succes hiding modal
                        // $('.modal-backdrop').remove();

                        $('#AddStudentModal').find('input').val("");//after succesfully input //making input field empty
                        getstudent();

                    }

                }
            });

        });//end addstudent


    });
</script>

@endsection
