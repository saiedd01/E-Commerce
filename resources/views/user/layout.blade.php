@include('user.head')

    <!-- ***** Preloader Start ***** -->
    <div id="preloader">
        <div class="jumper">
            <div></div>
            <div></div>
            <div></div>
        </div>
    </div>
    <!-- ***** Preloader End ***** -->

    <!-- Nav -->
    @include('user.nav')

    <!-- Page Content -->
    <!-- Banner Starts Here -->
    @include("user.banner")
    <!-- Banner Ends Here -->

    @yield('latest')
    {{-- @include("user.latest") --}}

    @include("user.about")


    @include("user.footer")
