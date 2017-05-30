@extends('mic.layouts.admin')

@section('htmlheader_title')New Resource Page @endsection
@section('contentheader_title')New Resource Page @endsection

@section('main-content')
{!! Form::open(['route' =>'micadmin.resource.add.post', 
                'method'=>'post', 
                'class' =>'resource-page-form']) !!}

<div class="form-group">
  {!! Form::label('title', "Title: ") !!}
  {!! Form::text('title', null, ['class'=>'form-control page-title']) !!}
</div>
<div class="form-group">
  {!! Form::label('group', "Resource Group: ") !!}
  {!! 
    Form::select('group', 
                  array_merge(array('all'=>'All Users', 'patient'=>'Patient'), config('mic.partner_type')),
                  null, 
                  ['class' => 'form-control']) 
  !!}
</div>

<div class="resource-body">
  @if (isset($template)) 
    @include("mic.admin.resource.template.".$template)
  @endif
</div>

<div class="resource-submit mt20">
  {{ Form::textarea('body', null, ['class'=>'hidden resource-body-html']) }}
  <a href="#" class="btn btn-primary save-resource">Save</a>
</div>
{!! Form::close() !!}
@endsection

@include("mic.admin.resource.partials.resource_editor")
