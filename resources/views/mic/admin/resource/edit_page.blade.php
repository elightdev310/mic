@extends('mic.layouts.admin')

@section('htmlheader_title')Edit Resource Page @endsection
@section('contentheader_title')Edit Resource Page @endsection

@section('main-content')
{!! Form::open(['route' =>['micadmin.resource.edit.post', $resource->id], 
                'method'=>'post', 
                'class' =>'resource-page-form']) !!}

<div class="form-group">
  {!! Form::label('title', "Title: ") !!}
  {!! Form::text('title', $resource->title, ['class'=>'form-control page-title']) !!}
</div>
<div class="form-group">
  {!! Form::label('group', "Resource Group: ") !!}
  {!! 
    Form::select('group', 
                  array_merge(array('all'=>'All Users', 'patient'=>'Patient'), config('mic.partner_type')),
                  $ra->group, 
                  ['class' => 'form-control']) 
  !!}
</div>

<div class="resource-body">
  {!! $resource->body !!}
</div>

<div class="resource-submit mt20 text-right">
  {{ Form::textarea('body', null, ['class'=>'hidden resource-body-html']) }}
  <a href="#" class="btn btn-primary save-resource"><span class="pl20 pr20">Save</span></a>
</div>
{!! Form::close() !!}
@endsection

@include("mic.admin.resource.partials.resource_editor")
