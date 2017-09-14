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
        </ul>
        <ul class="nav navbar-nav navbar-right">
            <li>
                <a href="{{ route('register') }}" class="navbar-link">Hi {{ auth()->guard('patrons')->user()->first_name }}!</a>
            </li>
        </ul>
    </div>
</nav>