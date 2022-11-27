
<div class="good__size">
    <span class="good__hint"><?=$key?></span>
    <div class="good__listArea show-list">
        <span class="good__sizeSelected show-list__selected"><?=$value['items'][0]?></span>
        <ul class="good__list show-list__body">
            <?php foreach ($value['items'] as $filter): ?>
                <li class="good__option show-list__option"><?=$filter?></li>
            <?php endforeach; ?>
        </ul>
        <input type="hidden" id="good__<?=$key?>" value="<?=$value['items'][0]?>" name="good__<?=$key?>">
    </div>
</div>