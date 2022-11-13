<?php if(!empty($data[$key])): ?>

<?php foreach ($data[$key] as $name_category => $category): ?>
<div class="edit-block edit block-full">
    <div class="edit-text label"><?=$name_category?></div>
    <div class="edit-half key-list-area manyToMany-list-area mini-list-area">
        <div class="edit-full sbc" style="margin-bottom: 0.5em;">
            <div class="item-text item-header">Select <?=$name_category?></div>
            <svg><use href="<?=$this->getImg('adminImg/')?>/icons/icons.svg#spoiler_narrow"></use></svg>
        </div>
        <?php if(!empty($category)): ?>

        <div class="mini-list key-list manyToMany-list edit-full">
            <input type="hidden" name="<?=$this->table . '_to_' . $key?>[init]" value="init" ">
        <?php foreach ($category as $filter): ?>
            <input id="<?=$key . $filter['id']?>" <?=$filter['selected'] ? 'checked' : ''?> name="<?=$this->table . '_to_' . $key?>[<?=$filter['id']?>]" type="checkbox">
            <label for="<?=$key . $filter['id']?>" class="item-text foreignKeyValue"><?=$filter['name']?></label>

        <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </div>
</div>

<?php endforeach; ?>
<?php endif; ?>