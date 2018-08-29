<nav class="navbar navbar-default">
    <div class="container">
        <div class="navbar-header">
            <a class="navbar-brand" href="/">
                <img alt="" src="{{ $public->where('name', 'LOGO')->first()->value or '' }}" style="height: 28px; width: auto;">
            </a>

        </div>
        <ul class="nav navbar-nav">
            <li>
                <a href="{{ route('printers') }}" class="navbar-link">3D Printers</a>
            </li>
            <li>
                <a href="{{ route('options') }}" class="navbar-link">Upload</a>
            </li>
            <li>
                <a href="{{ route('history') }}" class="navbar-link">View History</a>
            </li>
            <li>
                <a href="{{ route('policy') }}" class="navbar-link">Policy</a>
            </li>
            <li>
                <a href="{{ route('contact') }}" class="navbar-link">Contact Us</a>
            </li>
        </ul>
        @if(auth()->guard('patrons')->check())
            <ul class="nav navbar-nav navbar-right">
                <li>
                    <a href="{{ route('register') }}" class="navbar-link">Hi {{ auth()->guard('patrons')->user()->first_name }}!</a>
                </li>
                <li>
                    <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">{{ __('Logout') }}</a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        {{ csrf_field() }}
                    </form>
                </li>
            </ul>
        @endif
    </div>
</nav>