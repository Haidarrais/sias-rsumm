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
@section('content')
<!-- Main Content -->
<<<<<<< HEAD
<div class="row">
    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
      <div class="card card-statistic-1">
        <div class="card-icon bg-primary">
          <i class="fas fa-inbox"></i>
        </div>
        <div class="card-wrap">
          <div class="card-header">
            <h4>Surat Masuk</h4>
          </div>
          <div class="card-body">
            {{$inboxes->count()}}
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
      <div class="card card-statistic-1">
        <div class="card-icon bg-danger">
          <i class="far fa-paper-plane"></i>
        </div>
        <div class="card-wrap">
          <div class="card-header">
            <h4>Surat Keluar</h4>
          </div>
          <div class="card-body">
            0
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
      <div class="card card-statistic-1">
        <div class="card-icon bg-warning">
          <i class="far fa-file"></i>
        </div>
        <div class="card-wrap">
          <div class="card-header">
            <h4>Tipe Surat</h4>
          </div>
          <div class="card-body">
            {{$types->count()}}
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
      <div class="card card-statistic-1">
        <div class="card-icon bg-success">
          <i class="fas fa-circle"></i>
        </div>
        <div class="card-wrap">
          <div class="card-header">
            <h4>Jumlah Unit</h4>
          </div>
          <div class="card-body">
            39
          </div>
=======


<div class="section-body">
  <h2 class="section-title">Selamat datang di Aplikasi SIAS RS UMM</h2>
  <p class="section-lead">Anda login sebagai {{Auth::user()->name}}!</p>
  <div class="card">
    <div class="card-header">
      <h4>Ringkasan Data Surat</h4>
    </div>
    <div class="card-body d-flex justify-content-around">
      <div class="d-flex align-items-center ">
        <div class="rounded-circle bg-primary  p-2"><i style="font-size: 25px;" class="fas fa-inbox text-white"></i></div>
        <div class="d-flex flex-column justify-content-start ml-2">
          <!-- <div> -->
          <p class="lead pb-0 mb-0 font-weight-bold text-primary"><?= $inbox ?></p>
          <!-- </div> -->
          <div>Surat Masuk</div>
        </div>
      </div>
      <div class="d-flex align-items-center ">
        <div class="rounded-circle bg-primary" style="padding:.5rem .7rem">
          <i style="font-size: 25px;" class="fab fa-telegram-plane text-white"></i>
        </div>
        <div class="d-flex flex-column justify-content-start ml-2">
          <!-- <div> -->
          <p class="lead pb-0 mb-0 font-weight-bold text-primary"><?= $inbox ?></p>
          <!-- </div> -->
          <div>Surat Keluar</div>
>>>>>>> c283be542b2a32daa0e33716d79c08c47751f79a
        </div>
      </div>
      @hasrole('sekertaris')
      <div class="d-flex align-items-center ">
        <div class="rounded-circle bg-primary p-2" >
          <i style="font-size: 25px;" class="fas fa-comments text-white"></i>
        </div>
        <div class="d-flex flex-column justify-content-start ml-2">
          <!-- <div> -->
          <p class="lead pb-0 mb-0 font-weight-bold text-primary"><?= $outbox ?></p>
          <!-- </div> -->
          <div>Memo</div>
        </div>
      </div>
      @else
      @endhasrole

    </div>
<<<<<<< HEAD
  </div>
@endsection
=======
   
  </div>
</div>
@endsection
>>>>>>> c283be542b2a32daa0e33716d79c08c47751f79a
