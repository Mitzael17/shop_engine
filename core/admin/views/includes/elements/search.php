<div class="edit-block edit-full">
    <label for="<?=$key?>">choose <?=preg_replace('/_id$/', '', $key)?></label>
    <div class="search-block">
        <input name="<?=$key?>" type="hidden" value="<?= !empty($value['id']) ? $value['id'] : ''?>">
        <input data-table="<?=preg_replace('/_id$/', '', $key)?>" placeholder="Find <?=preg_replace('/_id$/', '', $key)?>" value="<?=!empty($value['name']) ? $value['name'] : ''?>" class="search-input" type="text">
        <div class="hints-wrapper">
            <div class="hints c-scroll"></div>
        </div>
    </div>
</div>