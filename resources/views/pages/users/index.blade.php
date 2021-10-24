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
        @endrole
      </div>
    </div>
    <div class="card-body p-0">
      <div class="table-responsive">
        <table class="table table-striped table-md">
          <tbody>
            <tr>
              <th>No</th>
              <th>Nama</th>
              <th>Email</th>
              <th>Role</th>
              <th style="text-align: center">Action</th>
            </tr>
            @foreach ($users as $key => $user)
            <tr>
                @if ($user->roles[0]->name != 'superadmin')
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
                @endif
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
    <div class="card-footer text-right" modal-part>
      <nav class="d-inline-block">
        <ul class="pagination mb-0">
          <li class="page-item disabled">
            <a class="page-link" href="#" tabindex="-1"><i class="fas fa-chevron-left"></i></a>
          </li>
          <li class="page-item active"><a class="page-link" href="#">1 <span class="sr-only">(current)</span></a></li>
          <li class="page-item">
            <a class="page-link" href="#">2</a>
          </li>
          <li class="page-item"><a class="page-link" href="#">3</a></li>
          <li class="page-item">
            <a class="page-link" href="#"><i class="fas fa-chevron-right"></i></a>
          </li>
        </ul>
      </nav>
    </div>
  </div>
</div>
@endsection
@section('modal')
    <div class="modal" id="modal_tambah" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="modal_title"></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
                <form action="{{route('register')}}" id="form-edit-user" method="POST">
                <input type="text" name="_method" id="form_method" hidden>
                @csrf
                <div class="form-group">
                    <label for="form_name">Name</label>
                    <input type="text" class="form-control" id="form_name" placeholder="Enter name" name="name">
                </div>
                <div class="form-group">
                    <label for="form_email">Email</label>
                    <input type="email" class="form-control" id="form_email" placeholder="Enter email" name="email">
                </div>
                <div class="form-group">
                    <label for="form_password">Password</label>
                    <input type="password" class="form-control" id="form_password" placeholder="Password" name="password">
                </div>
                <div class="form-group">
                    <label for="form_password">Role</label>
                    <select name="roles" id="form_roles" class="form-control">
                        @foreach ($roles as $role)
                            <option value="{{$role->name}}">{{$role->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save changes</button>
            </form>
            </div>
        </div>
        </div>
    </div>
@endsection
@section('script')
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
