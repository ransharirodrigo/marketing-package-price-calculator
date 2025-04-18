<nav class="navbar navbar-container">
  <div class="container">
    <a class="nabar-brand" href="/">
      <img src="{{ asset('images/logo.png') }}" class="agency-logo-for-navbar " style="width: 90px; height: 90px;">
    </a>
    <div> <a href="{{ route("admin.dashboard") }}" class="text-white text-decoration-none dashboardBtn">Dashboard</a>
      <a href="{{ route("order.index") }}" class="text-white text-decoration-none orderBtn">Orders</a>
      <button class="btn common-gradient-btn-small" id="logout-btn">Logout</button>
    </div>

  </div>
</nav>