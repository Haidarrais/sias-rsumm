@extends('layouts.dashboard')
@section('title')

@if (Request::path() != '/')
@php
$paths = explode('/', Request::path());
$len = count($paths)-1;
echo ucfirst($paths[$len]);
@endphp
@else
Dashboard
@endif
@endsection
@section('header')
Manajemen User
@endsection
@section('content')
<!-- Main Content -->
<div class="section-body">

  <div class="card">
    <div class="card-header">
      <h4>Data User</h4>
      <div class="card-header-action">
        @role('superadmin')
        <button class="btn btn-primary" id="adduser">
          <i class="fas fa-plus"></i>
          <span>Tambah User</span>
        </button>
        <button type="button" class="btn btn-warning" onclick="setIndex({{Auth::id()}})">Self Edit <i class="far fa-edit"></i></button>
        @endrole
      </div>
    </div>
    <div class="card-body p-2>
      <div class="table-responsive">
        <table class="table table-striped table-md">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th style="text-align: center">Action</th>
                </tr>
                <tbody>
            </thead>
            @foreach ($users as $key => $user)
            <tr>
                <td>{{$key+1}}</td>
                <td>{{$user->name}}</td>
                <td>{{$user->email}}</td>
                <td>{{$user->roles[0]->name}}</td>
                <td>
                    @role('superadmin')
                    <form action="{{ route('user.destroy', $user->id) }}" method="POST">
                    <button type="button" class="btn btn-warning" onclick="setIndex({{$user->id}})"><i class="far fa-edit"></i></button>
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger"><i class="far fa-trash-alt"></i></button>
                    </form>
                    @endrole
                    {{-- modal_edit{{$key}} --}}
                    {{-- <button onclick="alert('modal_edit{{$key}}'); document.getElementById('modal_edit{{$key}}').classList.toggle('show')"><i class="far fa-edit"></i></button> --}}
                </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>

  </div>
</div>
@endsection
@section('modal')
    <div class="modal" id="modal_tambah" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="modal_title">Tambah User</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('user.store') }}" id="form-edit-user" method="POST">
                <input type="text" name="_method" id="form_method" value="POST" hidden>
                @csrf
                <div class="form-group">
                    <label for="form_name">Name</label>
                    <input type="text" id="form_name" placeholder="Enter name" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" autofocus>
                    @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="form_name">Username</label>
                    <input type="text" id="form_username" placeholder="Enter username" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}">
                    @error('username')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="form_email">Email</label>
                    <input type="email" id="form_email" placeholder="Enter email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}">
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="row">
                    <div class="form-group col-6">
                        <label for="password" class="d-block">Password</label>
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror pwstrength" data-indicator="pwindicator" name="password">
                        <div id="pwindicator" class="pwindicator">
                            <div class="bar"></div>
                            <div class="label"></div>
                        </div>
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group col-6">
                        <label for="password2" class="d-block">Password Confirmation</label>
                        <input id="password2" type="password" class="form-control" name="password_confirmation">
                    </div>
                </div>
                <div class="form-group">
                    <label for="form_password">Role</label>
                    <select id="form_roles" class="form-control @error('roles') is-invalid @enderror" name="roles" value="{{ old('roles') }}" autofocus>
                        <option value="" selected disabled>== Pilih salah satu Role dibawah ini ==</option>
                        @foreach ($roles as $role)
                            <option value="{{$role->name}}">{{$role->name}}</option>
                        @endforeach
                    </select>
                    @error('roles')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save</button>
            </form>
            </div>
        </div>
        </div>
    </div>
@endsection
@section('script')
@if($errors->any())
<script>
    $(document).ready(function() {
        $('#modal_tambah').modal('show');
    });
</script>
<script>
    $(document).ready(function() {
        $('.table').DataTable();
    } );
</script>
@endif
<script>
    $('#adduser').on('click', () => {
        $('#modal_tambah').modal('show')
    });
    function setIndex(id) {
        index = id;
        console.log(index);
        var url = "{{route('user.show', ":id ")}}";
        url = url.replace(":id", id);
        $.ajax({
            type: 'GET',
            url: url,
            success: function(data) {
                console.log(data);
                $('#modal_tambah').modal('show')
                $("#modal_title").html('Modal Edit')
                $("#form_method").val("PATCH")
                $("#form_name").val(data.data.name)
                $("#form_username").val(data.data.username)
                $("#form_email").val(data.data.email)
                $("#form_roles").val(data.data.roles[0].name)
                var formAction = "{{route('user.update', ":id")}}";
                formAction = formAction.replace(':id', id);
                $("#form-edit-user").attr("action", formAction);
            },
        });
    }
</script>
@endsection
