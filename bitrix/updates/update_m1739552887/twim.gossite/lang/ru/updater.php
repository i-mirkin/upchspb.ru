<?
$MESS["GOSSITE_NAME_UF_COUNTER_DOWNLOAD"] = "Количество скачиваний";
$MESS["GOSSITE_NAME_UF_SEND_MAIL_IR"] = 'Отправлять уведомления при смене статуса и/или ответе "Интернет-приемная"';
$MESS["GOSSITE_HELP_UF_SEND_MAIL_IR"] = "При смене статуса(свойство 'STATUS') или изменении текста ответа(свойство 'ANSWER'), будет отправлено, автору обращения, письмо на email(свойство 'E_MAIL_AUTHOR')";
$MESS["GOSSITE_NAME_UF_SEND_MAIL_QUEST"] = 'Отправка письма автору при добавлении ответа "Вопрос - ответ"';
$MESS["GOSSITE_HELP_UF_SEND_MAIL_QUEST"] = "При отмеченной опции, при активации элемента, на указанный email(свойство 'EMAIL'), будет отправлено письмо с ответом(свойство 'otvet')";

$MESS["GOSSITE_QUESTION_FORM_TYPE_NAME"] = 'Отправка сообщения через форму "Вопрос-ответ"';
$MESS["GOSSITE_QUESTION_FORM_DESCRIPTION"] = <<<DESCEXT
#AUTHOR# - Автор сообщения
#AUTHOR_EMAIL# - Email автора сообщения
#TEXT# - Текст сообщения
#ANSWER# - Ответ
#EMAIL_FROM# - Email отправителя письма
#EMAIL_TO# - Email получателя письма
#IBLOCK_ID# - iblock
#ID# - id элемента
DESCEXT;

$MESS["GOSSITE_ANSWER_FORM_TYPE_NAME"] = 'Получен ответ на сообщения через форму "Вопрос-ответ"';
$MESS["GOSSITE_ANSWER_FORM_DESCRIPTION"] = <<<DESCEXT
#AUTHOR# - Автор сообщения
#AUTHOR_EMAIL# - Email автора сообщения
#TEXT# - Текст сообщения
#ANSWER# - Ответ
#EMAIL_FROM# - Email отправителя письма
#EMAIL_TO# - Email получателя письма
#IBLOCK_ID# - iblock
#ID# - id элемента
DESCEXT;

$MESS["GOSSITE_IR_NEW_USER_TYPE_NAME"] = 'Зарегистрировался новый пользователь';
$MESS["GOSSITE_IR_NEW_USER_DESCRIPTION"] = <<<DESCEXT
#USER_ID# - ID пользователя
#LOGIN# - Логин
#EMAIL# - EMail
#NAME# - Имя
#LAST_NAME# - Фамилия
#USER_IP# - IP пользователя
#USER_HOST# - Хост
DESCEXT;

$MESS["GOSSITE_IR_FEEDBACK_FORM_TYPE_NAME"] = 'Отправка обращения через интернет-приемную';
$MESS["GOSSITE_IR_FEEDBACK_FORM_DESCRIPTION"] = <<<DESCEXT
#THEME# - Тема обращения
#NAME_AUTHOR# - Имя автора
#SURNAME_AUTHOR# - Фамилия автора
#SECOND_NAME_AUTHOR# - Отчество автора
#E_MAIL_AUTHOR# - Email автора сообщения
#COMPANY_AUTHOR# - Наименование организации (юридического лица)
#PHONE_AUTHOR# - Номер телефона
#CATEGORY# - Категория обращения
#AGENCY# - Орган обращения
#DATE# - Дата обращения
#EMAIL_TO# - Email получателя письма
#COAUTHOR# - соавторы(если есть)
#STATUS# - Статус обращения
#TEXT# - Текст сообщения
DESCEXT;

$MESS["GOSSITE_IR_CHANGE_STATUS_TYPE_NAME"] = 'Смена статуса обращения из интернет-приемную';
$MESS["GOSSITE_IR_CHANGE_STATUS_DESCRIPTION"] = <<<DESCEXT
#E_MAIL_AUTHOR# - Email автора сообщения
#STATUS# - Статус обращения
#TEXT# - Текст вопроса
#ID# - id элемента
DESCEXT;

$MESS["GOSSITE_IR_ADD_ANSWER_TYPE_NAME"] = 'Получен ответ на обращения из интернет-приемную';
$MESS["GOSSITE_IR_ADD_ANSWER_DESCRIPTION"] = <<<DESCEXT
#E_MAIL_AUTHOR# - Email автора сообщения
#STATUS# - Статус обращения
#TEXT# - Текст вопроса
#ANSWER# - Текст ответа
#ID# - id элемента
DESCEXT;
