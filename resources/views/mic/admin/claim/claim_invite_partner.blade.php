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
      {!! Form::open(['route' => ['micadmin.claim.view.invite_partner', $claim->id], 
            'method'=>'get', 
            'class' =>'frm-search-user']) !!}

      <div class="row">
          <div class="col-sm-4">
              <div id="imaginary_container"> 
                  <div class="input-group stylish-input-group">
                      {!! Form::text('search_txt', Request::get('search_txt'), ['class' => 'form-control', 'placeholder'=>'Search']) !!}
                      <span class="input-group-addon">
                          <button type="submit">
                              <span class="glyphicon glyphicon-search"></span>
                          </button>  
                      </span>
                  </div>
              </div>
          </div>
      </div>

      <div class='row pt10'>
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
      </div>
      {!! Form::close() !!}

      @include('mic.admin.claim.partials.partner_list')
    </div>
  </div>
@endsection
