<div class="good__colorsContainer">

    <span class="good__hint">Select color:</span>

    <div class="good__colors">

        <?php foreach ($value['items'] as $color): ?>
            <input type="radio" name="color" class="goods-input-color" id="good__colors--<?=$color?>">
            <label class="label-parametr-color" for="good__colors--<?=$color?>">
                <span class="goods-color" style="background-color: <?=$color === 'white' ? '#e3e3e3' : $color?>;"></span>
            </label>
        <?php endforeach; ?>


    </div>

</div>