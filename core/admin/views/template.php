<div class="main-content">
    <?php if(isset($this->table)): ?>
        <div class="edit-full"><a href="<?= PATH . 'admin/add/template/' . $this->table  ?>"><button>Add a record</button></a></div>
    <?php endif;?>
    <?php if(isset($data) && !empty($data)): ?>
        <?php foreach ($data as $table): ?>
        <?php if(isset($table['refer'])): ?>
                <div class="item-area-3d">
                    <a href="<?= PATH . $this->routes['alias'] . '/show/template/' . $table['refer'] ?>" class="item-3d item-block">
                        <img src="<?= !empty($table['img']) ? $this->getImg($table['img']) : $this->getImg('adminImg/database.png')?>" alt="database">
                        <span class="item-text item-header"><?= isset($table['name']) ? $table['name'] : $table['id'] ?></span>
                    </a>
                </div>
        <?php else: ?>
                <div class="item-area-3d">
                    <a href="<?= PATH . $this->routes['alias'] . '/edit/database/' . $this->table .  '/'. $table['id'] ?>" class="item-3d item-block">
                        <img src="<?= !empty($table['img']) ? $this->getImg($table['img']) : $this->getImg('adminImg/database.png')?>" alt="database">
                        <span class="item-text item-header"><?= $table['name'] ?></span>
                    </a>
                </div>
        <?php endif; ?>
        <?php endforeach; ?>
    <?php endif; ?>
</div>
</div>
