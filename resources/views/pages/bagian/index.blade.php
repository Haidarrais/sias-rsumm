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
Divisi
@endsection
@section('content')
<!-- Main Content -->
<div class="section-body">

  <div class="card">
    <div class="card-header">
      <h4>Unit / Divisi</h4>
      <div class="card-header-action">
        @role('admin')
        <button class="btn btn-primary" id="addDivision">
          <i class="fas fa-plus"></i>
          <span>Tambah Unit</span>
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
              <th>Nama Unit</th>
              <th>Kode</th>
              @role('admin')
              <th style="text-align: center">Action</th>
              @endrole
            </tr>
            @foreach ($divisions as $key => $division)
            <tr>
              <td>{{$key+1}}</td>
              <td>{{$division->name}}</td>
              <td>{{$division->leader}}</td>
              <td>
                @role('admin')
                <form action="{{ route('division.destroy', $division->id) }}" method="POST">
                  <a href="#" class="btn btn-warning" onclick="setIndex({{$division->id}})"><i class="far fa-edit"></i></a>
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn btn-danger"><i class="far fa-trash-alt"></i></button>
                </form>
                @endrole
              </td>
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
<div class="modal fade" id="modal_tambah" tabindex="-1" role="dialog" aria-labelledby="modal_tambah" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modal_title">Tambah Divisi</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{route('division.store')}}" method="POST" id="form-add-division-data" enctype="multipart/form-data">
        <input type="text" name="_method" id="form_method" value="POST" hidden>
        @csrf
        <div class="modal-body row">
          <div class="form-group col-md-6">
            <label for="">Nama Unit</label>
            <input type="text" class="form-control" name="name" value="{{old('name')}}" id="form_name">
          </div>
          <div class="form-group col-md-6">
            <label for="">Kode</label>
            <input type="text" class="form-control" name="leader" value="{{old('leader')}}" id="form_leader">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Submit</button>
        </div>
      </form>
    </div>
  </div>
</div>

@endsection
@section('script')
<script>
    $('#addDivision').on('click', () => {
        $('#modal_tambah').modal('show')
    });
    function setIndex(id) {
        //index = id;
        //console.log(index);
        var url = "{{route('division.edit', ":id ")}}";
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
                $("#form_leader").val(data.data.leader)
                var formAction = "{{route('division.update', ":id")}}";
                formAction = formAction.replace(':id', id);
                $("#form-add-division-data").attr("action", formAction);
            },
        });
    }

</script>
@endsection
