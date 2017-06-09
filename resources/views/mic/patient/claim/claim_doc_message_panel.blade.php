@extends('mic.layouts.modal')

@section('htmlheader_title') HL7 Message View Panel @endsection
@section('contentheader_title') @endsection
@section('page_id')claim-doc-message-view-page @endsection
@section('page_classes')claim-doc-message-page @endsection

@section('content')

@if (isset($invalid_hl7_message))
  <div class="p10">
      {!! nl2br($hl7_message) !!}
  </div>
  <h4 class="text-center pt20">Invalid HL7 Message. It couldn't be parsed.</h4>
@else

<div class="claim-doc-message-panel">
  <div class="pb10">
    {!! nl2br($hl7_message) !!}
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
  @foreach($hl7->segmentTypes as $key=>$segment)
  <div class="panel panel-default">
    <div class="panel-heading">
      <h4 class="panel-title">
        <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" data-segment="{{ $key }}" href="#seg-{{$segment->segmentId}}">
          {{ $segment->segmentName }}
        </a>
      </h4>
    </div>
    <div id="seg-{{$segment->segmentId}}" class="panel-collapse collapse">
      <div class="panel-body">
        {{-- @include('mic.patient.claim.partials.doc_message_segment') --}}
      </div>
    </div>
  </div>
  @endforeach
  
  </div>
  
</div> <!-- end container -->
@endif

@endsection

@push('scripts')
<script>
$(function () {
  $('.claim-doc-message-panel a.accordion-toggle').on('click', function() {
    var $this = $(this);
    var $panel = $this.closest('.panel').find('.panel-collapse .panel-body');
    if (!$this.hasClass('loaded')) {
      $this.addClass('loaded');
      $panel.loadingOverlay();

      var segment_index = $this.data('segment');
      var segment_url = '{{ route('claim.doc.view_message_panel.segment', [$doc->claim_id, $doc->id]) }}';
      $.ajax({
        dataType: 'json',
        method: 'GET', 
        url: segment_url,
        data: { segment: segment_index }, 
        success: function ( json ) {
          $panel.loadingOverlay('remove');
          $panel.html(json.segment_html);
        }
      });
    }
  });
});
</script>
@endpush
