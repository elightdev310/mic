@extends('mic.layouts.patient')

@section('htmlheader_title')
  Dashboard (Patient) 
@endsection

@section('page_id')patient_dashboard @endsection

@section('page_classes')dashboard-page @endsection

@section('content')
<div class="hold-transition dashboard-section">
  <h3 class="text-center">Patient Dashboard</h3>
  <a class="btn btn-primary btn-lg btn-link" href="{{ route('patient.claim.create') }}">Create A Claim</a>
  <a class="btn btn-primary btn-lg btn-link" href="{{ route('patient.myclaims') }}">My Claim</a>
  <a class="btn btn-default btn-lg btn-link" href="#">Learning Center</a>
  <a class="btn btn-default btn-lg btn-link" href="#">More</a>
  <br/>
  <a class="btn btn-default btn-lg btn-link" href="{{ url('/logout') }}">Log out</a>
</div>
@endsection
