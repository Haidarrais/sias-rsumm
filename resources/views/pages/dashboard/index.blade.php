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
          <p class="lead pb-0 mb-0 font-weight-bold text-primary"><?= $outbox ?></p>
          <!-- </div> -->
          <div>Surat Keluar</div>
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

  </div>
</div>
@endsection
