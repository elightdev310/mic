<!DOCTYPE html>
<html lang="en">

@section('htmlheader')
  @include('mic.layouts.partials.auth.htmlheader')
@show
<body class="sidebar-collapse auth-page">
<div class="wrapper">

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <div class="row">
      <div class="col-sm-4 left-sidebar">
        @yield('left_siebar')
      </div>
      <div class="col-sm-8 content">
          @yield('content')
      </div>
    </div>
  </div><!-- /.content-wrapper -->

</div><!-- ./wrapper -->

@section('scripts')
  @include('mic.layouts.partials.scripts_auth')
@show

</body>
</html>
