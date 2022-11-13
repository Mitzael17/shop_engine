<aside>
    <div class="logo"><a href="<?= PATH ?>"><img src="<?=$this->getImg('logo.png', true)?>" alt="logo"></a></div>
    <div class="aside-content">
        <a href="<?= PATH . $this->routes['alias'] . '/show'?>" class="nav-block">
            <span class="icon icon-sidebar">
                <svg><use href="<?=$this->getImg('adminImg/')?>/icons/icons.svg#home"></use></svg>
            </span>
            <span class="item-text item-nav">Dashboard</span>
        </a>
        <div href="#" class="nav-block spoiler">
            <span class="icon icon-sidebar">
                <svg><use href="<?=$this->getImg('adminImg/')?>/icons/icons.svg#menu"></use></svg>
            </span>
            <span class="item-text item-nav">Bot menu</span>
            <span class="icon icon-sidebar icon-sidebar--narrow"><svg><use href="<?=$this->getImg('adminImg/')?>/icons/icons.svg#spoiler_narrow"></use></svg></span>
            <div class="spoiler-container">
                <div class="spoiler-content">
                    <a href="<?= PATH . $this->routes['alias'] . '/show/database/coupons'?>" class="item-text item-nav">Coupons</a>
                    <a href="<?= PATH . $this->routes['alias'] . '/admins'?>" class="item-text item-nav">Admins</a>
                    <a href="<?= PATH . $this->routes['alias'] . '/show/database/admin_roles'?>" class="item-text item-nav">Roles</a>
                </div>
            </div>
        </div>
        <div class="nav-block spoiler">
            <span class="icon icon-sidebar">
                <svg><use href="<?=$this->getImg('adminImg/')?>/icons/icons.svg#settings"></use></svg>
            </span>
            <span class="item-text item-nav">Settings</span>
            <div class="icon icon-sidebar icon-sidebar--narrow"><svg><use href="<?=$this->getImg('adminImg/')?>/icons/icons.svg#spoiler_narrow"></use></svg></div>
            <div class="spoiler-container">
                <div class="spoiler-content">
                    <a href="#" class="item-text item-nav">ON / OFF</a>
                    <a href="<?= PATH . $this->routes['alias'] . '/show/template' ?>" class="item-text item-nav">Template</a>
                    <a href="#" class="item-text item-nav">Manage Trigger</a>
                </div>
            </div>
        </div>
        <a href="<?= PATH . 'admin/show/database' ?>" class="nav-block">
            <span class="icon icon-sidebar">
                <svg><use href="<?=$this->getImg('adminImg/')?>/icons/icons.svg#db"></use></svg>
            </span>
            <span class="item-text item-nav">Database</span>
        </a>
        <a href="<?= PATH . 'admin/logs'?>" class="nav-block">
            <span class="icon icon-sidebar">
                <svg><use href="<?=$this->getImg('adminImg/')?>/icons/icons.svg#logs"></use></svg>
            </span>
            <span class="item-text item-nav">Logs</span>
        </a>
    </div>
</aside>