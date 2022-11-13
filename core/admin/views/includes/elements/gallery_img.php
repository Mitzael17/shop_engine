<div class="edit-block edit-full gallery">
    <div class="img-container img-gallery">
        <input id="<?=$key?>" type="file" name="<?=$key?>[]" multiple accept="image/*">
        <div class="img-block">
            <label class="plus-icon" for="<?=$key?>">
                <span></span><span></span>
            </label>
        </div>
        <?php if(!empty($value)): ?>
        <?php
            $value = explode( ',', $value);
            foreach ($value as $img):
            ?>
        <div class="img-block">
            <div class="icon-delete"><span></span><span></span></div>
            <img src="<?= $this->getImg($img)?>" draggable="false" alt="photo">
        </div>
        <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>