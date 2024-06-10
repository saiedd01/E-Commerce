@include('admin.head')


        <!-- partial:partials/_sidebar.html -->
        @include('admin.sidebar')
    {{-- </div> --}}
        <!-- partial -->

        <!-- partial:partials/_navbar.html -->
        @include('admin.navbar')
      {{-- </div> --}}
        <!-- partial -->
    <div class="main-panel">
          {{-- @include('admin.body') --}}
          @yield('body')
        {{-- </div> --}}
          <!-- content-wrapper ends -->
@include('admin.footer')
