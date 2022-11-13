<div class="edit-block edit-full">
    <label for="nameGood"><?=$key?></label>
    <input id="nameGood" type="text" <?= isset($value['maxValue']) ? 'data-maxvalue="' . $value['maxValue'] . '"' : '' ?> name="<?=$key?>" value="<?= is_array($value) ? $value['selected'] : $value?>" placeholder="<?= isset($value['message']) ? $value['message'] : "Write $key" ?>">
</div>