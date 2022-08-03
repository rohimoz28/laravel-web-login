<nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
  <div class="position-sticky pt-3 sidebar-sticky">
    <ul class="nav flex-column">
      <li class="nav-item">
        <a class="nav-link {{ Request::is('user') ? 'active' : '' }}" aria-current="page" href="/user">
          <span data-feather="home" class="align-text-bottom"></span>
          Dashboard
        </a>
      </li>
    </ul>

    <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted text-uppercase">
      <span>Settings</span>
    </h6>
    <ul class="nav flex-column mb-2">
      <li class="nav-item">
        <a class="nav-link {{ Request::is('user/profile/*') ? 'active' : '' }}" href="/user/profile/{{ auth()->user()->id }}">
          <span data-feather="file-text" class="align-text-bottom"></span>
          Edit Profile
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link {{ Request::is('user/password/*') ? 'active' : '' }}" href="/user/password/{{ auth()->user()->id }}">
          <span data-feather="file-text" class="align-text-bottom"></span>
          Change Password
        </a>
      </li>
    </ul>
  </div>
</nav>
