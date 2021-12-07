<div class="c-wrapper">
    <header class="c-header c-header-light c-header-fixed c-header-with-subheader">
        <button class="c-header-toggler c-class-toggler d-lg-none mr-auto" type="button" data-target="#sidebar"
            data-class="c-sidebar-show"><span class="c-header-toggler-icon"></span></button><a
            class="c-header-brand d-sm-none" href="/home">
            <img class="c-header-brand" src="{{ url('/assets/brand/Logo-icon-blue.svg') }}" height="40"
                alt="eLIKAS Logo"></a>
        <button class="c-header-toggler c-class-toggler ml-3 d-md-down-none" type="button" data-target="#sidebar"
            data-class="c-sidebar-lg-show" responsive="true"><span class="c-header-toggler-icon"></span></button>
        <?php

        use App\MenuBuilder\FreelyPositionedMenus;

        if (isset($appMenus['top menu'])) {
            FreelyPositionedMenus::render(
                $appMenus['top menu'],
                'c-header-',
                'd-md-down-none'
            );
        }
        ?>
        <ul class="c-header-nav ml-auto mr-4">

            <li class="c-header-nav-item dropdown"><a class="c-header-nav-link" data-toggle="dropdown" href="#"
                    role="button" aria-haspopup="true" aria-expanded="false">
                    <div class="c-avatar"><img class="c-avatar-img" src="/public/images/{{Auth::user()->photo}}">
                    </div>
                </a>
                <div class="dropdown-menu dropdown-menu-right pt-0">
                    <div class="dropdown-header bg-light py-2"><strong>Account</strong></div>

                    <a class="dropdown-item" href="/profile">
                        <svg class="c-icon mr-2">
                            <use xlink:href="/assets/icons/coreui/free-symbol-defs.svg#cui-user"></use>
                        </svg> Profile
                    </a>

                    <a class="dropdown-item" href="{{ route('logout') }}"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">

                        <svg class="c-icon mr-2">
                            <use xlink:href="/assets/icons/coreui/free-symbol-defs.svg#cui-account-logout"></use>
                        </svg>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST"> @csrf <button type="submit"
                                class="btn btn-ghost-dark btn-block">Logout</button></form>
                    </a>
                </div>
            </li>
        </ul>

    </header>