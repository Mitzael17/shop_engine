
<div class="main-content">

    <div class="admins">


        <div class="f-block MiTab__menu">
            <div class="MiTab-narrow active" data-tab="active_admins">Active admins</div>
            <div class="MiTab-narrow" data-tab="blocked_admins">Blocked admins</div>
        </div>

        <div class="MiTab__tabs" >

            <div class="MiTab-item active" data-tabbody="active_admins">
                <div class="admins__panel sbc">
                    <div class="f-block">
                        <div class="admins__checkbox checkbox-blue" >

                            <input type="checkbox" id="select_active" name="select_all">
                            <label for="select_active">
                                <span></span> Select all
                            </label>

                        </div>
                        <a href="<?= PATH . $this->routes['alias'] . '/add/database/admins'?>"><button>Add admin</button></a>
                    </div>
                    <div class="f-block">
                        <div class="admins__blockAdmin icon icon-block" data-activity="block"><svg><use href="<?=$this->getImg('adminImg/icons/icons.svg#block');?>"></use></svg></div>
                        <div class="admins__delete icon icon-trashBasket" data-activity="delete" ><svg><use href="<?=$this->getImg('adminImg/icons/icons.svg#trash_basket')?>"></use></svg></div>
                    </div>
                </div>

                <ul class="admins__list">
                    <?php if(!empty($data['active_admins'])): ?>
                    <?php foreach ($data['active_admins'] as $admin): ?>
                        <li class="admins__item admin f-block">
                        <div class="admin__img profile-img"><img src="<?=$this->getImg($admin['avatar'])?>" alt="avatar"></div>
                        <div class="block">
                            <div class="admin__name item-text item-header"><?=$admin['name']?></div>
                            <div class="admin__role item-text item-mini"><?=$admin['role']?></div>
                        </div>
                    </li>
                    <?php endforeach; ?>
                    <?php endif; ?>
                </ul>
            </div>

            <div class="MiTab-item" data-tabbody="blocked_admins">
                <div class="admins__panel sbc">
                    <div class="f-block">
                        <div class="admins__checkbox checkbox-blue" >

                            <input type="checkbox" id="select_blocked" name="select_all">
                            <label for="select_blocked">
                                <span></span> Select all
                            </label>

                        </div>
                        <a href="<?= PATH . $this->routes['alias'] . '/add/database/admins'?>"><button>Add admin</button></a>
                    </div>
                    <div class="f-block">
                        <div class="admins__unblockAdmin icon icon-block" data-activity="unblock"><svg><use href="<?= $this->getImg('adminImg/icons/icons.svg#unblock'); ?>"></use></svg></div>
                        <div class="admins__delete icon icon-trashBasket" data-activity="delete" ><svg><use href="<?= $this->getImg('adminImg/icons/icons.svg#trash_basket'); ?>"></use></svg></div>
                    </div>
                </div>

                <ul class="admins__list">
                    <?php if(!empty($data['blocked_admins'])): ?>
                    <?php foreach ($data['blocked_admins'] as $admin): ?>
                    <li class="admins__item admin f-block">
                        <div class="admin__img profile-img"><img src="<?=$this->getImg($admin['avatar'])?>" alt="avatar"></div>
                        <div class="block">
                            <div class="admin__name item-text item-header"><?=$admin['name']?></div>
                            <div class="admin__role item-text item-mini"><?=$admin['role']?></div>
                        </div>
                    </li>
                    <?php endforeach; ?>
                    <?php endif; ?>
                </ul>
            </div>
        </div>


    </div>
</div>
<script> const AJAX_URL = "<?= PATH . $this->routes['alias'] . '/admins' ?>";</script>