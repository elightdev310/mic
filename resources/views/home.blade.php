<!DOCTYPE html>
<html lang="en">

@section('htmlheader')
  @include('mic.layouts.partials.htmlheader')
@show
<body class="{{ LAConfigs::getByKey('skin') }} {{ LAConfigs::getByKey('layout') }} sidebar-collapse @hasSection('page_id')@yield('page_id')@endif @hasSection('page_classes')@yield('page_classes')@endif patient-page">


<div class="wrapper">

  <header class="main-header">
    <!-- Logo -->
    <div class="container">
      <a href="{{ url(config('mic.front_url')) }}" class="logo">
        <img class="site-logo" typeof="foaf:Image" src="{{ config('mic.logo_url') }}" alt="{{ LAConfigs::getByKey('sitename') }}">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini"><b>{{ LAConfigs::getByKey('sitename_short') }}</b></span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg"><b>{{ LAConfigs::getByKey('sitename_part1') }}</b>
        {{ LAConfigs::getByKey('sitename_part2') }}</span>
      </a>
    </div>

  </header>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    @if(LAConfigs::getByKey('layout') == 'layout-top-nav') <div class="container"> @endif

    <!-- Main content -->
    <section class="content {{ $no_padding or '' }}">
      <!-- Your Page Content Here -->
      
      <div class="row" style="margin-top: 100px;">
        <div class="col-sm-6 text-center">
          <a class="btn btn-primary btn-lg" href="{{ url('/login/patient') }}">Log in as Patient</a>
        </div>
        <div class="col-sm-6 text-center">
          <a class="btn btn-primary btn-lg" href="{{ url('/login/partner') }}">Log in as others</a>
        </div>
      </div>

    </section><!-- /.content -->

    @if(LAConfigs::getByKey('layout') == 'layout-top-nav') </div> @endif
  </div><!-- /.content-wrapper -->

  @include('mic.layouts.partials.footer')

</div><!-- ./wrapper -->

</body>
</html>
