<h1>Заказы</h1>
<?
$time = strtotime('-1 month');//strtotime('-10 days');
$dateFrom = date("d.m.Y", $time);
?>
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
        <input type="submit" class="btn btn-primary dateSearch zakazList" value="Обновить список">
    </div>
    <div class="col-xs-4"></div>
</div>
<div class="zakListRes">
    Обновите список. 
</div>
<div class="modal fade" id="zakazInfo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Заказ №<span class="zakazNum"></span></h4>
            </div>
            <div class="modal-body">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
            </div>
        </div>
    </div>
</div>