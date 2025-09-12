<nav class="navbar navbar-container">
  <div class="container">
    <a class="nabar-brand" href="{{ route('index') }}">
      <img src="{{ asset('images/web-app-logo.png') }}" class="agency-logo-for-navbar " style="width: 90px; height: 90px;">
    </a>
    <div>
      <a href="{{ route("admin.dashboard") }}" class="text-white text-decoration-none dashboardBtn">{{ __("main.dashboard") }}</a>
      <a href="{{ route("order.index") }}" class="text-white text-decoration-none orderBtn">{{ __("main.orders") }}</a>
      <a href="{{  route("settings.index") }}" class="text-white text-decoration-none orderBtn">{{ __("main.settings") }}</a>
      <button class="btn common-gradient-btn-small" id="logout-btn">{{ __("main.logout") }}</button>
    </div>

  </div>
</nav>