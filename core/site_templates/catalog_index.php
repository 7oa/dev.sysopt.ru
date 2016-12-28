<?
use Core\Main\Catalog,
    Core\Main\User;
$USER_ID = User::getID();
$userInfo = User::getByID($USER_ID);
$docs=User::getInstance()->getResult('GetManagerPhoto', array('id' => $userInfo["EXTERNAL"]));
if($docs["bindata"]) {
    $img = $_SERVER['DOCUMENT_ROOT'] . '/images/avatar_'. $USER_ID. '.' . $docs["ext"];
    $file = iconv('utf-8', 'windows-1251', $img);
    $decode=base64_decode($docs["bindata"]);
    file_put_contents($file, $decode);
    $path = 'images/avatar_'. $USER_ID. '.' . $docs["ext"];
}
?>
<div class="col-xs-3 leftMenu">
    <ul class="nav catalogMenu">
        <?
        $sections = Catalog::getInstance()->getResult('GetGroupList', array('id' => 0));
        foreach ($sections as $value):
            //$id = $value['id'];
            if($value['name']!="Обувь"):
                $s = Catalog::getInstance()->getResult('GetGroupList', array('id' => $value['id']));
            ?>
            <li>
                <a href="#" data-id="<?= $value['id']; ?>" class="opnElements openCatalog">
                    <?= $value['name']; ?>
                    <?php if (count($s) > 0) { ?>
                        <span class="caret"></span>
                    <?php } ?>
                </a>
                <div class="menuOK">

                </div>
            </li>
        <? endif;
        endforeach; ?>
    </ul>

    <div class="youManager">
        Ваш менеджер<br><strong><?= $userInfo["MANAGER"] ?></strong><br>
        <?if($path):?><img src="<?=$path?>" alt="" width="200" class="managerFoto">
		<?else:?><img src="/core/templates/main/images/avatar_noname.png" alt="" width="200" class="managerFoto">
		<?endif;?><br>
        <div class="managerPhone"><?= $userInfo["MANAGERPHONE"] ?></div>
    </div>
</div>
<div class="col-xs-9 rightContent">
    <div class="search">
        <form class="form-horizontal">
            <div class="row">
                <div class="col-sm-10"><input type="text" class="form-control" id="searchInput"></div>
                <div class="col-sm-2"><input type="submit" class="btn btn-primary button100 serchButton" value="Найти"></div>
            </div>
        </form>
    </div>
    <div>
    	<div id="catalogKey" style="display: none"></div>
        <label>
        	<input id="areVal" class="catalogCheck" type="checkbox" value="Y" checked />
        	Показывать только товары в наличии
        </label>
    </div>
    <div class="divTable">
		<div class="catalogHelp">Выберите товар из каталога<br>или воспользуйтесь поиском</div>
    </div>

</div>
<div class="modal fade" id="analogModal" tabindex="-1" role="dialog" aria-labelledby="analogModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="analogModalLabel">Аналоги</h4>
            </div>
            <div class="modal-body">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
            </div>
        </div>
    </div>
</div>