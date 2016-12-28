<?php
    $dateFrom = date("d.m.Y", strtotime("-30 days", time()));
?>
<h1>Статистика посещений</h1>
<div class="row celectDate">
    <div class="col-xs-3">
        <div class="input-group date selectDate" id="zakazDateFrom">
            <input type="text" class="form-control" value="<?= $dateFrom; ?>">
            <span class="input-group-btn">
                <button class="btn btn-default" type="button"><span class="glyphicon glyphicon-calendar"></span></button>
            </span>
        </div>
    </div>
    <div class="col-xs-3">
        <div class="input-group selectDate" id="zakazDateTo">
            <input type="text" class="form-control" value="<?= date("d.m.Y"); ?>">
            <span class="input-group-btn">
                <button class="btn btn-default" type="button"><span class="glyphicon glyphicon-calendar"></span></button>
            </span>
        </div>
    </div>
    <div class="col-xs-2">
        <input type="submit" class="btn btn-primary dateSearch statList" value="Обновить список">
    </div>
    <div class="col-xs-4"></div>
</div>
<div id="stat_index_wrap">
    <?= $arResult; ?>
</div>