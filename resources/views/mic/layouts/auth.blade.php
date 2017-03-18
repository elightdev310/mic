<!DOCTYPE html>
<html lang="en">

@section('htmlheader')
  @include('mic.layouts.partials.auth.htmlheader')
@show
<body class="{{ LAConfigs::getByKey('skin') }} {{ LAConfigs::getByKey('layout') }} sidebar-collapse auth-page">
<div class="wrapper">

  @include('mic.layouts.partials.auth.mainheader')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    @if(LAConfigs::getByKey('layout') == 'layout-top-nav') <div class="container"> @endif

    <!-- Main content -->
    <section class="content {{ $no_padding or '' }}">
      <!-- Your Page Content Here -->
      @yield('content')
    </section><!-- /.content -->

    @if(LAConfigs::getByKey('layout') == 'layout-top-nav') </div> @endif
  </div><!-- /.content-wrapper -->

</div><!-- ./wrapper -->

@include('mic.layouts.partials.footer')

</body>
</html>
