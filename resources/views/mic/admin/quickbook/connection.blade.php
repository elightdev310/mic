@extends('mic.layouts.admin')

@section('htmlheader_title') Quickbooks Connection @endsection
@section('contentheader_title')@endsection

@section('main-content')
<!-- Main content -->
<?php
  $qbo_obj = new \App\Http\Controllers\MIC\QuickBookController();
  $qbo_connect = $qbo_obj->qboConnect();
?>
@if(!$qbo_connect)
<ipp:connectToIntuit></ipp:connectToIntuit>
@else
<a href="{{url('admin/qbo/disconnect')}}" title="">Disconnect</a>
@endif
@endsection

@push('scripts')
<script type="text/javascript" src="https://appcenter.intuit.com/Content/IA/intuit.ipp.anywhere.js"></script>
  <script type="text/javascript">
   intuit.ipp.anywhere.setup({
    menuProxy: '<?php print(env('QBO_MENU_URL')); ?>',
    grantUrl: '<?php print(env('QBO_OAUTH_URL')); ?>'
   });
</script>
@endpush
