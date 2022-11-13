<div class="edit-block edit-block-container-img edit-full">

    <label style="cursor: pointer;" class="" for="<?=$key?>">
        <button type="button" style="pointer-events: none;">Change</button>
        <?php if(!empty($value)): ?>
            <button class="del-button" type="button">Delete</button>
        <?php endif; ?>
    </label>
    <div class="edit-block edit-full mainImg">
        <div class="img-container">
            <input name="<?=$key?>" id="<?=$key?>" type="file" accept="image/*">
            <img draggable="false" src="<?= !empty($value) ? $this->getImg($value) : ''?>">
        </div>
    </div>
</div>