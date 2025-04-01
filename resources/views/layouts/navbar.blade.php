<nav class="navbar navbar-container">
  <div class="container">
    <a class="nabar-brand" href="/">
      <svg class="agency-logo-for-navbar mb-3 mt-3" viewBox="0 0 24 24" fill="white">
        <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"></path>
      </svg>
    </a>
    <div> <a href="{{ route("admin.dashboard") }}" class="text-white text-decoration-none dashboardBtn">Dashboard</a>
      <a href="{{ route("order.index") }}" class="text-white text-decoration-none orderBtn">Orders</a>
      <button class="btn common-gradient-btn-small ">Logout</button>
    </div>

  </div>
</nav>