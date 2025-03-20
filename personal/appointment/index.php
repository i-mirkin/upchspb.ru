<?
define("NEED_AUTH", true); // выводит CMain::AuthForm выводится system.auth.authorize
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
require_once($_SERVER["DOCUMENT_ROOT"] . '/personal/functions.php');
/** @global CMain $APPLICATION */
/** @var string $iconDoc */
/** @var string $iconDocNew */
/** @var string $iconDocComplete */

$APPLICATION->SetTitle("Расписание записи на прием");
$APPLICATION->SetPageProperty("title", "Расписание записи на прием");

global $USER;


CModule::IncludeModule("iblock");
$weekdayRu = ['Воскресенье', 'Понедельник', 'Вторник', 'Среда', 'Четверг', 'Пятница', 'Суббота'];
$themeId = $_GET['ID'];

$daysBefore = 30;
$daysAfter = 30;


?>

<? if ($USER->IsAdmin()): ?>
    <div class="appointment appointment_wrap">
        <? if (!$themeId): ?>
            <div style="margin: 3rem 0">
                Выберите тему для обращения:
            </div>
        <? endif; ?>
        <div class="subject-list">
            <?
            // выводим список тем
            $rsThemes = CIBlockElement::GetList(array(), array('IBLOCK_ID' => 38, 'ACTIVE' => 'Y'), false, false, array('ID', 'NAME'));
            while ($arTheme = $rsThemes->GetNext()) {
                $selected = '';
                if ($themeId == $arTheme['ID']) {
                    $themeName = $arTheme['NAME'];
                    $selected = 'selected';
                }
                ?> <a href="/personal/appointment/<?= $arTheme['ID'] ?>/" class="subject <?= $selected ?>
		 "><?= $arTheme['NAME'] ?></a> <br>
                <?
            }
            ?>
        </div>
    </div>
    <br>
    <br>
    <br>
    <? if ($themeId): ?> Выборка по теме: <b><?= $themeName ?></b> <br>
        <br>
        <? showShedule2($themeId); ?>

    <? endif; // $themeId?>


<? else: //для не админов ?><?
    // определяем привязанные темы
    echo $USER->GetFullName() . '<br><br>';

    $rsUsers = CUser::GetList($by, $desc, ["ID" => $USER->GetID()], ["SELECT" => ["UF_THEME"]]);
    if ($arUser = $rsUsers->Fetch()) {
        // по каждой теме выводим расписание
        foreach ($arUser['UF_THEME'] as $themeId) {
            showShedule2($themeId);
            echo '<br><br><br>';
        }
    }


    ?><? endif; // if ($USER->IsAdmin())?><?


function showShedule2($themeId)
{

    global $daysBefore;
    global $daysAfter;
    global $weekdayRu;

    // Название темы
    $rsThemes = CIBlockElement::GetList(array(), array('IBLOCK_ID' => 38, 'ID' => $themeId), false, false, array('ID', 'NAME'));
    $arTheme = $rsThemes->GetNext();

    $shedule = array(); // [День_недели]['']
    $weekday = [500 => 'sun', 501 => 'mon', 502 => 'tue', 503 => 'wed', 504 => 'thu', 505 => 'fri', 506 => 'sat'];
    $shedule[$weekday[501]] = array();
    $shedule[$weekday[502]] = array();
    $shedule[$weekday[503]] = array();
    $shedule[$weekday[504]] = array();
    $shedule[$weekday[505]] = array();

    // выберем все дни недели и время для этой темы THEME SDATE
    // 52 - Базовое расписание для выбранной темы
    $rsDays = CIBlockElement::GetList(
        array(),
        array('IBLOCK_ID' => 52, 'PROPERTY_THEME' => $themeId, 'ACTIVE' => 'Y'),
        false,
        false,
        array('ID', 'NAME', 'PROPERTY_THEME', 'PROPERTY_SDATE', 'IBLOCK_SECTION_ID', 'IBLOCK_SECTION')
    );
    // PROPERTY_THEME_VALUE - название темы из Тематика [38]
    // PROPERTY_SDATE_VALUE - время из Сетки часов [37]
    // IBLOCK_SECTION_ID - день недели 501-505 = Пн...Пт

    while ($arDay = $rsDays->GetNext()) {
        // название Темы
        $rsThemes = CIBlockElement::GetList(array(), array('IBLOCK_ID' => 38, 'ID' => $arDay['PROPERTY_THEME_VALUE'], 'ACTIVE' => 'Y'), false, false, array('ID', 'NAME'));
        $arTheme = $rsThemes->GetNext();
        // название Часов
        $rsHours = CIBlockElement::GetList(array(), array('IBLOCK_ID' => 37, 'ID' => $arDay['PROPERTY_SDATE_VALUE'], 'ACTIVE' => 'Y'), false, false, array('ID', 'NAME'));
        $arHour = $rsHours->GetNext();
        // формируем расписание
        $shedule[$weekday[$arDay['IBLOCK_SECTION_ID']]][] = ['time' => $arHour['NAME'], 'time_id' => $arHour['ID'], 'theme' => $arTheme['NAME'], 'theme_id' => $arDay['PROPERTY_THEME_VALUE']];
    }

    ?>
    <p>
        <b><?= $arTheme['NAME'] ?></b>
    </p>
    <div class="shedule2">
        <?

        // генерируем календарь
        $calendar = array();
        for ($i = -$daysBefore; $i <= $daysAfter; $i++) {

            $d = strtotime("+" . $i . " day");
            $calendar[$i][] = [
                'year' => date("Y", $d),
                'month' => date("m", $d),
                'day' => date("d", $d),
                'weekday' => $weekday[date("w", $d) + 500],
            ];

            if ($shedule[$weekday[date("w", $d) + 500]]):
                // Проверяем не заблокирован ли ВЕСЬ [PROPERTY_ALLDAY] день по этой ТЕМЕ
                $rsBlocked = CIBlockElement::GetList(
                    array(),
                    array(
                        'IBLOCK_ID' => 53, 'ACTIVE' => 'Y',
                        'PROPERTY_THEME' => $themeId,
                        'PROPERTY_ALLDAY_VALUE' => 'Да',
                        '<=PROPERTY_DATE_FROM' => ConvertDateTime(ConvertTimeStamp($d, "SHORT"), "YYYY-MM-DD"),
                        '>=PROPERTY_DATE_TO' => ConvertDateTime(ConvertTimeStamp($d, "SHORT"), "YYYY-MM-DD"),
                    ),
                    false,
                    false,
                    array('ID', 'NAME', 'PROPERTY_DATE_FROM', 'PROPERTY_DATE_TO', 'PROPERTY_ALLDAY')
                );

                if ($arBlocked = $rsBlocked->GetNext()) {
                    ?>
                    <table>
                        <thead>
                        <tr>
                            <td colspan="4">
                                <?= ConvertTimeStamp($d, "SHORT") ?> <?= $weekdayRu[date('w', $d)] ?>
                            </td>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td colspan="4">
                                По этой теме заблокирован весь день!
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <?
                }
                ?>


                <?
                ob_start();
                foreach ($shedule[$weekday[date("w", $d) + 500]] as $one):
                    if ($one['theme_id'] == $themeId): // лишняя проверка
                        $disabled = '';
                        $title = '';
                        // проверяем блокировку конкретного времени ($one['time_id']) конкретной даты ($d)
                        $rsBlocked = CIBlockElement::GetList(
                            array(),
                            array(
                                'IBLOCK_ID' => 53, 'ACTIVE' => 'Y',
                                'PROPERTY_TIME' => $one['time_id'],
                                '<=PROPERTY_DATE_FROM' => ConvertDateTime(ConvertTimeStamp($d, "SHORT"), "YYYY-MM-DD"),
                                '>=PROPERTY_DATE_TO' => ConvertDateTime(ConvertTimeStamp($d, "SHORT"), "YYYY-MM-DD"),
                            ),
                            false,
                            false,
                            array('ID', 'NAME', 'PROPERTY_DATE_FROM', 'PROPERTY_DATE_TO', 'PROPERTY_ALLDAY')
                        );
                        if ($arBlocked = $rsBlocked->GetNext()) {
                            // время заблокировано
                            ?>
                            <tr>
                                <td colspan="4"><?= $one['time'] ?> - нет приема</td>
                            </tr>
                            <?
                        }
                        unset($rsBlocked, $arBlocked);
                        ?>


                        <?
                        // проверяем наличие записи на текущее время и дату
                        $rsBusy = CIBlockElement::GetList(
                            array(),
                            array(
                                'IBLOCK_ID' => 39,
                                'ACTIVE' => 'Y',
                                'PROPERTY_hours' => $one['time_id'],
                                'PROPERTY_date' => ConvertDateTime(ConvertTimeStamp($d, "SHORT"), "YYYY-MM-DD"),
                            ),
                            false,
                            false,
                            array('ID', 'NAME', 'PREVIEW_TEXT', 'PROPERTY_surname', 'PROPERTY_name', 'PROPERTY_phone')
                        );
                        if ($arBusy = $rsBusy->GetNext()) {
                            ?>
                            <tr>
                                <td><?= $one['time'] ?></td>
                                <td><?= $arBusy['PROPERTY_SURNAME_VALUE'] . ' ' . $arBusy['PROPERTY_NAME_VALUE'] ?></td>
                                <td><?= $arBusy['PROPERTY_PHONE_VALUE'] ?></td>
                                <td><?= $arBusy['PREVIEW_TEXT'] ?></td>
                            </tr>
                            <?
                        }
                        unset($rsBusy, $arBusy);
                    endif;

                endforeach;

                $daySheduleOut = trim(ob_get_clean());

                if ($daySheduleOut): // если есть есть заблокированные часы или дни с записью выводим $daySheduleOut
                    ?>
                    <table class="table-shedule">
                        <thead>
                        <tr>
                            <td colspan="4">
                                <?= ConvertTimeStamp($d, 'SHORT') ?> <?= $weekdayRu[date('w', $d)] ?>
                            </td>
                        </tr>
                        </thead>

                        <?=$daySheduleOut?>

                    </table>
                <? endif ?>


            <? endif ?>

            <?
        }
        ?>
    </div>
    <?
}

?><?

function showShedule($themeId)
{

    global $daysBefore;
    global $daysAfter;
    global $weekdayRu;

    // Название темы
    $rsThemes = CIBlockElement::GetList(array(), array('IBLOCK_ID' => 38, 'ID' => $themeId), false, false, array('ID', 'NAME'));
    $arTheme = $rsThemes->GetNext();

    $shedule = array(); // [День_недели]['']
    $weekday = [
        500 => 'sun',
        501 => 'mon',
        502 => 'tue',
        503 => 'wed',
        504 => 'thu',
        505 => 'fri',
        506 => 'sat',
    ];
    $shedule[$weekday[501]] = array();
    $shedule[$weekday[502]] = array();
    $shedule[$weekday[503]] = array();
    $shedule[$weekday[504]] = array();
    $shedule[$weekday[505]] = array();

    // выберем все дни недели и время для этой темы THEME SDATE
    // 52 - Базовое расписание для выбранной темы
    $rsDays = CIBlockElement::GetList(
        array(),
        array('IBLOCK_ID' => 52, 'PROPERTY_THEME' => $themeId, 'ACTIVE' => 'Y'),
        false,
        false,
        array('ID', 'NAME', 'PROPERTY_THEME', 'PROPERTY_SDATE', 'IBLOCK_SECTION_ID', 'IBLOCK_SECTION')
    );
    // PROPERTY_THEME_VALUE - название темы из Тематика [38]
    // PROPERTY_SDATE_VALUE - время из Сетки часов [37]
    // IBLOCK_SECTION_ID - день недели 501-505 = Пн...Пт

    while ($arDay = $rsDays->GetNext()) {
        // название Темы
        $rsThemes = CIBlockElement::GetList(array(), array('IBLOCK_ID' => 38, 'ID' => $arDay['PROPERTY_THEME_VALUE'], 'ACTIVE' => 'Y'), false, false, array('ID', 'NAME'));
        $arTheme = $rsThemes->GetNext();
        // название Часов
        $rsHours = CIBlockElement::GetList(array(), array('IBLOCK_ID' => 37, 'ID' => $arDay['PROPERTY_SDATE_VALUE'], 'ACTIVE' => 'Y'), false, false, array('ID', 'NAME'));
        $arHour = $rsHours->GetNext();
        // формируем расписание
        $shedule[$weekday[$arDay['IBLOCK_SECTION_ID']]][] = ['time' => $arHour['NAME'], 'time_id' => $arHour['ID'], 'theme' => $arTheme['NAME'], 'theme_id' => $arDay['PROPERTY_THEME_VALUE']];
    }

    ?>
    <p>
        <b><?= $arTheme['NAME'] ?></b>
    </p>
    <div class="shedule">
        <?

        // генерируем календарь
        $calendar = array();
        for ($i = -$daysBefore; $i <= $daysAfter; $i++) {

            $d = strtotime("+" . $i . " day");
            $calendar[$i][] = [
                'year' => date("Y", $d),
                'month' => date("m", $d),
                'day' => date("d", $d),
                'weekday' => $weekday[date("w", $d) + 500],
            ];

            if ($shedule[$weekday[date("w", $d) + 500]]):
                // Проверяем не заблокирован ли ВЕСЬ [PROPERTY_ALLDAY] день по этой ТЕМЕ
                $rsBlocked = CIBlockElement::GetList(
                    array(),
                    array(
                        'IBLOCK_ID' => 53, 'ACTIVE' => 'Y',
                        'PROPERTY_THEME' => $themeId,
                        'PROPERTY_ALLDAY_VALUE' => 'Да',
                        '<=PROPERTY_DATE_FROM' => ConvertDateTime(ConvertTimeStamp($d, "SHORT"), "YYYY-MM-DD"),
                        '>=PROPERTY_DATE_TO' => ConvertDateTime(ConvertTimeStamp($d, "SHORT"), "YYYY-MM-DD"),
                    ),
                    false,
                    false,
                    array('ID', 'NAME', 'PROPERTY_DATE_FROM', 'PROPERTY_DATE_TO', 'PROPERTY_ALLDAY')
                );
                if ($arBlocked = $rsBlocked->GetNext()) {
                    ?>
                    <div class="shedule-day shedule-day-allday-blocked">
                        <div class="shedule-day-date">
                            <?= ConvertTimeStamp($d, "SHORT") ?> <?= $weekdayRu[date('w', $d)] ?>
                        </div>
                        По этой теме заблокирован весь день!
                    </div>
                    <?
                }
                ?>
                <div class="shedule-day">
                    <div class="shedule-day-date">
                        <?= ConvertTimeStamp($d, 'SHORT') ?> <?= $weekdayRu[date('w', $d)] ?>
                    </div>
                    <div class="shedule-day-time">
                        <? foreach ($shedule[$weekday[date("w", $d) + 500]] as $one): ?><? if ($one['theme_id'] == $themeId): // лишняя проверка ?><?
                            $disabled = '';
                            $title = '';
                            // проверяем блокировку конкретного времени ($one['time_id']) конкретной даты ($d)
                            $rsBlocked = CIBlockElement::GetList(
                                array(),
                                array(
                                    'IBLOCK_ID' => 53, 'ACTIVE' => 'Y',
                                    'PROPERTY_TIME' => $one['time_id'],
                                    '<=PROPERTY_DATE_FROM' => ConvertDateTime(ConvertTimeStamp($d, "SHORT"), "YYYY-MM-DD"),
                                    '>=PROPERTY_DATE_TO' => ConvertDateTime(ConvertTimeStamp($d, "SHORT"), "YYYY-MM-DD"),
                                ),
                                false,
                                false,
                                array('ID', 'NAME', 'PROPERTY_DATE_FROM', 'PROPERTY_DATE_TO', 'PROPERTY_ALLDAY')
                            );
                            if ($arBlocked = $rsBlocked->GetNext()) $disabled = 'disabled blocked';
                            unset($rsBlocked, $arBlocked);

                            // проверяем наличие записи на текущее время и дату
                            $rsBusy = CIBlockElement::GetList(
                                array(),
                                array(
                                    'IBLOCK_ID' => 39,
                                    'ACTIVE' => 'Y',
                                    'PROPERTY_hours' => $one['time_id'],
                                    'PROPERTY_date' => ConvertDateTime(ConvertTimeStamp($d, "SHORT"), "YYYY-MM-DD"),
                                ),
                                false,
                                false,
                                array('ID', 'NAME', 'PROPERTY_surname', 'PROPERTY_name')
                            );
                            if ($arBusy = $rsBusy->GetNext()) $disabled .= ' disabled busy';
                            $title = $arBusy['PROPERTY_SURNAME_VALUE'] . ' ' . $arBusy['PROPERTY_NAME_VALUE'] . ' записан ' . ConvertDateTime(ConvertTimeStamp($d, "SHORT"), "DD.MM.YYYY") . ' в ' . $one['time'];
                            unset($rsBusy, $arBusy);
                            ?>
                            <div class="shedule-day-time-item <span id=" title="Код PHP: &lt;?= $disabled ?&gt;">
                                <?= $disabled ?><span class="bxhtmled-surrogate-inner"><span class="bxhtmled-right-side-item-icon"></span><span class="bxhtmled-comp-lable" unselectable="on" spellcheck="false">Код PHP</span></span>"&gt;
                            </div>
                        <? endif ?><? endforeach ?>
                    </div>
                </div>
            <? endif ?><?
        }
        ?>
    </div>
    <?
}

?><? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>