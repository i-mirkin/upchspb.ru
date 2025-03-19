<?
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
    die();

use Bitrix\Main\Localization\Loc;
use Bitrix\Main\Context;

Loc::loadMessages(__FILE__);
function setDateModifPage()
{
    global $APPLICATION;
    $context = Context::getCurrent();
    $server = $context->getServer();
    $docRoot = $server->getDocumentRoot();
    $timeModif = filemtime($docRoot . $APPLICATION->GetCurPage(true));
    $dateModif = date("d.m.Y H:i", $timeModif);
    $timestamp_x = $APPLICATION->GetPageProperty("show_timestamp_x");
    if (empty($timestamp_x)) {
        $timestamp_x = $APPLICATION->GetDirProperty("show_timestamp_x");
    }
    if ($timestamp_x != "N" && $timeModif) {
        return '<div class="date-change-page">' . Loc::getMessage("DATE_TIMESTAMP_X_PAGE") . ': ' . $dateModif . '</div>';
    }
    else {
        return "";
    }
}

$isAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) && !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' && isset($_REQUEST['AJAX_PAGE']) && 'Y' == $_REQUEST['AJAX_PAGE'];
if ($isAjax) {
    die();
}
function columnPage()
{
    global $APPLICATION;
    $oneColumn = $APPLICATION->GetProperty("page_one_column");
    return ($oneColumn == "Y") ? "col-xs-12" : "col-sm-8 col-md-9";
} ?>

<? if ($IS_MAIN == 'N' || $IS_MAIN === null): ?>
    <? //=setDateModifPage();?>
    <? //$APPLICATION->ShowViewContent('item_timestamp_x');?>
    </div>
    </div>
    </div>
    </div>
<? endif; // is not main ?>


<? $APPLICATION->IncludeFile(
    SITE_DIR . "include/right_column.php",
    array(),
    array("MODE" => "text")
); ?>
</div>
</div>
</div>
</main>

<? // include footer
$pathFooter = SITE_TEMPLATE_PATH . "/include/footer/extended.php";
if (!empty($themeConfig["footer"]["type"])) {
    $pathFooter = SITE_TEMPLATE_PATH . "/include/footer/" . $themeConfig["footer"]["type"] . ".php";
};
$APPLICATION->IncludeFile(
    $pathFooter,
    array("OPTION_SITE" => $arOptionGosSite),
    array("MODE" => "php", "SHOW_BORDER" => false)
);
?>
<div class="fixed-panel hidden-print">
    <div class="icon-fixed">
        <? /*$APPLICATION->IncludeFile(
                SITE_DIR."include/fixed_block.php",
                Array("OPTION_SITE" => $arOptionGosSite),
                Array("MODE"=>"text", "SHOW_BORDER" => false)
             );*/ ?>
    </div>
</div>
<div class="right-btn-fixed">
    <a id="toTopSearch" class="right-btn-fixed__item right-btn-fixed__item--search"></a>
    <a href="#special" class="right-btn-fixed__item right-btn-fixed__item--special special"></a>
    <a id="toTop" class="right-btn-fixed__item right-btn-fixed__item--top"></a>

</div>

<div class="soundbar soundbar_hide hide" data-toggle="tooltip" data-placement="left" title="<?= Loc::getMessage("FOOTER_SPEEK_HELP") ?>">
    <div class="loader soundbar_loader soundbar_loader_hide">
        <div></div>
    </div>
    <div class="soundbar__play"><i class="fa fa-volume-up" aria-hidden="true"></i></div>
    <div class="soundbar__timers soundbar__timers_hide">
        <div class="soundbar__duration-time"></div>
        <div class="soundbar__stop"><i class="fa fa-stop" aria-hidden="true"></i></div>
        <div class="soundbar__curretn-time">00:00</div>
    </div>
</div>
<div class="modal fade modal_doc" id="modal_doc" tabindex="-1" role="dialog" aria-labelledby="modal_doc_viewer">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h5 class="modal-title" id="modal_doc_viewer">&nbsp;</h5>
            </div>
            <div class="modal-body"></div>
        </div>
    </div>
</div>
<div class="modal fade center modal_classic" tabindex="-1" role="dialog" id="modal_classic">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">&nbsp;</h4>
            </div>
            <div class="modal-body"></div>
        </div>
    </div>
</div>

<div class="modal fade center modal_classic in" id="formSendModal" tabindex="-1" role="dialog" id="modal_success">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                <div class="form-send-success success-popup"></div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade center modal_classic in" id="formSendModalError" tabindex="-1" role="dialog" id="modal_error">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                <div class="form-send-error error-popup"></div>
            </div>
        </div>
    </div>
</div>

<? $APPLICATION->IncludeComponent(
    "bitrix:main.userconsent.request",
    "",
    array(
        "ID" => USER_AGREEMENT,
        "IS_CHECKED" => "Y",
        "AUTO_SAVE" => "Y",
        "IS_LOADED" => "N",
        'HIDE' => "Y",
        "REPLACE" => array(
            'button_caption' => '',
        ),
        'INPUT_NAME' => 'buser_consent_check_param'
    )
); ?>
<script type="text/javascript">
    (function (m, e, t, r, i, k, a) {
        m[i] = m[i] || function () {
            (m[i].a = m[i].a || []).push(arguments)
        };
        m[i].l = 1 * new Date();
        k = e.createElement(t), a = e.getElementsByTagName(t)[0], k.async = 1, k.src = r, a.parentNode.insertBefore(k, a)
    })
    (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");

    ym(24971677, "init", {
        clickmap: true,
        trackLinks: true,
        accurateTrackBounce: true,
        webvisor: true
    });
</script>


<script>
    $(document).ready(function () {
        $('.news-list-stuff').on('contextmenu', function (e) {
            return false;
        });
    });

    document.addEventListener('dragstart', function (e) {
        // Проверяем, что событие произошло на <img> внутри блока с классом "news-list-stuff"
        if (e.target.tagName === 'IMG' && e.target.closest('.news-list-stuff')) {
            e.preventDefault(); // Запрещаем перетаскивание
        }
    });
</script>


<script>
    // im
    $(document).ready(function () {
        function updateBadge() {
            $.ajax({
                url: '/personal/questions/getbadge.php',
                method: 'post',
                dataType: 'json',
                data: {},
                success: function (data) {
                    //console.log(data);
                    //$('#personal-header-badges').html('');
                    let reload = false;
                    console.log(data);

                    if (data.MY > 0) {
                        if ($('#personal-header-badge-MY').length > 0) { // бейдж уже есть
                            if (parseInt($('#personal-header-badge-MY').text()) != data.MY) {
                                $('#personal-header-badge-MY').text(data.MY);
                                reload = true;
                            }
                        } else { // нет бейджа
                            $('#personal-header-badges').append('<a href="/personal/questions/?filter_holder=my" id="personal-header-badge-MY" class="MY" title="Мои документы">' + data.MY + '</a>');
                        }
                    }

                    if (data.HEAD > 0) {
                        if ($('#personal-header-badge-HEAD').length > 0) { // бейдж уже есть
                            if (parseInt($('#personal-header-badge-HEAD').text()) != data.HEAD) {
                                $('#personal-header-badge-HEAD').text(data.HEAD);
                                reload = true;
                            }
                        } else { // нет бейджа
                            $('#personal-header-badges').append('<a href="/personal/questions/?filter_holder=head"  id="personal-header-badge-HEAD" class="HEAD" title="У моих ответсвенных">' + data.HEAD + '</a>');
                        }
                    }

                    if (data.EXECUTOR > 0) {
                        if ($('#personal-header-badge-EXECUTOR').length > 0) { // бейдж уже есть
                            if (parseInt($('#personal-header-badge-EXECUTOR').text()) != data.EXECUTOR) {
                                $('#personal-header-badge-EXECUTOR').text(data.EXECUTOR);
                                reload = true;
                            }
                        } else { // нет бейджа
                            $('#personal-header-badges').append('<a href="/personal/questions/?filter_holder=executor" id="personal-header-badge-EXECUTOR" class="EXECUTOR" title="У моих исполнителей">' + data.EXECUTOR + '</a>');
                        }
                    }
                    if (reload && window.location.pathname == '/personal/questions/') { // если в списке и надо обновить
                        window.location.reload();
                    }
                }
            });
        }

        updateBadge();
        var updateInterval = setInterval(updateBadge, 5000);
        // to clear interval: clearInterval(updateInterval);


        // запись на прием
        $('.appointment form').submit(function (e) {
            e.preventDefault();
            var error = 0;
            var $form = $(this);
            $(this).find('input, textarea, select').each(function () {
                $(this).removeClass("error");
            })
            $form.find('.form-result').html("").hide();


            // *specail for appointment check date-time choose
            $form.find('.shedule-title').removeClass("error");
            if ($form.find('[name="hours"]:checked').val() === undefined) {
                $form.find('.shedule-title').addClass("error");
                return;
            } else {
                // если всё в порядке в соответствии с выбором по полю data-date заполняем скрытое поле для даты
                $form.find('[name="date"]').val($form.find('[name="hours"]:checked').data('date'));
            }
            // *end


            $(this).find('input[type=text], input[type=date], input[type=email], textarea, select').each(function () {
                if ($(this).hasClass('required') && $(this).val() == "") {
                    $(this).addClass("error");
                    error++;
                }
            });
            $(this).find('input:checkbox').each(function () {
                if ($(this).hasClass('required')) if (!$(this).prop("checked")) {
                    $(this).addClass("error");
                    error++;
                }
            });

            if (error > 0) {
                $form.find('.form-result').html("<div class='result__error'>Заполните обязательные поля.</div>").show();
                return;
            }

            var http = new XMLHttpRequest(), f = this;
            http.open("POST", "/local/ajax/action.php", true);
            http.onreadystatechange = function () {
                if (http.readyState === 4 && http.status === 200) {
                    DATA = JSON.parse(http.responseText);
                    console.log(DATA);
                    if (DATA.RESULT === "OK") {
                        $('#formSendModal .modal-body').text(DATA.MESSAGE);
                        $('#formSendModal').modal('show');
                        // закрытие formSendModal => переход на /
                        // $form.find('input[type=text], input[type=date], input[type=email], textarea, select').each(function () {$(this).val("");});
                    } else {
                        $form.find('.form-result').html(DATA.MESSAGE).show();
                        error++;
                        return;
                    }
                }
            }
            http.onerror = function () {
                $form.find('.result').html("<div class='result__error'>При отправке возникла ошибка</div>").show();
                error = true;
            }
            http.send(new FormData(f));
        });


    });
</script>

<? //require_once('themes/control.php');?>
</body>
</html>