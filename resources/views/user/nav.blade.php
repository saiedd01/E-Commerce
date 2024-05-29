<header class="">
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand" href="index.html">
                <h2>E-<em>Commerce</em></h2>
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive"
                aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{url("user/product")}}">{{__("message.Home")}}
                            <span class="sr-only">(current)</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{url("MyCart")}}">{{__("message.Cart")}} {{$count}} </a>
                    </li>
                    @if (session()->has('lang')&& session()->get('lang') == "ar")

                    <li class="nav-item">
                        <a class="nav-link" href="{{url("change/en")}}">English</a>
                    </li>
                    @else
                    <li class="nav-item">
                        <a class="nav-link" href="{{url("change/ar")}}">Arabic</a>
                    </li>
                    @endif
                    <li class="nav-item">
                        <a class="nav-link" href="{{url("dashboard")}}">{{__("message.Back")}}</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>