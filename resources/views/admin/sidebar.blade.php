 <!-- partial:partials/_sidebar.html -->
 <div class="container-scroller">
 <nav class="sidebar sidebar-offcanvas" id="sidebar">
    <div class="sidebar-brand-wrapper d-none d-lg-flex align-items-center justify-content-center fixed-top">
      <a class="sidebar-brand brand-logo" href="index.html"><img src="{{asset("admin/assets")}}/images/logo.svg" alt="logo" /></a>
      <a class="sidebar-brand brand-logo-mini" href="index.html"><img src="{{asset("admin/assets")}}/images/logo-mini.svg" alt="logo" /></a>
    </div>
    <ul class="nav">
      <li class="nav-item profile">
        <div class="profile-desc">
          <div class="profile-pic">
            <div class="count-indicator">
              <img class="img-xs rounded-circle " src="{{asset("admin/assets")}}/images/faces/face15.jpg" alt="">
              <span class="count bg-success"></span>
            </div>
            <div class="profile-name">
              <h5 class="mb-0 font-weight-normal">Henry Klein</h5>
              <span>Gold Member</span>
            </div>
          </div>
          <a href="#" id="profile-dropdown" data-toggle="dropdown"><i class="mdi mdi-dots-vertical"></i></a>
          <div class="dropdown-menu dropdown-menu-right sidebar-dropdown preview-list" aria-labelledby="profile-dropdown">
            <a href="#" class="dropdown-item preview-item">
              <div class="preview-thumbnail">
                <div class="preview-icon bg-dark rounded-circle">
                  <i class="mdi mdi-settings text-primary"></i>
                </div>
              </div>
              <div class="preview-item-content">
                <p class="preview-subject ellipsis mb-1 text-small">{{__("message.Account settings")}}</p>
              </div>
            </a>
            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item preview-item">
              <div class="preview-thumbnail">
                <div class="preview-icon bg-dark rounded-circle">
                  <i class="mdi mdi-onepassword  text-info"></i>
                </div>
              </div>
              <div class="preview-item-content">
                <p class="preview-subject ellipsis mb-1 text-small">{{__("message.Change Password")}}</p>
              </div>
            </a>
            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item preview-item">
              <div class="preview-thumbnail">
                <div class="preview-icon bg-dark rounded-circle">
                  <i class="mdi mdi-calendar-today text-success"></i>
                </div>
              </div>
              <div class="preview-item-content">
                <p class="preview-subject ellipsis mb-1 text-small">{{__("message.To-do list")}}</p>
              </div>
            </a>
          </div>
        </div>
      </li>
      <li class="nav-item nav-category">
        <span class="nav-link">Navigation</span>
      </li>
      <li class="nav-item menu-items">
        <a class="nav-link" href="{{url("redirect")}}">
          <span class="menu-icon">
            <i class="mdi mdi-speedometer"></i>
          </span>
          <span class="menu-title">{{__('message.Dashboard')}}</span>
        </a>
      </li>
      <li class="nav-item menu-items">
        <a class="nav-link" href="{{url("products")}}">
          <span class="menu-icon">
            <i class="text-primary fas fa-eye"></i>
          </span>
          <span class="menu-title">{{__("message.All Products")}}</span>
        </a>
      </li>
      <li class="nav-item menu-items">
        <a class="nav-link" href="{{url("products/create")}}">
            <span class="menu-icon">
                <i class="text fas fa-plus" style="color: #0fb839;"></i>
            </span>
          <span class="menu-title">{{__("message.Add Product")}}</span>
        </a>
      </li>
      <li class="nav-item menu-items">
        <a class="nav-link" href="{{url("archive/products")}}">
          <span class="menu-icon">
            <i class="text-danger fas fa-trash-alt"></i>
          </span>
          <span class="menu-title">Archive</span>
        </a>
      </li>
      <li class="nav-item menu-items">
        <a class="nav-link" href="{{url("categories")}}">
          <span class="menu-icon">
            <i class="text-primary fas fa-eye"></i>
          </span>
          <span class="menu-title">{{__("message.All Categoires")}}</span>
        </a>
      </li>
      <li class="nav-item menu-items">
        <a class="nav-link" href="{{url("categories/create")}}">
          <span class="menu-icon">
            <i class="text fas fa-plus" style="color: #0fb839;"></i>
          </span>
          <span class="menu-title">{{__("message.Add Category")}}</span>
        </a>
      </li>
      <li class="nav-item menu-items">
        <a class="nav-link" href="{{url("allUsers")}}">
          <span class="menu-icon">
            <i class="fa-solid fa-user" style="color: #0fd7bf;"></i>
          </span>
          <span class="menu-title">Users</span>
        </a>
      </li>
    </ul>
  </nav>
