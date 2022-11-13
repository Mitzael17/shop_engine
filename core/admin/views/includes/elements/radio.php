<div class="edit-block edit-full">

    <div class="label" style="display: block"><?=$key?></div>

    <input class="radio-input" <?= empty($value) || $value === '1' ? 'checked' : ''?> value="1" name="<?=$key?>" id="<?=$key?>-1" type="radio">
    <label class="radio-label" for="<?=$key?>-1"><span></span>Yes</label>

    <input class="radio-input" <?= $value === '0' ? 'checked' : ''?> name="<?=$key?>" id="<?=$key?>-0" value="0" type="radio">
    <label class="radio-label" for="<?=$key?>-0"><span></span>No</label>
</div>