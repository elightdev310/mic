<!DOCTYPE html>
<html lang="en">

@section('htmlheader')
  @include('mic.layouts.partials.htmlheader')
@show
<body class="{{ LAConfigs::getByKey('skin') }} {{ LAConfigs::getByKey('layout') }} sidebar-collapse @hasSection('page_id')@yield('page_id')@endif @hasSection('page_classes')@yield('page_classes')@endif">
<div class="wrapper">
  <div class="modal-content-wrapper">
    @if(!isset($no_header))
      @include('mic.layouts.partials.contentheader')
    @endif
    
    <!-- Main content -->
    <section class="content {{ $no_padding or '' }}">
      @if(!isset($no_message))
      @include('mic.commons.success_error')
      @endif
      <!-- Your Page Content Here -->
      @yield('content')
    </section><!-- /.content -->
  </div><!-- ./modal-content-wrapper -->
</div><!-- ./wrapper -->

@section('scripts')
  @include('mic.layouts.partials.scripts')
@show

</body>
</html>
