@extends('mic.layouts.modal')

@section('htmlheader_title') HL7 Message View Panel @endsection
@section('contentheader_title') @endsection
@section('page_id')claim-doc-message-view-page @endsection
@section('page_classes')claim-doc-message-page @endsection

@section('content')

@if (isset($invalid_hl7_message))
  <h4 class="text-center">Invalid HL7 Message. It couldn't be parsed.</h4>
@else

<div class="claim-doc-message-panel">
  <div class="pb10">
    {!! nl2br($hl7->message) !!}
  </div>
  <div class="pb10">
    <div>
      <label>Message Version:</label> <span>{{ $hl7->messageVersion }}</span>
    </div>
    <div>
      <label>Message Type:</label> <span>{{ $hl7->messageType }}</span>
    </div>
  </div>
  <div class="panel-group" id="accordion">
  @foreach($hl7->segmentTypes as $segment)
  <div class="panel panel-default">
    <div class="panel-heading">
      <h4 class="panel-title">
        <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#seg-{{$segment->segmentId}}">
          {{ $segment->segmentName }}
        </a>
      </h4>
    </div>
    <div id="seg-{{$segment->segmentId}}" class="panel-collapse collapse">
      <div class="panel-body">
        @include('mic.patient.claim.partials.doc_message_segment')
      </div>
    </div>
  </div>
  @endforeach
  
  </div>
  
</div> <!-- end container -->
@endif

@endsection
