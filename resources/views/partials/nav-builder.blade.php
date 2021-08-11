<?php
/*
    $data = $menuel['elements']
*/

if (!function_exists('renderDropdown')) {
    function renderDropdown($data)
    {
        if (array_key_exists('slug', $data) && $data['slug'] === 'dropdown') {
            echo '<li class="c-sidebar-nav-dropdown">';
            echo '<a class="c-sidebar-nav-dropdown-toggle" href="#">';
            if ($data['hasIcon'] === true && $data['iconType'] === 'coreui') {
                echo '<i class="' . $data['icon'] . ' c-sidebar-nav-icon"></i>';
            }
            echo $data['name'] . '</a>';
            echo '<ul class="c-sidebar-nav-dropdown-items">';
            renderDropdown($data['elements']);
            echo '</ul></li>';
        } else {
            for ($i = 0; $i < count($data); $i++) {
                if ($data[$i]['slug'] === 'link') {
                    echo '<li class="c-sidebar-nav-item">';
                    echo '<a class="c-sidebar-nav-link" href="' .
                        url($data[$i]['href']) .
                        '">';
                    echo '<span class="c-sidebar-nav-icon"></span>' .
                        $data[$i]['name'] .
                        '</a></li>';
                } elseif ($data[$i]['slug'] === 'dropdown') {
                    renderDropdown($data[$i]);
                }
            }
        }
    }
} ?>

<html>

<head>
    <script type="text/javascript">
        function refreshTime() {
            var refresh = 1000;
            mytime = setTimeout('display_dateTime()', refresh);
        }

        function display_dateTime() {
            var date = new Date();
            document.getElementById("time").innerHTML = date.toLocaleTimeString();
            refreshTime();
        }
    </script>
</head>

<body onload="display_dateTime();">
    <div class="c-sidebar-brand" onload=display_dateTime();>
        <img class="c-sidebar-brand-full" src="{{ url('/assets/brand/Logo-horizontal-white.svg') }}" height="25" alt="eLIKAS Logo">
        <img class="c-sidebar-brand-minimized" src="{{ url('assets/brand/Logo-icon-white.svg') }}" height="25" alt="eLIKAS Logo">
    </div>
    <div class="sidebar-date">
        <h1 id="time"></h1>
        <h6><?php echo \Carbon\Carbon::now()->format('l, F d, Y'); ?></h6>


    </div>
    <ul class="c-sidebar-nav">
        <li class="c-sidebar-nav-item">
            <a class="c-sidebar-nav-link" href="/home">
                <svg class="c-sidebar-nav-icon">
                    <use xlink:href="/assets/icons/coreui/free-symbol-defs.svg#cui-home"></use>
                </svg>Home
            </a>
        </li>
        <li class="c-sidebar-nav-item">
            <a class="c-sidebar-nav-link" href="/map">
                <svg class="c-sidebar-nav-icon">
                    <use xlink:href="/assets/icons/coreui/free-symbol-defs.svg#cui-home"></use>
                </svg>Map
            </a>
        </li>
        <li class="c-sidebar-nav-item">
            <a class="c-sidebar-nav-link" href="/evacuation-centers">
                <svg class="c-sidebar-nav-icon">
                    <use xlink:href="/assets/icons/coreui/free-symbol-defs.svg#cui-home"></use>
                </svg>Evacuation Centers
            </a>
        </li>
        <li class="c-sidebar-nav-item">
            <a class="c-sidebar-nav-link" href="#">
                <svg class="c-sidebar-nav-icon">
                    <use xlink:href="/assets/icons/coreui/free-symbol-defs.svg#cui-home"></use>
                </svg>Field Officers
            </a>
        </li>
        <li class="c-sidebar-nav-item">
            <a class="c-sidebar-nav-link" href="#">
                <svg class="c-sidebar-nav-icon">
                    <use xlink:href="/assets/icons/coreui/free-symbol-defs.svg#cui-home"></use>
                </svg>Requests
            </a>
        </li>
        <li class="c-sidebar-nav-item">
            <a class="c-sidebar-nav-link" href="#">
                <svg class="c-sidebar-nav-icon">
                    <use xlink:href="/assets/icons/coreui/free-symbol-defs.svg#cui-home"></use>
                </svg>Residents
            </a>
        </li>
        <li class="c-sidebar-nav-item">
            <a class="c-sidebar-nav-link" href="#">
                <svg class="c-sidebar-nav-icon">
                    <use xlink:href="/assets/icons/coreui/free-symbol-defs.svg#cui-home"></use>
                </svg>Inventory
            </a>
        </li>
        <li class="c-sidebar-nav-item">
            <a class="c-sidebar-nav-link" href="#">
                <svg class="c-sidebar-nav-icon">
                    <use xlink:href="/assets/icons/coreui/free-symbol-defs.svg#cui-home"></use>
                </svg>Chat
            </a>
        </li>

    </ul>
    <button class="c-sidebar-minimizer c-class-toggler" type="button" data-target="_parent" data-class="c-sidebar-minimized"></button>
    </div>

</body>

</html>