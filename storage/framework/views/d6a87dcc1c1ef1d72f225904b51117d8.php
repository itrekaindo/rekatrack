<div class="sidebar" data-background-color="dark">
  <div class="sidebar-logo">
    <!-- Logo Header -->
    <div class="logo-header" data-background-color="dark">
      <a href="<?php echo e(route('shippings.index')); ?>" class="logo">
        <img
          src="<?php echo e(asset('images/logo/logo-rekatrack.png')); ?>"
          alt="RekaTrack"
          class="navbar-brand"
          height="24"
        />
        <span class="fw-bold text-white ms-2">RekaTrack</span>
      </a>
      <div class="nav-toggle">
        <button class="btn btn-toggle toggle-sidebar d-none d-lg-block">
          <i class="gg-menu-right"></i>
        </button>
        <button class="btn btn-toggle sidenav-toggler d-block d-lg-none">
          <i class="gg-menu-left"></i>
        </button>
      </div>
      <button class="topbar-toggler more d-lg-none">
        <i class="gg-more-vertical-alt"></i>
      </button>
    </div>
    <!-- End Logo Header -->
  </div>
  <div class="sidebar-wrapper scrollbar scrollbar-inner">
    <div class="sidebar-content">
      <ul class="nav nav-secondary">
        <!-- Menu: Manajemen Pengiriman -->
        <li class="nav-item <?php echo e(request()->routeIs('shippings.*') ? 'active' : ''); ?>">
          <a class="nav-link" href="<?php echo e(route('shippings.index')); ?>" title="Manajemen Pengiriman">
            <i class="fas fa-boxes"></i>
            <p>Manajemen Pengiriman</p>
          </a>
        </li>

        <!-- Menu: Manajemen Unit -->
        <li class="nav-item <?php echo e(request()->routeIs('units.*') ? 'active' : ''); ?>">
          <a class="nav-link" href="<?php echo e(route('units.index')); ?>" title="Manajemen Satuan Unit">
            <i class="fas fa-balance-scale"></i>
            <p>Manajemen Unit</p>
          </a>
        </li>

        <!-- Menu: Tracking -->
        <li class="nav-item <?php echo e(request()->routeIs('tracking') ? 'active' : ''); ?>">
          <a class="nav-link" href="<?php echo e(route('tracking')); ?>" title="Tracking">
            <i class="fas fa-map-marked-alt"></i>
            <p>Tracking</p>
          </a>
        </li>

        <!-- Menu: Manajemen User (Only for Super Admin) -->
        <?php if(auth()->check() && auth()->user()->role?->name == 'Super Admin'): ?>
        <li class="nav-section">
          <span class="sidebar-mini-icon">
            <i class="fa fa-ellipsis-h"></i>
          </span>
          <h4 class="text-section">Administrator</h4>
        </li>
        <li class="nav-item <?php echo e(request()->routeIs('users.*') ? 'active' : ''); ?>">
          <a class="nav-link" href="<?php echo e(route('users.index')); ?>" title="Manajemen User">
            <i class="fas fa-users-cog"></i>
            <p>Manajemen User</p>
          </a>
        </li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</div>
<?php /**PATH /home/server/Reka/current-rekatrack/current/resources/views/Template/sidebar.blade.php ENDPATH**/ ?>