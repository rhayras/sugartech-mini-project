@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-center align-items-center">
      <div class="container">
        <div class="row d-flex justify-content-center">
          <div class="col-12 col-md-8 col-lg-6">
            <div class="card bg-white">
              <div class="card-body p-5">
                <div class="alert alert-danger print-error-msg" style="display:none">
                    <ul></ul>
                </div>
                <form class="mb-3 mt-md-4" method="POST" id="loginForm">
                  @csrf
                  <div class="mb-3">
                    <label for="username" class="form-label ">Username</label>
                    <input type="text" class="form-control" name="username" id="username" placeholder="" required>
                  </div>
                  <div class="mb-3">
                    <label for="password" class="form-label ">Password</label>
                    <input type="password" class="form-control" name="password" id="password" placeholder="*******" required>
                  </div>
                  <div class="d-grid">
                    <button class="btn btn-dark" type="submit">Login</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
@endsection

@section('scripts')

<script>
  

  $(document).ready(function(){
    $("#loginForm").on('submit', function(e){
      e.preventDefault();
      var errFlag = 0;

      var username = $('#username').val();
      var password = $('#password').val();

      if(username == "")  { errFlag = 1; }
      if(password == "")  { errFlag = 1; }
      
      if(errFlag == 1){
        alert("All fields are required!");
      }else{
        $.ajax({
          url: "{{ url('login') }}",
          type:"POST",
          data:{
            "_token": "{{ csrf_token() }}",
            "username":username,
            "password":password,
          },
          success: function(data) {
            if(data.success){
                window.location.href = "{{ url('home') }}";
            }else{
                alert(data.msg);
            }
          }
        });
      }
    });
  });
</script>
@endsection
