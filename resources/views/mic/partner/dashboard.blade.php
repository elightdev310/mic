@extends('mic.layouts.partner')

@section('htmlheader_title')
  {{ MICUILayoutHelper::getPartnerTypeTitle() }} Dashboard
@endsection

@section('page_id')partner_dashboard @endsection

@section('page_classes')dashboard-page @endsection

@section('content')
<div class="hold-transition dashboard-section">
  <h3 class="text-center">{{ MICUILayoutHelper::getPartnerTypeTitle() }} Dashboard</h3>
  <a class="btn btn-default btn-lg btn-link" href="{{ route('partner.claims')}}">My Cases</a>
  <a class="btn btn-default btn-lg btn-link" href="#">Learning Center</a>
  <a class="btn btn-default btn-lg btn-link" href="#">More</a>

  <br/>
  <a class="btn btn-default btn-lg btn-link" href="{{ url('/logout') }}">Log out</a>
</div>

@endsection
