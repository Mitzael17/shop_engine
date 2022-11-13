<div class="main-content">
    <div class="logs">
        <div class="logs__nav">
            <form class="f-block no_default_form logs_form" action="<?=PATH . $this->routes['alias']?>/logs">
                <div class="logs__navBlock calendar f-block">
                    <label for="#beginDate">From</label>
                    <input type="text" name="fromDate" id="beginDate" placeholder="choose Date">
                </div>
                <div class="logs__navBlock calendar f-block">
                    <label for="#beginDate">To</label>
                    <input type="text" name="toDate" id="beginDate" placeholder="choose Date">
                </div>
                <button type="submit">Поиск</button>
            </form>
        </div>
        <div class="logs__content">
            <?php if($data): ?>
            <?php foreach ($data as $log): ?>
                <div class="logs__log">
                    <div class="f-block">
                        <div class="profile-img">
                            <img src="<?=$this->getImg($log['avatar'])?>" alt="profile-img">
                        </div>
                        <div class="block">
                            <div class="item-text item-header"><?=$log['name']?></div>
                            <div class="item-text item-mini"><?=$log['role']?></div>
                        </div>
                    </div>
                    <div class="logs__date item-text"><?=$log['date']?></div>
                    <div>
                        <?=$log['message']?>
                        <?php if(!empty($log['alias'])): ?>
                        <a style="text-decoration: underline; " href="<?= PATH . $this->routes['alias'] . '/' . $log['alias']?>">record</a>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endforeach; ?>
                <script> const ID_LOGS = <?=$data[count([$data]) - 1]['id'] ?></script>
            <?php endif; ?>
            <button id="loadMoreLogs" data-url="<?=PATH . $this->routes['alias'] . '/logs'?>" style="display: block; margin: 2em auto;">Load More</button>
        </div>
    </div>
</div>