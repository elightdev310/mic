@extends('mic.layouts.modal')

@section('htmlheader_title') HL7 Message View Panel @endsection
@section('contentheader_title') @endsection
@section('page_id')claim-doc-message-view-page @endsection
@section('page_classes')claim-doc-message-page @endsection

@section('content')

@if (isset($invalid_hl7_message))
  <h4 class="text-center">Invalid HL7 Message. It couldn't be parsed.</h4>
@else
  ...
@endif

@endsection
