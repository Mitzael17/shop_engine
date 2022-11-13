<div class="edit-block edit-full">
    <label for="<?=$key?>"><?=$key?></label>
    <div class="block block-password" style="margin: 1em 0 0.8em;">
        <input id="<?=$key?>" name="password" type="password" <?= isset($value['maxValue']) ? 'data-maxvalue="' . $value['maxValue'] . '"' : '' ?> name="<?=$key?>" value="<?= is_array($value) ? $value['selected'] : $value?>" placeholder="<?= isset($value['message']) ? $value['message'] : "Write $key" ?>">
        <svg class="icon icon-show"><use href="<?= $this->getImg('adminImg/'); ?>icons/icons.svg#showPassword"></use></svg>
    </div>
</div>

