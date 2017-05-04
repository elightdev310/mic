<div class="auth-mic-left-bg">
  <div class="logo-section">
    <a href="{{ url(config('mic.front_url')) }}" class="logo">
      <img class="site-logo" typeof="foaf:Image" src="{{ asset('assets/img/logo-big.png') }}" alt="{{ LAConfigs::getByKey('sitename') }}">    
    </a>
    <div class="slogan">
      Accident Injury Care When You Need It
    </div>
  </div>

  <div class="text-center pt30">
    <a href="{{ $sign_up_url or route('signup') }}" class="btn btn-primary btn-sign-up btn-lg">Free Sign Up</a>
  </div>
</div>
