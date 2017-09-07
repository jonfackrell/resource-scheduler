<nav class="navbar navbar-default">
    <div class="container">
        <div class="navbar-header">
            <a class="navbar-brand" href="#">
                <img alt="" src="{{ $public->where('name', 'LOGO')->first()->value or '' }}">
            </a>
        </div>
    </div>
</nav>