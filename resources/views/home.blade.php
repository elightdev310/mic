<!DOCTYPE html>
<html lang="en">

@section('htmlheader')
  @include('mic.layouts.partials.htmlheader')
@show
<body class="sidebar-collapse fixed @hasSection('page_id')@yield('page_id')@endif @hasSection('page_classes')@yield('page_classes')@endif patient-page">


<div class="wrapper">

  <header class="main-header">
  <div class="navbar navbar-default navbar-fixed-top" role="navigation">
    <div class="container"> 
      <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span> 
          </button>
          <a href="{{ url(config('mic.front_url')) }}" class="logo">
            <img class="site-logo" typeof="foaf:Image" src="{{ config('mic.logo_url') }}" alt="{{ LAConfigs::getByKey('sitename') }}">
          </a>
          <div class="logo-slogan hidden-xs">Medical Injury Care Provider Network</div>
      </div>
    </div>
  </div>
  </header>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">

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

  </div><!-- /.content-wrapper -->

</div><!-- ./wrapper -->

@include('mic.layouts.partials.footer')

</body>
</html>
