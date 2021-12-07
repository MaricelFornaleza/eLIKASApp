<div class="c-wrapper">
    <header class="c-header c-header-light c-header-fixed c-header-with-subheader mobile-header">

        <ul class="c-header-nav mr-auto ml-4">

            <a class="c-header-nav-link" href="/home" role="button" aria-haspopup="true" aria-expanded="false">
                <div class="c-mobile-brand"><img class="c-header-brand"
                        src="{{ url('/assets/brand/Logo-icon-white.svg') }}" height="30px" alt="eLIKAS Logo">
                </div>
            </a>

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


    </header>