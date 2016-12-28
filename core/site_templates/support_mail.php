<?php if ($arResult) { ?>
<div style="width: 100%; background: #EEE; border-radius: 3px;">
    <div style="padding: 10px; background: #DDD; border-radius: 3px 3px 0px 0px;"><?= $arResult['name']; ?></div>
    <div style="padding: 5px; border-top: 1px solid #E4E4E4; border-bottom: 1px solid #DDD;">
        E-mail / Телефон: <?= $arResult['mail']; ?>
    </div>
    <div style="padding: 5px">
        <?= $arResult['text']; ?>
    </div>
</div>
<?php } ?>
