@extends('mic.layouts.'.$layout)

@section('htmlheader_title') {{ $resource->title }} @endsection
@section('contentheader_title')@endsection

@section('content')
<!-- Main content -->
<div class="resource-title">
  <h2>{{ $resource->title }}</h2>
</div>
<div class="resource-body">
  {!! $resource->body !!}
</div>

@endsection

@push('scripts')
<script type="text/javascript">
  $(function () {
    $('.resource-body').find('.resource-block-section').each(function() {
      $html = $(this).html();
      $(this).parent().html($html);
    });
  });
</script>
@endpush
