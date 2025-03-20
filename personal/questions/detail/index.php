<?
global $USER;
define("NEED_AUTH", true); // выводит CMain::AuthForm выводится system.auth.authorize
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
require_once('../../functions.php');

/** @global CMain $APPLICATION */

$APPLICATION->SetTitle("Персональный раздел");
$APPLICATION->SetPageProperty("title", "Персональный раздел");

CModule::IncludeModule('iblock');
$arGroups = CUser::GetUserGroup($USER->GetID());

$request = \Bitrix\Main\Context::getCurrent()->getRequest();
//$getParameters = $request->getQueryList()->toArray(); // get параметры
$CODE = $request->get("CODE") ? $request->get("CODE") : false;
?>

    <a href="/personal/questions/">&larr; Назад (к списку)</a>
    <br>
    <br>
    <br>
    <br>
<?

global $USER;
$CUR_USER_ID = $USER->GetID();
$USER_ID = $USER->GetID();
$rsUser = CUser::GetByID($USER_ID);
$arUser = $rsUser->GetNext();
$curUserNameShort = $arUser['LAST_NAME'] . ' ' . mb_substr($arUser['NAME'], 0, 1) . '.' . mb_substr($arUser['SECOND_NAME'], 0, 1) . '.';


// группа пользователя
$USER_GROUP = '';

if (in_array(9, $arGroups)) {
    // Руководитель DIRECTOR
    $USER_GROUP = 'DIRECTOR';
    $ACCESS = true;
}
elseif (in_array(10, $arGroups)) {
    // НО HEAD
    $USER_GROUP = 'HEAD';
    // проверяем возможность доступ пользователя к текущему элементу
    $rsItems = CIBlockElement::GetList([], ['IBLOCK_ID' => 22, 'ID' => $CODE, 'PROPERTY_HEAD' => $USER->GetID()], false, false, ['ID']);
    if ($rsItems->GetNext()) $ACCESS = true;
}
elseif (in_array(11, $arGroups)) {
    // Исполнитель EXECUTOR
    $USER_GROUP = 'EXECUTOR';
    $rsItems = CIBlockElement::GetList([], ['IBLOCK_ID' => 22, 'ID' => $CODE, 'PROPERTY_EXECUTOR' => $USER->GetID()], false, false, ['ID']);
    if ($rsItems->GetNext()) $ACCESS = true;
}
if (!$ACCESS) {
    echo 'Доступ к элементу запрещен!';
    require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php");
    exit;
}

$arFilter['IBLOCK_ID'] = 22;

$enums = CIBlockPropertyEnum::GetList(array("DEF" => "DESC", "SORT" => "ASC"), array('IBLOCK_ID' => $arFilter['IBLOCK_ID'], 'CODE' => 'HOLDER'));
while ($enum = $enums->GetNext()) {
    $holderIdByCodeArr[$enum['EXTERNAL_ID']] = $enum['ID'];
    $holderCodeByIdArr[$enum['ID']] = $enum['EXTERNAL_ID'];
    // для списка select
    $HOLDER_ARR[$enum['ID']] = [$enum['XML_ID'], $enum['VALUE']];

};


// обработка сохранить
if (!empty($_REQUEST["action"])) {
    define("NO_KEEP_STATISTIC", true);
    define("NOT_CHECK_PERMISSIONS", true);
    /*
    echo 'Вот такие данные мы передали';
    echo '<pre>';	print_r($_POST); echo '</pre>';
    */
    $PROPERTY_VALUES['otvet'] = array('VALUE' => array('TYPE' => 'text', 'TEXT' => $_POST['otvet']));
    if ($_POST['select_holder']) $PROPERTY_VALUES['HOLDER'] = $_POST['select_holder'];
    if ($_POST['select_head']) $PROPERTY_VALUES['HEAD'] = $_POST['select_head'];
    if ($_POST['select_executor']) $PROPERTY_VALUES['EXECUTOR'] = $_POST['select_executor'];
    if ($_POST['head_personally'] == 'y') $PROPERTY_VALUES['HEAD_PERSONALLY'] = 70;
    else $PROPERTY_VALUES['HEAD_PERSONALLY'] = null;

    // Добавим в комментарий передачу документа
    // Извлекаем текущие состояние документа, чтобы определить что добавить в комменты
    $rsItems = CIBlockElement::GetList(
        array('ID' => 'DESC'),
        array('IBLOCK_ID' => 22, 'ID' => $CODE),
        false,
        array(),
        array('ID', 'NAME', 'PROPERTY_STATUS', 'PROPERTY_USER', 'PROPERTY_EMAIL', 'PROPERTY_PHONE', 'PROPERTY_OTVET', 'DATE_CREATE',
            'PROPERTY_HOLDER',
            'PROPERTY_DONE',
            'PROPERTY_DIRECTOR', 'PROPERTY_HEAD', 'PROPERTY_EXECUTOR',
        )
    );
    $arItem = $rsItems->GetNext();

    $comment_event = '';
    if ($_POST['select_head'] && $_POST['select_head'] != $arItem['PROPERTY_HEAD_VALUE'] && $arItem['PROPERTY_HEAD_VALUE'])
        $comment_event = getUserByIdShort($USER->GetID()) . " передал(а) от " . getUserByIdShort($arItem['PROPERTY_HEAD_VALUE']) . " к " . getUserByIdShort($_POST['select_head']);

    if ($_POST['select_executor'] && $_POST['select_executor'] != $arItem['PROPERTY_EXECUTOR_VALUE'] && $arItem['PROPERTY_EXECUTOR_VALUE'])
        $comment_event = getUserByIdShort($USER->GetID()) . " передал(а) от " . getUserByIdShort($arItem['PROPERTY_EXECUTOR_VALUE']) . " к " . getUserByIdShort($_POST['select_executor']);

    // поменялся КОД держателя
    if ($_POST['select_holder'] != $arItem['PROPERTY_HOLDER_ENUM_ID']) {


        // но ФИО держателя и исполнителя остались прежними
//        if (
//            ($_POST['select_head'] && $_POST['select_head'] == $arItem['PROPERTY_HEAD_VALUE']) &&
//            ($_POST['select_executor'] && $_POST['select_executor'] == $arItem['PROPERTY_EXECUTOR_VALUE'])
//
//        ) {
        $fromId = $arItem['PROPERTY_' . $holderCodeByIdArr[$arItem['PROPERTY_HOLDER_ENUM_ID']] . '_VALUE'];
        $fromName = getUserByIdShort($fromId);
        //$toId = $arItem['PROPERTY_'.$holderCodeByIdArr[$_POST['select_holder']].'_VALUE'];
        $toId = $_POST['select_' . mb_strtolower($holderCodeByIdArr[$_POST['select_holder']])]; // $_POST['select_holder'] 82-84 $holderCodeByIdArr[$_POST['select_holder']]
        $toName = getUserByIdShort($toId);
        $comment_event = "Передал(а) документ от " . $fromName . " к " . $toName . "";
//        }


    }

    // пришел комментарий или комментарий по событию
    if ($_POST['comment'] || $comment_event) {
        // текущий коммент
        $comments = array();
        if ($comment_event) $comments[] = '<i>' . date('m.d.y H:i') . ' ' . $curUserNameShort . ':</i> ' . $comment_event;
        if ($_POST['comment']) $comments[] = '<i>' . date('m.d.y H:i') . ' ' . $curUserNameShort . ':</i> ' . $_POST['comment'];

        // получим все комментарии
        $rsComments = CIBlockElement::GetList(
            array('ID' => 'DESC'),
            array('IBLOCK_ID' => 22, 'ID' => $CODE),
            false,
            array(),
            array('ID', 'NAME', 'PROPERTY_COMMENTS')
        );
        // добавим их все к текущему
        while ($arComment = $rsComments->GetNext()) {
            array_push($comments, $arComment['~PROPERTY_COMMENTS_VALUE']);
        }
        $PROPERTY_VALUES['COMMENTS'] = $comments;
    }


    // логи
    // получим все предыдущие логи
    $logs = array();
    $rsLogs = CIBlockElement::GetList(
        array('ID' => 'DESC'),
        array('IBLOCK_ID' => 22, 'ID' => $CODE),
        false,
        array(),
        array('ID', 'NAME', 'PROPERTY_LOG')
    );
    // добавим их все к текущему
    while ($arLog = $rsLogs->GetNext()) {
        array_push($logs, $arLog['~PROPERTY_LOG_VALUE']);
    }
    // новая запись лога
    // извлекаем текущие записи
    $rsItems = CIBlockElement::GetList(
        array('ID' => 'DESC'),
        array('IBLOCK_ID' => 22, 'ID' => $CODE),
        false,
        array(),
        array('ID', 'NAME', 'PROPERTY_STATUS', 'PROPERTY_USER', 'PROPERTY_EMAIL', 'PROPERTY_PHONE', 'PROPERTY_OTVET', 'DATE_CREATE',
            'PROPERTY_HOLDER',
            'PROPERTY_DONE',
            'PROPERTY_DIRECTOR', 'PROPERTY_HEAD', 'PROPERTY_EXECUTOR',
        )
    );
    $arItem = $rsItems->GetNext();

    // в POST передаются id  надо получить название
    // $arItem['STATUS_DIRECTOR_VALUE'] - здесь название
    // $arItem['HOLDER_VALUE'] - здесь название
    // $arItem['PROPERTY_DIRECTOR_VALUE'] - здесь id

    $HOLDER_NAME = array();
    $property_enums = CIBlockPropertyEnum::GetList(array(), array('IBLOCK_ID' => 22, 'CODE' => 'HOLDER'));
    while ($enum_fields = $property_enums->GetNext())
        $HOLDER_NAME[$enum_fields['ID']] = $enum_fields['VALUE'];


    $log_new = array();

    if ($_POST['select_head'] && $_POST['select_head'] != $arItem['PROPERTY_HEAD_VALUE'])
        array_push($log_new, "Ответственный НО: " . getUserById($arItem['PROPERTY_HEAD_VALUE']) . " -> " . getUserById($_POST['select_head']));

    if ($_POST['select_executor'] && $_POST['select_executor'] != $arItem['PROPERTY_EXECUTOR_VALUE'])
        array_push($log_new, "Исполнитель: " . getUserById($arItem['PROPERTY_EXECUTOR_VALUE']) . " -> " . getUserById($_POST['select_executor']));

    if ($_POST['select_holder'] != $arItem['PROPERTY_HOLDER_ENUM_ID'])
        array_push($log_new, "Новый держатель документа: {$arItem['PROPERTY_HOLDER_VALUE']} -> {$HOLDER_NAME[$_POST['select_holder']]}");
    // если есть что записывать в лог
    if ($log_new) {
        // добавляем в начало дату
        $log_new_str = date('m.d.y H:i') . ': ' . implode(" # ", $log_new);
        // добавляем к уже существующим логам
        array_push($logs, $log_new_str);
        // добавляем в свойства для записи
        $PROPERTY_VALUES['LOG'] = $logs;
    }

    CIBlockElement::SetPropertyValuesEx($_POST['id'], false, $PROPERTY_VALUES);

    header("Location: " . 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
    exit;

}
?>


    <div class="personal personal-edit-item">
        <?
        if ($CODE) {
            $rsItems = CIBlockElement::GetList(
                array('ID' => 'DESC'),
                array('IBLOCK_ID' => 22, 'ID' => $CODE),
                false,
                array('nPageSize' => 10/*, 'iNumPage' => $iNumPage*/),
                array('ID', 'NAME', 'PROPERTY_STATUS', 'PROPERTY_USER', 'PROPERTY_EMAIL', 'PROPERTY_PHONE', 'PROPERTY_OTVET', 'DATE_CREATE',
                    'PROPERTY_DIRECTOR', 'PROPERTY_HEAD', 'PROPERTY_EXECUTOR',
                    'PROPERTY_HOLDER', 'PROPERTY_COMPLETE',
                    'PROPERTY_LOG',
                    'PROPERTY_HEAD_PERSONALLY',
                )
            );
            $arItem = $rsItems->GetNext();
        }
        ?>

        <?
        // $arItem['PROPERTY_HOLDER_VALUE'] Начальник отдела
        // $arItem['PROPERTY_HOLDER_ENUM_ID'] 83
        // $arItem['PROPERTY_HOLDER_VALUE_ID'] 128445
        ?>


        <? if ($arItem['PROPERTY_COMPLETE_VALUE'] == 'Да'): ?>
            <h2>Ответ отправлен заявителю</h2>
        <? endif ?>

        <form name="form-question" id="form-question" method="POST" enctype="multipart/form-data">
            <?
            // Блокируем: если выполнено или если группа пользователя (DIRECTOR||HEAD||EXECUTOR) != Держателю (текущему)
            // || $HOLDER_ARR[$arItem['PROPERTY_HOLDER_ENUM_ID']][0] != $USER_GROUP )
            ?>
            <fieldset <?= ($arItem['PROPERTY_COMPLETE_VALUE'] == 'Да' ? 'disabled' : '') ?> >

                <input type='hidden' name='id' value="<?= $arItem['ID'] ?>">

                <div class="row">
                    <div class="col-lg-12">

                        <table class="minimal">

                            <tr>
                                <td> <!-- left -->
                                    <p class="personal-about-user"><b>Дата рег.</b><span><?= $arItem['DATE_CREATE'] ?></span></p>
                                    <p class="personal-about-user"><b>Заявитель</b><span><?= $arItem['PROPERTY_USER_VALUE'] ?></span></p>
                                    <p class="personal-about-user"><b>E-mail</b><span><?= $arItem['PROPERTY_EMAIL_VALUE'] ?></span></p>
                                    <p class="personal-about-user"><b>Телефон</b><span><?= $arItem['PROPERTY_PHONE_VALUE'] ?></span></p>

                                    <div class="divider"></div>

                                    <label>Вопрос</label>
                                    <br>
                                    <div class="personal-edit-item-q"><?= $arItem['NAME'] ?></div>


                                    <div class="divider"></div>

                                    <label for="otvet">Ответ заявителю</label>
                                    <br>
                                    <textarea name="otvet" id="otvet" placeholder="Ответ заявителю"><?= $arItem['PROPERTY_OTVET_VALUE']['TEXT'] ?></textarea>

                                    <br>

                                    <a href="#" data-toggle="modal" data-target="#logsModal" class="underline small">Посмотреть логи</a>

                                </td> <!-- ./left -->

                                <td> <!-- right -->


                                    <label>Комментарии</label> <br><br>
                                    <div class="personal-comments-container">
                                        <?
                                        $rsComments = CIBlockElement::GetList(
                                            array('ID' => 'DESC'),
                                            array('IBLOCK_ID' => 22, 'ID' => $CODE),
                                            false,
                                            array(),
                                            array('ID', 'NAME', 'PROPERTY_COMMENTS')
                                        );
                                        while ($arComment = $rsComments->GetNext()) {
                                            ?>
                                            <div class="personal-comment-container">
                                                <?= $arComment['~PROPERTY_COMMENTS_VALUE'] ?>
                                            </div>
                                            <?
                                        }
                                        ?>
                                    </div>
                                    <div class="personal-comments-add">
                                        <textarea name="comment" id="comment" placeholder="Написать комментарий"></textarea>
                                    </div>

                                    <div class="divider"></div>

                                    <label>Кому передан документ</label> <br>
                                    <select name="select_holder" id="select_holder">
                                        <? foreach ($HOLDER_ARR as $key => $value): ?>
                                            <option value="<?= $key ?>" <? if ($arItem['PROPERTY_HOLDER_ENUM_ID'] == $key): ?>selected<? endif ?>>
                                                <?= $value[1] ?>
                                            </option>
                                        <? endforeach ?>
                                    </select>

                                    <div class="divider"></div>

                                    <label>Руководитель</label> <br>
                                    <?= CUser::GetByID($arItem['PROPERTY_DIRECTOR_VALUE'])->Fetch()['LAST_NAME'] . ' ' . CUser::GetByID($arItem['PROPERTY_DIRECTOR_VALUE'])->Fetch()['NAME'] ?>

                                    &nbsp; &nbsp;
                                    <? if ($USER_ID == $arItem['PROPERTY_DIRECTOR_VALUE'] && !empty($arItem['PROPERTY_OTVET_VALUE']['TEXT']) && $arItem['PROPERTY_COMPLETE_VALUE'] != 'Да'): ?>
                                        <a href="javascript:void(0)" id="send-answer-btn" class="send-answer-btn">Отправить ответ</a>
                                    <? endif; ?>
                                    <div class="" id="note"></div>

                                    <script>
                                        $('#select_holder').on('change', function (e) {
                                            var optionSelected = $("option:selected", this); // выбранное значение
                                            var valueSelected = this.value; // value выбранного значения
                                            // if (valueSelected == 73) {
                                            //     $("#select_status_head").val(77);
                                            //     $('input[name="select_status_head"]').val(77);
                                            // }
                                        });
                                    </script>

                                    <div class="divider"></div>

                                    <label>Ответственный</label> <br>
                                    <?
                                    $disabled = '';
                                    if ($USER_GROUP == 'HEAD' || $USER_GROUP == 'EXECUTOR') $disabled = 'disabled'; // если НО или И, то редактирование НО запрещено
                                    $by = 'name';
                                    $order = 'asc';
                                    $rsUsers = CUser::GetList($by, $order, ['GROUPS_ID' => [10]]);
                                    ?>

                                    <select name="select_head" id="select_head" <?= $disabled ?>>
                                        <option value="">(не установлено)</option>
                                        <? while ($arUser = $rsUsers->GetNext()): ?>
                                            <option value="<?= $arUser['ID'] ?>" <? if ($arItem['PROPERTY_HEAD_VALUE'] == $arUser['ID']): ?>selected<? endif ?>>
                                                <?= $arUser['LAST_NAME'] . ' ' . $arUser['NAME'] . ' ' . $arUser['SECOND_NAME'] ?>
                                            </option>
                                        <? endwhile ?>
                                    </select>
                                    <? if ($disabled): ?>
                                        <input type="hidden" name="select_head" value="<?= $arItem['PROPERTY_HEAD_VALUE'] ?>">
                                    <? endif ?>

                                    <br>

                                    <div>
                                        <input type="checkbox" id="head_personally" name="head_personally" value="y"
                                            <?= ($arItem['PROPERTY_HEAD_PERSONALLY_VALUE'] == 'Да') ? 'checked' : '' ?>
                                            <?= $disabled ?>
                                        />
                                        <label for="head_personally">Исполнить лично</label>
                                        <? if ($disabled): ?>
                                            <input type="hidden" name="head_personally" value="<?= ($arItem['PROPERTY_HEAD_PERSONALLY_VALUE'] == 'Да') ? 'y' : '' ?>">
                                        <? endif ?>
                                    </div>

                                    <div class="divider"></div>

                                    Исполнитель <br>
                                    <?
                                    // Исполнитель
                                    $disabled = 'disabled';
                                    if ($USER_GROUP == 'HEAD') $disabled = ''; // Выбирать исп. может Ответственный
                                    if ($arItem['PROPERTY_HEAD_PERSONALLY_VALUE'] == 'Да') $disabled = 'disabled'; // Если "Исполнить лично" выбор заблокирован
                                    $rsUsers = CUser::GetList($by, $order, ['GROUPS_ID' => [11]]);
                                    ?>
                                    <select name="select_executor" id="select_executor" <?= $disabled ?>>
                                        <option value="">(не установлено)</option>
                                        <? while ($arUser = $rsUsers->GetNext()): ?>
                                            <option value="<?= $arUser['ID'] ?>" <? if ($arItem['PROPERTY_EXECUTOR_VALUE'] == $arUser['ID']): ?>selected<? endif ?>>
                                                <?= $arUser['LAST_NAME'] . ' ' . $arUser['NAME'] . ' ' . $arUser['SECOND_NAME'] ?>
                                            </option>
                                        <? endwhile ?>
                                    </select>
                                    <? if ($disabled): ?>
                                        <input type="hidden" name="select_executor" value="<?= $arItem['PROPERTY_EXECUTOR_VALUE'] ?>">
                                    <? endif ?>

                                    <div class="divider"></div>

                                    <input type="submit" name="action" value="Сохранить" id="submit" class="btn btn-info">


                                </td> <!-- ./right -->

                            </tr>

                        </table>

                    </div>
                </div>

            </fieldset>

        </form>


    </div>


    <br>
    <br>
    <br>
    <br>


    <!-- Modal -->
    <div class="modal fade" id="logsModal" tabindex="-1" role="dialog" aria-labelledby="logsModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="logsModalLabel">Логи</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="personal-logs">
                        <div class="personal-logs-container">
                            <?
                            $rsLogs = CIBlockElement::GetList(
                                array('ID' => 'DESC'),
                                array('IBLOCK_ID' => 22, 'ID' => $CODE),
                                false,
                                array(),
                                array('ID', 'NAME', 'PROPERTY_LOG')
                            );
                            while ($arLog = $rsLogs->GetNext()) {
                                ?>
                                <div class="personal-log-container">
                                    <?= $arLog['~PROPERTY_LOG_VALUE'] ?>
                                </div>
                                <?
                            }
                            ?>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                </div>
            </div>
        </div>
    </div>


    <div id="result"></div>

    <script>
        $(document).ready(function () {


            // TODO не понятно
            // $("#head_personally").change(function () {
            //     if (this.checked) {
            //         //$("#select_executor").prop("selectedIndex", 0);
            //         $("#select_executor").val('');
            //         $("#select_executor").prop('disabled', true);
            //     } else {
            //         $("#select_executor").prop('disabled', false);
            //     }
            // });

            // при назначении ответственного Держатель меняется на НО
            $('#select_head').on('change', function (e) {
                var optionSelected = $("option:selected", this);
                var valueSelected = this.value;
                if (valueSelected) {
                    $("#select_holder").val(83); // HEAD
                    $('input[name="select_holder"]').val(83);
                }
                else {
                    $("#select_holder").val(82); // DIRECTOR
                    $('input[name="select_holder"]').val(82);
                }
            });

            // при назначении И меняется Держатель на И
            $('#select_executor').on('change', function (e) {
                var optionSelected = $("option:selected", this);
                var valueSelected = this.value;
                if (valueSelected) {
                    $("#select_holder").val(84); // EXECUTOR
                    $('input[name="select_holder"]').val(84);
                }
                else {
                    $("#select_holder").val(83); // HEAD
                    $('input[name="select_holder"]').val(83);
                }
            });


            $('#submit').click(function (e) {

                // DIRECTOR HEAD EXECUTOR
                var userGroup = '<?=$USER_GROUP?>';

                // если держатель = НО, но сам НО не выбран - ошибка
                if ($('#select_holder').val() == 83 && $('#select_head').val() == '') {
                    alert('Необходимо выбрать Ответственного');
                    e.preventDefault();
                    return;
                }
                // если держатель = И, но сам И не выбран - ошибка
                if ($('#select_holder').val() == 84 && $('#select_executor').val() == '') {
                    alert('Необходимо выбрать Исполнителя');
                    e.preventDefault();
                    return;
                }

                // исполнитель не может напрямую передать Руководителю???
                if (userGroup == 'EXECUTOR' && $('#select_holder').val() == 82) {
                    alert('Исполнитель не может передать документ Руководителю');
                    e.preventDefault();
                    return;
                }
            });


            $('#send-answer-btn').click(function () {
                // уведомление об отправке
                if (confirm('Отправить ответ заявителю?')) {
                    // отправа сообщения по ajax
                    $.ajax({
                        url: '/personal/questions/action.php',
                        method: 'post',
                        dataType: 'html',
                        data: $('#form-question').serialize(),
                        success: function (data) {
                            $('#result').html(data);
                            window.location.reload();
                        }
                    });
                }
                else {
                    e.preventDefault();
                    return;
                }
            });


        });
    </script>

<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>