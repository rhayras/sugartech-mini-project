@extends('layouts.app')

@section('css')
    <link href="https://cdn.datatables.net/1.13.5/css/dataTables.bootstrap5.min.css" rel="stylesheet" />
@endsection

@section('content')
    {{-- Add Employee Modal --}}
    <div class="modal fade" id="newEmployeeModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="visitorModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="alert alert-danger print-error-msg" style="display:none">
                <ul></ul>
            </div>
            <form method="POST" id="employeeForm">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="visitorModalLabel">Employee Details</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group mb-2">
                            <label>First Name</label>
                            <input type="text" name="firstName" id="firstName" class="form-control" />
                        </div>
                        <div class="form-group mb-2">
                            <label>Last Name</label>
                            <input type="text" name="lastName" id="lastName" class="form-control" />
                        </div>
                        <div class="form-group mb-2">
                            <label>Birthday</label>
                            <input type="date" name="birthday" id="birthday" class="form-control" />
                        </div>
                        <div class="form-group mb-2">
                            <label>Gender</label>
                            <select name="gender" id="gender" class="form-control">
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>
                        </div>
                        <div class="form-group mb-2">
                            <label>Monthly Salary</label>
                            <div class="input-group mb-3">
                            <span class="input-group-text" id="addons">P</span>
                                <input type="number" name="monthlySalary" id="monthlySalary" class="form-control" aria-describedby="addons" onKeyPress="if(this.value.length==8) return false;">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary btn-submit">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Edit Employee Modal --}}
    <div class="modal fade" id="updateEmployeeModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="visitorModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="alert alert-danger print-error-msg" style="display:none">
                <ul></ul>
            </div>
            <form method="POST" id="updateEmployeeForm">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="visitorModalLabel">Employee Details</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary btn-update">Save Changes</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <h3>Dashboard</h3>
    <div class="float-end">
        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#newEmployeeModal">Add</button>
    </div>
    <div class="clearfix"></div>

    <div class="row mt-2">
        <div class="col-lg-12">
            <div class="table-responsive">
                <table class="table table-bordered" id="recordTable">
                    <thead>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Gender</th>
                        <th>Birthday</th>
                        <th>Monthly Salary</th>
                        <th>Action</th>
                    </thead>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.5/js/dataTables.bootstrap5.min.js"></script>
<script>
    $(document).ready(function(){
        var table = $('#recordTable').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            autoWidth: false,
            aaSorting: [[0,'decs']],
            ajax: {
                url: "{{ route('loadEmployees') }}",
                method: "POST"
            },
            pageLength: 10,
            columns: [
                {data: 'first_name', name: 'first_name', orderable:false},
                {data: 'last_name', name: 'last_name', orderable:false},
                {data: 'gender', name: 'gender', orderable:false},
                {data: 'birthday', name: 'birthday', orderable:false},
                {data: 'monthly_salary', name: 'monthly_salary', orderable:false},
                {data: 'action', name: 'action', orderable:false},
            ]
        });

        $("#employeeForm").on('submit', function(e){
            e.preventDefault();
            var errFlag = 0;

            var firstName = $('#firstName').val();
            var lastName = $('#lastName').val();
            var gender = $('#gender').val();
            var birthday = $('#birthday').val();
            var monthlySalary = $('#monthlySalary').val();

            if(firstName == "")  { errFlag = 1; }
            if(lastName == "")  { errFlag = 1; }
            if(gender == "")  { errFlag = 1; }
            if(birthday == "")  { errFlag = 1; }
            if(monthlySalary == "")  { errFlag = 1; }

            if(errFlag == 1){
            alert("All fields are required!");
            }else{
            $.ajax({
                url: "{{ url('saveEmployee') }}",
                type:"POST",
                data:{
                    "_token": "{{ csrf_token() }}",
                    "firstName":firstName,
                    "lastName":lastName,
                    "gender":gender,
                    "birthday":birthday,
                    "monthlySalary":monthlySalary,
                },
                beforeSend: function(){
                    $('.btn-submit').attr('disabled', true).html('Please wait...');
                },
                success: function(data) {
                    if(!data.success){
                        alert(data.msg);
                    }else{
                        table.ajax.reload(null, false);
                        $("#newEmployeeModal").modal("toggle");
                        $("#employeeForm")[0].reset();
                    }
                    $('.btn-submit').attr('disabled', false).html('Submit');
                }
            });
            }
        });

        //Delete function
        $(document).on('click',".btn-delete",function(){
            var id = $(this).data("id");
            if (confirm('Are you sure you want to delete this employee?')) {
                $.ajax({
                    url: "{{ url('deleteEmployee') }}",
                    type:"POST",
                    data:{
                        "_token": "{{ csrf_token() }}",
                        "id":id
                    },
                    success: function(data) {
                        table.ajax.reload(null, false);
                    }
                });
            }
        });

        //Edit function
        $(document).on('click',".btn-edit",function(){
            var id = $(this).data("id");
            $.ajax({
                url: "{{ url('editEmployeeForm') }}",
                type:"POST",
                data:{
                    "_token": "{{ csrf_token() }}",
                    "id":id
                },
                dataType: 'JSON',
                success: function(data) {
                    $("#updateEmployeeModal").modal('toggle');
                    $("#updateEmployeeModal .modal-body").html(data.output);
                }
            });
        });

        $("#updateEmployeeForm").on('submit', function(e){
            e.preventDefault();
            var errFlag = 0;

            var firstName = $('#edit_firstName').val();
            var lastName = $('#edit_lastName').val();
            var gender = $('#edit_gender').val();
            var birthday = $('#edit_birthday').val();
            var monthlySalary = $('#edit_monthlySalary').val();
            var id = $('#edit_id').val();

            if(firstName == "")  { errFlag = 1; }
            if(lastName == "")  { errFlag = 1; }
            if(gender == "")  { errFlag = 1; }
            if(birthday == "")  { errFlag = 1; }
            if(monthlySalary == "")  { errFlag = 1; }

            if(errFlag == 1){
            alert("All fields are required!");
            }else{
            $.ajax({
                url: "{{ url('updateEmployee') }}",
                type:"POST",
                data:{
                    "_token": "{{ csrf_token() }}",
                    "id":id,
                    "firstName":firstName,
                    "lastName":lastName,
                    "gender":gender,
                    "birthday":birthday,
                    "monthlySalary":monthlySalary,
                },
                beforeSend: function(){
                    $('.btn-update').attr('disabled', true).html('Please wait...');
                },
                success: function(data) {
                    if(!data.success){
                        alert(data.msg);
                    }else{
                        table.ajax.reload(null, false);
                        $("#updateEmployeeModal").modal("toggle");
                    }
                    $('.btn-update').attr('disabled', false).html('Save Changes');
                }
            });
            }
        });

    });
</script>
@endsection