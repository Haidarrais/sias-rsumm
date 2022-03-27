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
Unit / Divisi
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
        <div class="card-body p-2">
            <div class="table-responsive">
                <table class="table table-striped table-md">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Unit</th>
                            <th>Kode</th>
                            @role('admin')
                            <th style="text-align: center">Action</th>
                            @endrole
                        </tr>
                    <tbody>
                        </thead>
                        @foreach ($divisions as $key => $division)
                        <tr>
                            <td>{{$key+1}}</td>
                            <td>{{$division->name}}</td>
                            <td>{{$division->leader}}</td>
                            <td class="text-center">
                                @role('admin')
                                <form action="{{ route('division.destroy', $division->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <div class="btn-group" role="group" aria-label="Basic example">
                                        <button type="button" class="btn btn-warning"
                                            onclick="setIndex({{$division->id}})"><i class="far fa-edit"></i></button>
                                        <button type="submit" class="btn btn-danger"><i
                                                class="far fa-trash-alt"></i></button>
                                    </div>
                                </form>
                                @endrole
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
<div class="modal fade" id="modal_tambah" tabindex="-1" role="dialog" aria-labelledby="modal_tambah" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal_title">Tambah Divisi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{route('division.store')}}" method="POST" id="form-add-division-data"
                enctype="multipart/form-data">
                <input type="text" name="_method" id="form_method" value="POST" hidden>
                @csrf
                <div class="modal-body row">
                    <div class="form-group col-md-6">
                        <label for="">Nama Unit</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                            value="{{old('name')}}" id="form_name">
                        @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group col-md-6">
                        <label for="">Kode</label>
                        <input type="text" class="form-control @error('leader') is-invalid @enderror" name="leader"
                            value="{{old('leader')}}" id="form_leader">
                        @error('leader')
                        <span class="invalid-feedback" role="alert">
                            <strong>The Code field is required</strong>
                        </span>
                        @enderror
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
@if($errors->any())
<script>
    $(document).ready(function() {
        $('#modal_tambah').modal('show');
    });
</script>
@endif
<script>
    $(document).ready(function() {
        $('.table').DataTable();
    } );
</script>
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
