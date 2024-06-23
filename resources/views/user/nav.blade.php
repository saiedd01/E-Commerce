<style>
    .cart-link {
        position: relative;
        display: inline-block;
    }

    .cart-count {
        position: absolute;
        top: -10px;
        right: -10px;
        background-color: red;
        color: white;
        border-radius: 50%;
        padding: 2px 6px;
        font-size: 12px;
        font-weight: bold;
    }
</style>
<header class="">
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                <h2>E-<em style="font-style: normal;">Commerce</em></h2>
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive"
                aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/') }}">{{ __('message.Home') }}
                            <span class="sr-only">(current)</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link cart-link" href="{{ url('MyCart') }}">
                            Cart
                            @if ($countCart > 0)
                                <span class="cart-count">{{ $countCart }}</span>
                            @endif
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link cart-link" href="{{ url('wishlist') }}">
                            Favourite
                            @if ($countWishlist > 0)
                                <span class="cart-count">{{ $countWishlist }}</span>
                            @endif
                        </a>
                    </li>
                    @if (session()->has('lang') && session()->get('lang') == 'ar')
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('change/en') }}">English</a>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('change/ar') }}">Arabic</a>
                        </li>
                    @endif
                    @if (Route::has('login'))
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Account
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                @auth
                                    {{-- <a class="dropdown-item" href="{{ url('/dashboard') }}">Dashboard</a> --}}
                                    <a class="dropdown-item" href="{{ url('/logout') }}">logout</a>
                                @else
                                    <a class="dropdown-item" href="{{ route('login') }}">Log in</a>
                                    @if (Route::has('register'))
                                        <a class="dropdown-item" href="{{ route('register') }}">Register</a>
                                    @endif
                                @endauth
                            </div>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>
</header>
