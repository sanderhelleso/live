<!-- Nav component -->

<header>
    <nav id="main-navbar" class="navbar is-fixed-top box" role="navigation" aria-label="main navigation">
        <div class="navbar-brand">
            <a class="navbar-item" href="/"><span id="navbar-logo">LIVE</span></a>
            <a role="button" class="navbar-burger" data-target="main-navbar-menu" aria-label="menu" aria-expanded="false">
                <span aria-hidden="true"></span>
                <span aria-hidden="true"></span>
                <span aria-hidden="true"></span>
            </a>
        </div>

        <div id="main-navbar-menu" class="navbar-menu animated fadeIn">
            <div class="navbar-end">
                <div id="nav-user" class="navbar-item has-dropdown is-hoverable">
                    <div id="avatar" class="navbar-item navbar-link">
                        <figure class="image">
                            <img id="user-avatar" class="is-rounded">
                        </figure>
                        <span id="nav-user-name"></span>
                    </div>

                    <div class="navbar-dropdown is-right">
                        <a class="navbar-item" href="/dashboard/settings/settings.php">
                            <i data-feather="settings"></i> Settings
                        </a>
                        <hr class="navbar-divider">
                        <a id="log-out-btn" class="navbar-item">
                            <i data-feather="log-out"></i> Log Out
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </nav>
</header>