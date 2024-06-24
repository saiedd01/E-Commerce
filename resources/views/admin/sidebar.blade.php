 <!-- partial:partials/_sidebar.html -->
 <div class="container-scroller">
     <nav class="sidebar sidebar-offcanvas" id="sidebar">
         <div class="sidebar-brand-wrapper d-none d-lg-flex align-items-center justify-content-center fixed-top">
             <a class="sidebar-brand brand-logo" href="index.html"><img src="{{ asset('admin/assets') }}/images/logo.svg"
                     alt="logo" /></a>
             <a class="sidebar-brand brand-logo-mini" href="index.html"><img
                     src="{{ asset('admin/assets') }}/images/logo-mini.svg" alt="logo" /></a>
         </div>
         <ul class="nav">
             <li class="nav-item profile">
                 <div class="profile-desc">
                     <div class="profile-pic">
                         <div class="count-indicator">
                             <img class="img-xs rounded-circle "
                                 src="{{ asset('admin/assets') }}/images/faces/face15.jpg" alt="">
                             <span class="count bg-success"></span>
                         </div>
                         <div class="profile-name">
                             <h5 class="mb-0 font-weight-normal">
                                 {{ Auth::user()->name }}
                             </h5>
                         </div>
                     </div>
                     <a href="#" id="profile-dropdown" data-toggle="dropdown"><i
                             class="mdi mdi-dots-vertical"></i></a>
                     <div class="dropdown-menu dropdown-menu-right sidebar-dropdown preview-list"
                         aria-labelledby="profile-dropdown">
                         <a href="#" class="dropdown-item preview-item">
                             <div class="preview-thumbnail">
                                 <div class="preview-icon bg-dark rounded-circle">
                                     <i class="mdi mdi-settings text-primary"></i>
                                 </div>
                             </div>
                             <div class="preview-item-content">
                                 <p class="preview-subject ellipsis mb-1 text-small">
                                     {{ __('message.Account settings') }}</p>
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
                                 <p class="preview-subject ellipsis mb-1 text-small">{{ __('message.Change Password') }}
                                 </p>
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
                                 <p class="preview-subject ellipsis mb-1 text-small">{{ __('message.To-do list') }}</p>
                             </div>
                         </a>
                     </div>
                 </div>
             </li>
             <li class="nav-item nav-category">
                 <span class="nav-link">Navigation</span>
             </li>
             <li class="nav-item menu-items">
                 <a class="nav-link" href="{{ url('redirect') }}">
                     <span class="menu-icon">
                         <i class="mdi mdi-speedometer"></i>
                     </span>
                     <span class="menu-title">{{ __('message.Dashboard') }}</span>
                 </a>
             </li>
             <li class="nav-item menu-items">
                 <a class="nav-link" href="#" data-toggle="collapse" aria-expanded="false"
                     data-target="#productsDropdown" aria-controls="productsDropdown">
                     <span class="menu-icon">
                         <i class="fas fa-box-open text-primary"></i>
                     </span>
                     <span class="menu-title">Products</span>
                     <i class="menu-arrow"></i>
                 </a>
                 <div class="collapse" id="productsDropdown">
                     <ul class="nav flex-column sub-menu">
                         <li class="nav-item">
                             <a class="nav-link" href="{{ url('products') }}">All Products</a>
                         </li>
                         <li class="nav-item">
                             <a class="nav-link" href="{{ url('products/create') }}">Add Product</a>
                         </li>
                         <li class="nav-item">
                             <a class="nav-link" href="{{ url('archive/products') }}">Archive</a>
                         </li>
                     </ul>
                 </div>
             </li>
             <li class="nav-item menu-items">
                 <a class="nav-link" href="#" data-toggle="collapse" aria-expanded="false"
                     data-target="#categoriesDropdown" aria-controls="categoriesDropdown">
                     <span class="menu-icon">
                         <i class="fas fa-tags text-success"></i>
                     </span>
                     <span class="menu-title">Categories</span>
                     <i class="menu-arrow"></i>
                 </a>
                 <div class="collapse" id="categoriesDropdown">
                     <ul class="nav flex-column sub-menu">
                         <li class="nav-item">
                             <a class="nav-link" href="{{ url('categories') }}">All Categories</a>
                         </li>
                         <li class="nav-item">
                             <a class="nav-link" href="{{ url('categories/create') }}">Add Category</a>
                         </li>
                     </ul>
                 </div>
             </li>
             <li class="nav-item menu-items">
                 <a class="nav-link" href="{{ url('allUsers') }}">
                     <span class="menu-icon">
                         <i class="fas fa-user-friends" style="color: #0fd7bf;"></i>
                     </span>
                     <span class="menu-title">Users</span>
                 </a>
             </li>
             <li class="nav-item menu-items">
                 <a class="nav-link" href="{{ url('product/AllOrder') }}">
                     <span class="menu-icon">
                         <i class="fas fa-clipboard-list" style="color: #cbbb0b;"></i>
                     </span>
                     <span class="menu-title">All Orders</span>
                 </a>
             </li>
         </ul>
     </nav>
