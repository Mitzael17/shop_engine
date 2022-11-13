<div class="main-content">
    <div class="chart">
        <div class="chart__nav">
            <div class="chart__dates">
                <form action="#">
                    <input type="hidden" name="date_from">
                    <input type="hidden" name="date_to">
                </form>
                <div class="chart__block">
                    <div class="chart__block chart__block--from">
                        <div class="item-text item-header">From</div>
                        <div class="chart__fromIcon icon icon-calendar"><svg><use href="<?=$this->getImg('adminImg/icons/icons.svg#calendar')?>"></use></svg></div>
                        <div class="chart__calendar"></div>
                    </div>
                    <div class="chart__block chart__block--to">
                        <div class="item-text item-header">To</div>
                        <div class="chart__fromIcon icon icon-calendar"><svg><use href="<?=$this->getImg('adminImg/icons/icons.svg#calendar')?>"></use></svg></div>
                        <div class="chart__calendar"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="chart__graph chart__graph--bar">
            <canvas></canvas>

        </div>
        <div class="chart__graph chart__graph--line">
            <canvas></canvas>

        </div>
        <div class="chart__graph chart__graph--line">
            <canvas></canvas>

        </div>
        <div class="chart__graph chart__graph--bar">
            <canvas></canvas>

        </div>
        <div class="chart__graph chart__graph--pie">
            <canvas></canvas>

        </div>
        <div class="chart__graph chart__statistic">
            <h1>Statistic</h1>
        </div>
    </div>
</div>