<!DOCTYPE html>
<html lang="en">

@section('htmlheader')
	@include('mic.layouts.partials.admin.htmlheader')
@show
<body class="{{ LAConfigs::getByKey('skin') }} {{ LAConfigs::getByKey('layout') }} 
					@if(LAConfigs::getByKey('layout') == 'sidebar-mini') sidebar-collapse @endif" 
					bsurl="{{ url('') }}" adminRoute="{{ config('mic.adminRoute') }}">

@include('mic.layouts.partials.admin.preloading')

<div class="wrapper">

	@include('mic.layouts.partials.admin.mainheader')

	@if(LAConfigs::getByKey('layout') != 'layout-top-nav')
		@include('mic.layouts.partials.admin.sidebar')
	@endif

	<!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper">
		@if(LAConfigs::getByKey('layout') == 'layout-top-nav') <div class="container"> @endif
		@if(!isset($no_header))
			@include('mic.layouts.partials.admin.contentheader')
		@endif
		
		<!-- Main content -->
		<section class="content {{ $no_padding or '' }}">
			<!-- Your Page Content Here -->
			@yield('main-content')
		</section><!-- /.content -->

		@if(LAConfigs::getByKey('layout') == 'layout-top-nav') </div> @endif
	</div><!-- /.content-wrapper -->

	@include('mic.layouts.partials.admin.controlsidebar')

	@include('mic.layouts.partials.footer')

</div><!-- ./wrapper -->

@include('mic.layouts.partials.admin.file_manager')

@section('scripts')
	@include('mic.layouts.partials.admin.scripts')
@show

</body>
</html>
