<? require($_SERVER["DOCUMENT_ROOT"] . "/core/header.php"); ?>
<?

use Core\Main\Basket,
    Core\Main\Template,
    Core\Main\Visits;

$basket = Basket::getInstance(false);
?>

<div class="container body tab-content">
	<?php if (isset($_GET['stat'])) {
        $dfrom = strtotime("-30 days", time());
        $dto = time();
		$visits = new Visits($dfrom, $dto);
        ob_start();
            Template::includeTemplate('stat_table', $visits);
        $visits = ob_get_clean();
        ?>
        <div class="row tab-pane active">
		    <? Template::includeTemplate('stat_index', $visits); ?>
	    </div>
	<?php } else { ?>
    <div class="row tab-pane active" id="catalog">
        <? Template::includeTemplate('catalog_index'); ?>
    </div>

    <div class="row tab-pane" id="basket">
        <? Template::includeTemplate('basket_index', $basket); ?>
    </div>

    <div class="row tab-pane" id="orders">
        <? Template::includeTemplate('orders_index'); ?>
    </div>

    <div class="row tab-pane" id="payments">
        <? Template::includeTemplate('payments_index'); ?>
    </div>

    <div class="row tab-pane" id="samples">
        <? Template::includeTemplate('samples_index'); ?>
    </div>

    <div class="row tab-pane" id="favorits">
        <? Template::includeTemplate('favorit_index'); ?>
    </div>

	<?php } ?>
</div> <!-- /container -->

<? require($_SERVER["DOCUMENT_ROOT"] . "/core/footer.php"); ?>