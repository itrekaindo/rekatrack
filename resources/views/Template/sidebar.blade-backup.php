<aside id="sidebar" class="bg-dark text-white position-fixed top-0 start-0 h-100"
  style="width: 250px; z-index: 1000; transition: width 0.3s ease;">
  <div class="p-4">
    <h4 class="mb-4">RekaTrack</h4>
    <ul class="nav flex-column">
      <li class="nav-item">
        <a class="nav-link text-white" href="{{ route('shippings.index') }}" title="Manajemen Pengiriman">
          <i class="bi bi-box-seam me-2"></i>
          <span>Manajemen Pengiriman</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link text-white" href="{{ route('tracking') }}" title="Tracking">
          <i class="bi bi-geo-alt me-2"></i>
          <span>Tracking</span>
        </a>
      </li>
    </ul>
  </div>
</aside>

<style>
  #sidebar.collapsed {
    width: 60px;
  }
  #sidebar.collapsed .nav-link span {
    display: none;
  }
  #sidebar.collapsed .nav-link {
    text-align: center;
    padding: 0.75rem 0.5rem;
  }
  @media (max-width: 768px) {
    #sidebar {
      transform: translateX(-100%);
      transition: transform 0.3s;
    }
    #sidebar.show {
      transform: translateX(0);
    }
  }
</style>
