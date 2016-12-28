<?if($arResult):?>
<ul class="nav">
    <?
    foreach ($arResult as $value=>$key) {
        ?>
        <li>
            <a href='#' data-id="<?=$key[0]['id']?>" class='opnElements openCatalog'>
                <?=$value?>
                <?php if ($key[1]) { ?>
                    <span class="caret"></span>
                <?php } ?>
            </a>
        </li>
        <?php
    }
    ?>
</ul>
<?endif;?>
