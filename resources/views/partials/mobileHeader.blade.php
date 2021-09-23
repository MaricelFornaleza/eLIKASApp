<div class="c-wrapper">
    <header class="c-header c-header-light c-header-fixed c-header-with-subheader mobile-header">

        <ul class="c-header-nav mr-auto ml-4">

            <li class="c-header-nav-item dropdown"><a class="c-header-nav-link" data-toggle="dropdown" href="#"
                    role="button" aria-haspopup="true" aria-expanded="false">
                    <div class="c-mobile-brand"><img class="c-header-brand"
                            src="{{ url('/assets/brand/Logo-icon-white.svg') }}" height="30px" alt="eLIKAS Logo">
                    </div>
                </a>
                <div class="dropdown-menu dropdown-menu-left pt-0">
                    <div class="dropdown-header bg-light py-2"><strong>Account</strong></div>
                    <a class="dropdown-item" href="/profile">
                        <svg class="c-icon mr-2">
                            <use xlink:href="/assets/icons/coreui/free-symbol-defs.svg#cui-user"></use>
                        </svg> Profile
                    </a>

                    <a class="dropdown-item" href="{{ url('/logout') }}"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit(); Android.logout();">


                        <svg class="c-icon mr-2">
                            <use xlink:href="/assets/icons/coreui/free-symbol-defs.svg#cui-account-logout"></use>
                        </svg>
                        <form id="logout-form" action="{{ url('/logout') }}" method="POST"> @csrf <button type="submit"
                                class="btn btn-ghost-dark btn-block">Logout</button></form>
                    </a>
                </div>
            </li>
        </ul>
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

            <li class="c-header-nav-item "><a class="c-header-nav-link" href="/chat" role="button" aria-haspopup="true"
                    aria-expanded="false">

                    <svg class="c-header-nav-icon c-icon mr-2">
                        <use xlink:href="/assets/icons/coreui/free-symbol-defs.svg#cui-chat-bubble"></use>
                    </svg>
                </a>

            </li>
        </ul>

    </header>