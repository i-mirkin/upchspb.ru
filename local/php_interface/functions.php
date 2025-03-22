<?

function dump($r)
{
    global $USER;
    if ($USER->IsAdmin()) {
        echo '<pre>';
        print_r($r);
        echo '</pre>';
    }
}
// перед отправкой письма подписчику добавляет в письма рассылки ссылку для отписки
//AddEventHandler("subscribe", "BeforePostingSendMail", "BeforePostingSendMailHandler");
function BeforePostingSendMailHandler($arFields)
{
    $rs = CSubscription::GetByEmail($arFields["EMAIL"]);
    $unsubsLink = '';
    if ($ar = $rs->Fetch()) $unsubsLink = '?ID=' . $ar['ID'] . '&CONFIRM_CODE=' . $ar['CONFIRM_CODE'] . '&action=unsubscribe';
    $arFields["BODY"] = str_replace("#UNSUBSCRIBE#", $unsubsLink, $arFields["BODY"]);
    return $arFields;
}

// автоматически удаляет подписку (подписчика), если она была деактивирована (он был деактивирован),
// и перенаправляет пользователя на страницу подписок с параметром, который можно использовать для отображения уведомления об успешном удалении
AddEventHandler("subscribe", "OnStartSubscriptionUpdate", "OnStartSubscriptionUpdateHandler");
function OnStartSubscriptionUpdateHandler($arFields)
{
    if (!defined("ADMIN_SECTION") || ADMIN_SECTION !== true) { // не делать редирект если в админке
        if ($arFields['ACTIVE'] == 'N' && !empty($arFields['ID'])) {
            CSubscription::Delete($arFields['ID']);
            LocalRedirect('/subscribe/?subs=deleted');
        }
    }
}

AddEventHandler('main', 'OnBeforeEventSend', 'setRecipientDev');
function setRecipientDev(&$arFields, &$arTemplate) {
    $arTemplate['EMAIL_TO'] = 'i.mirkin@yandex.ru';
    $arTemplate['BCC'] = 'i.mirkin@yandex.ru';
}

function num_decline($number, $titles, $show_number = 1)
{
    if (is_string($titles))
        $titles = preg_split('/, */', $titles);
    // когда указано 2 элемента
    if (empty($titles[2]))
        $titles[2] = $titles[1];
    $cases = [2, 0, 1, 1, 1, 2];
    $intnum = abs((int)strip_tags($number));
    $title_index = ($intnum % 100 > 4 && $intnum % 100 < 20)
        ? 2
        : $cases[min($intnum % 10, 5)];
    return ($show_number ? "$number " : '') . $titles[$title_index];
}

