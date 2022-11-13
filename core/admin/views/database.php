

        <div class="main-content">
            <?php if(isset($this->table)): ?>
                <div class="edit-full"><a href="<?= PATH . 'admin/add/database/' . $this->table  ?>"><button>Add a record</button></a></div>
            <?php endif;?>
            <?php if(isset($data) && !empty($data)): ?>
            <?php foreach ($data as $table): ?>
                <?php if(is_array($table)): ?>
                        <div class="item-area-3d">
                            <a href="<?= PATH . 'admin/edit/database/' . $this->table . '/' . $table['id']?>" class="item-3d item-block">
                                <img src="<?= !empty($table['img']) ? $this->getImg($table['img']) : $this->getImg('adminImg/database.png')?>" alt="database">
                                <span class="item-text item-header"><?=$table['name']?></span>
                            </a>
                        </div>
                <?php else: ?>
                        <div class="item-area-3d">
                            <a href="database/<?=$table?>" class="item-3d item-block">
                                <img src="<?=$this->getImg('adminImg/database.png')?>" alt="database">
                                <span class="item-text item-header"><?=$table?></span>
                            </a>
                        </div>
                <?php endif; ?>
            <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
