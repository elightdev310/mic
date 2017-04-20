@extends('mic.layouts.modal')

@section('htmlheader_title') Invite Partner @endsection
@section('contentheader_title')Invite Partner @endsection
@section('page_id')invite-partner-page @endsection
@section('page_classes')invite-partner @endsection

@section('content')
  <div class="panel partner-list">
    <div class="panel-default panel-heading">
      <h4>Partners</h4>
    </div>
    <div class="panel-body">
      <div class='row'>
        {!! Form::open(['route' => ['micadmin.claim.view.invite_partner', $claim->id], 
            'method'=>'get', 
            'class' =>'frm-search-user']) !!}

          <div class='form-group col-sm-4'>
              {!! 
                Form::select('partner_type', 
                              config('mic.partner_type'),
                              Request::get('partner_type'), 
                              ['class' => 'form-control', 'placeholder' => '- All Partners -']) 
              !!}
          </div>
          <div class='form-group col-sm-4'>
              {!! Form::submit('Filter', ['class'=>'btn btn-primary']) !!}
          </div>
        {!! Form::close() !!}
      </div>

      @include('mic.admin.claim.partials.partner_list')
    </div>
  </div>
@endsection
