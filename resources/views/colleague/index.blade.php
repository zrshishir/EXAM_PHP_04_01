<!DOCTYPE html>

<html>

<head>

    <title>Exam PHP</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />
    <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>  
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/4.4.0/bootbox.min.js"></script>

</head>

<style type="text/css">
    .container{
        margin-top:150px;
    }

    h4{
        margin-bottom:30px;
    }

</style>

<body>

<div class="container">

    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="row">
                <div class="col-md-12 text-center">
                    <h4>Office Colleague Information</h4>
                </div>
                <div class="col-md-12 text-right mb-5">
                    <a class="btn btn-success" href="javascript:void(0)" id="createNewColleague"> Create New Colleague</a>
                </div>
                <div class="col-md-12">
                    <table class="table table-bordered data-table">
                        <thead>

                            <tr>

                                <th>SL.</th>
                                <th>Office Name</th>
                                <th>Office Address</th>
                                <th>No. of Colleagues</th>
                                <th width="280px">OPT</th>

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

   

<div class="modal fade" id="ajaxModel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">

                <h4 class="modal-title" id="modelHeading"></h4>

            </div>

            <div class="modal-body">

                <form id="ColleagueForm" name="ColleagueForm" class="form-horizontal">

                    <input type="hidden" name="Colleague_id" id="Colleague_id">

                    <label for="office_name" class="col-sm-6 control-label">Office Information</label>

                    <div class="form-group row">
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="office_name" name="office_name" placeholder="Office Name" value="" maxlength="50" required="">
                        </div>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="office_address" name="office_address" placeholder="Office Address" value="" maxlength="50" required="">
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="office_phone" name="office_phone" placeholder="Office Phone" value="" maxlength="50" required="">
                        </div>
                        <div class="col-sm-6">
                            <input type="file" class="form-control" id="appointment_letter" name="appointment_letter" placeholder="Appointment Letter" value="" maxlength="50" required="">
                        </div>
                    </div>

                    <hr>

                    <!-- <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-primary" id="saveBtn" value="create">Add Office Colleague</button>
                    </div> -->



                    <label for="colleague" class="col-sm-6 control-label">Colleague Information</label>

                    <div class="form-group row">
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="colleague_name" name="colleague_name" placeholder="Colleague Name" value="" maxlength="50" required="">
                        </div>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="colleague_mobile" name="colleague_mobile" placeholder="Mobile" value="" maxlength="50" required="">
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="colleague_address" name="colleague_address" placeholder="Colleague Address" value="" maxlength="50" required="">
                        </div>
                        <div class="col-sm-6">
                            <input type="file" class="form-control" id="photo" name="photo" placeholder="Photo" value="" maxlength="50" required="">
                        </div>
                    </div>

      

                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-primary" id="saveBtn" value="create">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</body>

    

<script type="text/javascript">

    $(function () {

    $.ajaxSetup({

        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }

    });

    var table = $('.data-table').DataTable({

        processing: true,
        serverSide: true,
        ajax: {
            "url": "{{ route('colleagues.index') }}",
            "type": "GET"
        },
        
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'office_name', name: 'office_name'},
            {data: 'office_address', name: 'office_address'},
            {data: 'office_phone', name: 'office_phone'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]

    });

     

    $('#createNewColleague').click(function () {

        $('#saveBtn').val("create-Colleague");
        $('#Colleague_id').val('');
        $('#ColleagueForm').trigger("reset");
        $('#modelHeading').html("Create New Colleague");
        $('#ajaxModel').modal('show');

    });

    

    $('body').on('click', '.editColleague', function () {

        var colleague_id = $(this).data('id');

        $.get("{{ route('colleagues.index') }}" +'/' + colleague_id +'/edit', function (data) {

            $('#modelHeading').html("Edit Colleague");
            $('#saveBtn').val("edit-user");
            $('#ajaxModel').modal('show');
            $('#Colleague_id').val(data.id);
            $('#office_name').val(data.office_name);
            $('#office_address').val(data.office_address);
            $('#office_phone').val(data.office_phone);
            $('#appointment_letter').val(data.appointment_letter);
            $('#colleague_name').val(data.colleague_name);
            $('#colleague_mobile').val(data.colleague_mobile);
            $('#colleague_address').val(data.colleague_address);
            $('#photo').val(data.photo);
        })

    });

    $('body').on('click', '.viewColleague', function () {

        var colleague_id = $(this).data('id');

        $.get("{{ route('colleagues.index') }}" +'/' + colleague_id +'/view', function (data) {

            $('#modelHeading').html("View Colleague");
            $('#saveBtn').val("edit-user");
            $('#ajaxModel').modal('show');
            $('#Colleague_id').val(data.id);
            $('#office_name').val(data.office_name);
            $('#office_address').val(data.office_address);
            $('#office_phone').val(data.office_phone);
            $('#appointment_letter').val(data.appointment_letter);
            $('#colleague_name').val(data.colleague_name);
            $('#colleague_mobile').val(data.colleague_mobile);
            $('#colleague_address').val(data.colleague_address);
            $('#photo').val(data.photo);
        })

    });

    

    $('#saveBtn').click(function (e) {

        e.preventDefault();
        $(this).html('Sending..');

        $.ajax({
            data: $('#ColleagueForm').serialize(),
            url: "{{ route('colleagues.store') }}",
            type: "POST",
            dataType: 'json',

            success: function (data) {
                $('#ColleagueForm').trigger("reset");
                $('#ajaxModel').modal('hide');
                table.draw();

            },

            error: function (data) {
                console.log('Error:', data);
                $('#saveBtn').html('Save Changes');
            }

        });

    });


    $('body').on('click', '.deleteColleague', function (){

        var colleague_id = $(this).data("id");
        var result = confirm("Are You sure want to delete !");

        if(result){
            $.ajax({
                type: "DELETE",
                url: "{{ route('colleagues.store') }}"+'/'+colleague_id,
                success: function (data) {
                    table.draw();
                },

                error: function (data) {
                    console.log('Error:', data);
                }

            });

        }else{
            return false;
        }

    });

});

</script>

</html>