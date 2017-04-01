<!DOCTYPE html>
<html lang="en">

@section('htmlheader')
  @include('mic.layouts.partials.htmlheader')
@show
<body class="{{ LAConfigs::getByKey('skin') }} {{ LAConfigs::getByKey('layout') }} sidebar-collapse @hasSection('page_id')@yield('page_id')@endif @hasSection('page_classes')@yield('page_classes')@endif {{ MICUILayoutHelper::getRoleClass() }} partner-page">
<div class="wrapper">

  @include('mic.layouts.partials.mainheader')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    @if(LAConfigs::getByKey('layout') == 'layout-top-nav') <div class="container"> @endif

    <div class="container">

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
    
    </div><!-- /.container -->

    @if(LAConfigs::getByKey('layout') == 'layout-top-nav') </div> @endif
  </div><!-- /.content-wrapper -->

</div><!-- ./wrapper -->

@include('mic.layouts.partials.footer')

@section('scripts')
  @include('mic.layouts.partials.scripts')
@show

</body>
</html>
