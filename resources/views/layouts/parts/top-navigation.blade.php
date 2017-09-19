<!-- top navigation -->
<div class="top_nav">
    <div class="nav_menu">
        <nav>
            <div class="nav toggle">
                <a id="menu_toggle"><i class="fa fa-bars"></i></a>
            </div>

            <ul class="nav navbar-nav navbar-right">
                <li class="">
                    {!! BootForm::open()->action(route('logout'))->post() !!}
                    {!! BootForm::submit('Logout')->class('btn btn-danger')->style('margin-top: 12px;') !!}
                    {!! BootForm::close() !!}
                </li>
                <li class="">
                    <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                        @if(!auth()->guard('web')->guest())
                            Hi {{ auth()->guard('web')->user()->first_name }} {{ auth()->guard('web')->user()->last_name }}!
                        @endif
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</div>
<!-- /top navigation -->