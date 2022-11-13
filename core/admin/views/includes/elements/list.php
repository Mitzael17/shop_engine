<div class="edit-block edit-full">
    <div class="item-text item-header"><?=$key?></div>
    <div class="edit-bloc edit-half key-list-area foreignKeysLists-area sbc mini-list-area">
        <div class="edit-full sbc" style="margin-bottom: 0.5em;">
            <div class="item-text item-header selected-value"><?= !empty($value['selected']) ? $value[$value['selected']] : 'Select value' ?></div>
            <svg><use href="<?=$this->getImg('adminImg/')?>icons/icons.svg#spoiler_narrow"></use></svg>
        </div>
        <input name="<?=$key?>" type="hidden" value="<?= !empty($value['selected']) ? $value['selected'] : '' ?>">
        <div class="mini-list key-list foreignKeysLists edit-full">
            <?php if (count($value) > 1):?>
            <?php foreach ($value as $id => $name): ?>
                <?php if ($id === 'selected') continue; ?>
                <div data-id="<?=$id?>" class="item-text foreignKeyValue <?= (!empty($value['selected'] && $value['selected'] == $id) ? 'selected' : '')?>"><?=$name?></div>
            <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</div>