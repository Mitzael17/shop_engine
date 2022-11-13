<div class="body-container">
    <header class="sbc">
        <div class="f-block search">
            <form class="no-default-form" id="search" style="width: 100%;" action="#">
                <div class="search-block">
                    <input type="text" autocomplete="off" name="search" placeholder="Type to search">
                    <div class="hints-wrapper">
                        <div class="hints c-scroll"></div>
                    </div>
                </div>
            </form>
        </div>
        <div class="f-block">
            <a class="icon icon-header bell" href="#">
                <svg><use href="<?=$this->getImg('adminImg/')?>icons/icons.svg#bell"></use></svg>
                <div class="number-messages">3</div>
            </a>
            <a class="icon icon-header message" href="<?= PATH . $this->routes['alias'] . '/chat' ?>">
                <svg><use href="<?=$this->getImg('adminImg/')?>icons/icons.svg#message"></use></svg>
                <div style="<?= $this->quantityOfUnreadMessages < 1 ? 'display:none;' : "" ?>" class="number-messages"><?= $this->quantityOfUnreadMessages ?></div>
            </a>
            <div class="f-block">
                <div class="profile-img"><img src="<?=$this->getImg($_SESSION['admin']['avatar'])?>" alt="profile"></div>
                <div class="block">
                    <div class="item-text item-header"><?=$_SESSION['admin']['name']?></div>
                    <div class="item-text item-mini"><?=$_SESSION['admin']['role']?></div>
                </div>
                <div class="block header-refer-list">
                    <div class="icon icon-narrow"><svg><use href="<?=$this->getImg('adminImg/')?>icons/icons.svg#spoiler_narrow"></use></svg></div>
                    <div class="header-list mini-list">
                        <a href="<?= PATH . $this->routes['alias'] . '/edit/database/admins/' . $_SESSION['admin']['id'] ?>" class="item-text item-header">Profile Settings</a>
                        <a href="<?= PATH . $this->routes['alias'] . '/login/logout'?>" class="item-text item-header">Sign Out</a>
                    </div>
                </div>

            </div>
        </div>
    </header>