<?
define("NEED_AUTH", true); // выводит CMain::AuthForm выводится system.auth.authorize
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
require_once($_SERVER["DOCUMENT_ROOT"] . '/personal/functions.php');

/** @global CMain $APPLICATION */
/** @var string $iconDoc */
/** @var string $iconDocNew */
/** @var string $iconDocComplete */

$APPLICATION->SetTitle("Персональный раздел");
$APPLICATION->SetPageProperty("title", "Персональный раздел");
CModule::IncludeModule('iblock');


$arFilter['IBLOCK_ID'] = 22; // инфоблок с вх. сообщениями
$PROPERTY_COMPLETE_Y_ID = 85; // ID "Да" св-ва Исполнен (COMPLETE)
$nPageSize = 20;
$iNumPage = $request->get("PAGEN_1") ? $request->get("PAGEN_1") : 1;


// определяем группу пользователя
global $USER;
$arGroups = CUser::GetUserGroup($USER->GetID());
$request = \Bitrix\Main\Context::getCurrent()->getRequest();

// код группы текущего пользователя DIRECTOR || HEAD || EXECUTOR
$myGroup = '';


$enums = CIBlockPropertyEnum::GetList(array("DEF" => "DESC", "SORT" => "ASC"), array('IBLOCK_ID' => $arFilter['IBLOCK_ID'], 'CODE' => 'HOLDER'));
while ($enum = $enums->GetNext()) {
    $holderIdByNameArr[$enum['EXTERNAL_ID']] = $enum['ID'];
    $holderNameByIdArr[$enum['ID']] = $enum['EXTERNAL_ID'];
    $HOLDER_ARR[$enum['ID']] = [$enum['XML_ID'], $enum['VALUE']];
};

//на выходе $holderIdByNameArr
//[DIRECTOR] => 82
//[HEAD] => 83
//[EXECUTOR] => 84

//на выходе $holderNameByIdArr
//[82] => DIRECTOR
//[83] => HEAD
//[84] => EXECUTOR


if (in_array(9, $arGroups)) {
    $arFilter['PROPERTY_DIRECTOR'] = $USER->GetID(); // показываем только документы для текущего Р
    $myGroup = 'DIRECTOR';
}
elseif (in_array(10, $arGroups)) {
    $arFilter['PROPERTY_HEAD'] = $USER->GetID(); // показываем только документы для текущего НО
    $myGroup = 'HEAD';
}
elseif (in_array(11, $arGroups)) {
    $arFilter['PROPERTY_EXECUTOR'] = $USER->GetID(); // показываем только документы для текущего И
    $myGroup = 'EXECUTOR';
}

// ФИЛЬТР
if ($request->get("filter_holder")) {
    if($request->get("filter_holder") == 'my') {
        $arFilter['PROPERTY_HOLDER'] = $holderIdByNameArr[$myGroup];
        $arFilter['!PROPERTY_COMPLETE'] = $PROPERTY_COMPLETE_Y_ID;

    } // фильтр цифра 82...84
    else {
        $arFilter['PROPERTY_HOLDER'] = $holderIdByNameArr[mb_strtoupper($request->get("filter_holder"))];
        $arFilter['!PROPERTY_COMPLETE'] = $PROPERTY_COMPLETE_Y_ID;
    }
}


// сортировка
if($myGroup == 'DIRECTOR') $arSort = array('PROPERTY_COMPLETE' => 'ASC', 'PROPERTY_HOLDER' => 'DESC', 'ID' => 'DESC');
else $arSort = array('PROPERTY_COMPLETE' => 'ASC', 'ID' => 'DESC');

$rsItems = CIBlockElement::GetList(
    $arSort,
    $arFilter,
    false,
    array('nPageSize' => $nPageSize, 'iNumPage' => $iNumPage),
    array('ID', 'DATE_CREATE', 'NAME', 'PROPERTY_COMPLETE', 'PROPERTY_DIRECTOR', 'PROPERTY_HEAD', 'PROPERTY_EXECUTOR', 'PROPERTY_HOLDER', 'PROPERTY_OTVET')
);
while ($arItem = $rsItems->GetNext()) $arFilterItem[] = $arItem;
?>


<?
ob_start(); // начинаем буферизацию вывода
$APPLICATION->IncludeComponent(
    'bitrix:system.pagenavigation',
    '',
    array(
        'NAV_TITLE' => 'Элементы', // поясняющий текст для постраничной навигации
        'NAV_RESULT' => $rsItems,  // результаты выборки из базы данных
        'SHOW_ALWAYS' => false       // показывать постраничную навигацию всегда?
    )
);
$navString = ob_get_clean(); // завершаем буферизацию вывода
?>

<?
//include 'personal-table-v1.php'; // старая версия
?>

    <table class="personal-table">
        <thead>
        <tr>
            <td>Дата создания</td>
            <td>Содержание</td>
            <td>Статус</td>
            <td>Исполнитель</td>
        </tr>
        <thead>
        <tbody>


        <!-- ФИЛЬТР -->
        <?
        $filterHolderArr = []; // все значения статусов для checkbox'в
        $filterHolderArr = $arFilter['PROPERTY_HOLDER'] ? array_merge($filterHolderArr, array($arFilter['PROPERTY_HOLDER'])) : $filterHolderArr;
        $filterHidden = $filterHolderArr ? '' : 'hidden';
        ?>
        <form id="filter-form" method="POST">
            <tr>
                <td><a href="#" class="filter-block-toggler">Фильтр</a></td>
                <td colspan="3">
                    <div class="filter-block <?= $filterHidden ?>">
                        Показать записи, где документ у: <br>
                        <? foreach($HOLDER_ARR as $key => $value): ?>
                            <input type="radio" name="filter_holder" value="<?=$value[0]?>" <?= in_array($key, $filterHolderArr) ? 'checked' : '' ?> > <?=$value[1]?> &nbsp; &nbsp;
                        <? endforeach ?>
                </td>
            </tr>
            <tr class="filter-block <?= $filterHidden ?>">
                <td colspan="4">
                    <div class="text-right">
                        <a href="/personal/questions/">Сбросить</a> &nbsp; &nbsp;
                    </div>
                </td>
            </tr>
        </form>
        <!-- / ФИЛЬТР -->


        <?
        foreach ($arFilterItem as $arItem):

            // если документ у меня (у тек. пользователя), надо исполнять
            $status = $holderNameByIdArr[$arItem['PROPERTY_HOLDER_ENUM_ID']];
            if ($arItem['PROPERTY_HOLDER_ENUM_ID'] == $holderIdByNameArr[$myGroup]) $status = 'MY';

            $icon = '';
            if ($arItem['PROPERTY_COMPLETE_VALUE'] != 'Да') {
                if ($arItem['PROPERTY_OTVET_VALUE']['TEXT']) $icon = '<span title="Исполняется">' . $iconDoc . '</span>';
                else $icon = '<span title="Новый">' . $iconDocNew . '</span>';
            }
            else {
                $icon = '<span title="Выполнено">' . $iconDocComplete . '</span>';
                $iconDocCompleteLink = '<a style="margin-left: 20px" href="/personal/questions/detail/?CODE=' . $arItem['ID'] . '" title="Выполнено">' . $iconDocComplete . '</a>';
                $status = 'COMPLETE';
            }


            ?>
            <tr class="status-<?= $status ?>">

                <td>
                    <?= $arItem['DATE_CREATE'] ?> <br>
                    <!--
                    [<?= $arItem['ID'] ?>] <br>
                    [<?= $arItem['PROPERTY_HOLDER_ENUM_ID'] ?>]
                    -->
                </td>

                <td>
                    <div class="personal-table-name">
                        <a href="/personal/questions/detail/?CODE=<?= $arItem['ID'] ?>"><?= $arItem['NAME'] ?></a>
                    </div>
                    <div class="personal-table-info">
                        <?
                        // находим всю иерархию исполнителей документа
                        //$itemInfo = '';
                        //if($arItem['PROPERTY_DIRECTOR_VALUE']) ...
                        ?>
                        <!--span title=""><?= $iconInfo ?></span-->
                    </div>
                </td>

                <td>
                    <?= $icon ?>
                </td>

                <td>
                    <?
                    // у какого документ ДОЛЖНОСТЬ XML_ID  [DIRECTOR || HEAD || EXECUTOR]
                    $holder = $holderNameByIdArr[$arItem['PROPERTY_HOLDER_ENUM_ID']];
                    // у какого документ ИМЯ
                    $holderName = CUser::GetByID($arItem['PROPERTY_' . $holder . '_VALUE'])->Fetch()['LAST_NAME'] . ' ' . CUser::GetByID($arItem['PROPERTY_' . $holder . '_VALUE'])->Fetch()['NAME'];
                    echo $holderName;
                    ?>
                </td>

            </tr>
        <?
        endforeach;
        ?>
        </tbody>
    </table>


<?
echo $navString;
?>


    <script>

        $('.filter-block-toggler').click(function (e) {
            e.preventDefault();
            /*
            contentBlockToggle = $(this).prev(".content-block");
            contentBlockToggle.toggleClass( "hidden");
            */
            $(".filter-block").toggleClass("hidden");
            if ($(this).text() == 'Фильтр') $(this).text('Скрыть');
            else $(this).text('Фильтр');
            //$(".filter-block").slideDown('slow');
        });


        $('#filter-clear').click(function (e) {
            $('[name^="filter_holder"]').prop("checked", false);
        });

    </script>


<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>