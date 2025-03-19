<?php
$MESS["MAIN_OPT_FEEDBACK_SUBJECT"] = "#SITE_NAME#: Сообщение из формы обратной связи \"Сообщить о факте коррупции\"";
$MESS["MAIN_OPT_FEEDBACK_MESSAGE"] = <<<MESSAGEMAIL
Сообщение о факте коррупции с сайта #SITE_NAME#
------------------------------------------
/n
Вам было отправлено сообщение через форму обратной связи
/n
Автор: #AUTHOR#
E-mail автора: #AUTHOR_EMAIL#
/n
Текст сообщения:
#TEXT#
/n
Сообщение сгенерировано автоматически.
MESSAGEMAIL;

$MESS["GOSSITE_ANSWER_FORM_SUBJECT"] = "Получен ответ на Ваш вопрос. Сайт #SITE_NAME#";
$MESS["GOSSITE_ANSWER_FORM_MESSAGE"] = <<<MESSAGEEXT
На Ваш вопрос был дан ответ в разделе  "Вопрос-ответ" сайта   #SITE_NAME#
------------------------------------------

Вопрос:
#TEXT#

Ответ:
#ANSWER#

Ссылка на вопрос с сайта:

http://#SERVER_NAME#/appeals/vopros-otvet/detail.php?ID=#ID#

Сообщение сгенерировано автоматически.
MESSAGEEXT;

$MESS["GOSSITE_QUESTION_FORM_SUBJECT"] = "#SITE_NAME#: Сообщение из формы \"Вопрос-ответ\"";
$MESS["GOSSITE_QUESTION_FORM_MESSAGE"] = <<<MESSAGEEXT
Сообщение из формы "Вопрос-ответ" с сайта #SITE_NAME#
------------------------------------------

Вам было отправлено сообщение через форму "Вопрос-ответ"

Автор: #AUTHOR#
E-mail автора: #AUTHOR_EMAIL#

Вопрос:
#TEXT#

Ссылка на вопрос для проверки и ответа:

http://#SERVER_NAME#/bitrix/admin/iblock_element_edit.php?IBLOCK_ID=#IBLOCK_ID#&type=internet_reception&ID=#ID#&lang=ru&find_section_section=-1

Сообщение сгенерировано автоматически.
MESSAGEEXT;

$MESS["GOSSITE_IR_NEW_USER_SUBJECT"] = "Вы успешно зарегистрировались на сайте #SITE_NAME#";
$MESS["GOSSITE_IR_NEW_USER_MESSAGE"] = <<<MESSAGEEXT
Информационное сообщение сайта #SITE_NAME#
------------------------------------------

Вы успешно зарегистрирован на #SERVER_NAME#.

Имя: #NAME#
Фамилия: #LAST_NAME#
E-Mail: #EMAIL#
Логин: #LOGIN#

Письмо сгенерировано автоматически.
MESSAGEEXT;

$MESS["GOSSITE_IR_FEEDBACK_FORM_SUBJECT"] = "Новое обращение с сайта #SITE_NAME#";
$MESS["GOSSITE_IR_FEEDBACK_FORM_MESSAGE"] = <<<MESSAGEEXT
C Вашего сайта "#SITE_NAME#", адрес <a href="http:/#SERVER_NAME#">#SERVER_NAME#</a>, пришло обращение <br>
<br>
<br>
<b>Тема обращения</b>: #THEME# <br>
<b>Дата обращения</b>: #DATE# <br>
<b>ФИО заявителя</b>: #SURNAME_AUTHOR# #NAME_AUTHOR# #SECOND_NAME_AUTHOR#<br>
<b>Адрес проживания заявителя</b>: #ADDRESS# <br>
<b>Телефон заявителя для связи</b>: #PHONE_AUTHOR#<br>
<b>E-mail заявителя для ответа</b>: #E_MAIL_AUTHOR# <br>
<b>Наименование организации (юридического лица)</b>: #COMPANY_AUTHOR# <br>
<b> Категория обращения</b>: #CATEGORY#<br>
<b> Орган обращения</b>: #AGENCY#<br>
<b>Cоавторы(если есть)</b>: #COAUTHOR#<br>
<b>Статус</b>: #STATUS#<br>
<b>Текст обращения</b>: <br>
#TEXT# <br>
<br>
<br>
Для просмотра всех обращений, необходимо перейти в панель управления Вашего сайта.<br>
Письмо сгенерировано автоматически, не отправляйте ответ на #DEFAULT_EMAIL_FROM#
MESSAGEEXT;

$MESS["GOSSITE_IR_FEEDBACK_FORM_USER_SUBJECT"] = "Вы создали новое обращение на сайте #SITE_NAME#";
$MESS["GOSSITE_IR_FEEDBACK_FORM_USER_MESSAGE"] = <<<MESSAGEEXT
Вы создали новое обращение на сайте "#SITE_NAME#", адрес <a href="http:/#SERVER_NAME#">#SERVER_NAME#</a>.<br>
<br>
<b>Тема обращения</b>: #THEME# <br>
<b>Дата обращения</b>: #DATE# <br>
<b>ФИО заявителя</b>: #SURNAME_AUTHOR# #NAME_AUTHOR# #SECOND_NAME_AUTHOR#<br>
<b>Телефон заявителя для связи</b>: #PHONE_AUTHOR#<br>
<b>E-mail заявителя для ответа</b>: #E_MAIL_AUTHOR# <br>
<b>Наименование организации (юридического лица)</b>: #COMPANY_AUTHOR#<br>
<b> Категория обращения</b>: #CATEGORY#<br>
<b> Орган обращения</b>: #AGENCY#<br>
<b>Cоавторы(если есть)</b>: #COAUTHOR#<br>
<b>Статус</b>: #STATUS#<br>
<b>Текст обращения</b>: <br>
#TEXT#<br>
<br>
Письмо сгенерировано автоматически, не отправляйте ответ на #DEFAULT_EMAIL_FROM#.<br>
Если Вы зарегистрированы, то Вам доступен просмотр обращения в личном кабинете.
MESSAGEEXT;

$MESS["GOSSITE_IR_ADD_ANSWER_SUBJECT"] = "Получен ответ в Вашем обращении на сайте #SITE_NAME#";
$MESS["GOSSITE_IR_ADD_ANSWER_MESSAGE"] = <<<MESSAGEEXT
<div>
    Получен ответ на Ваше обращение на сайте "#SITE_NAME#", адрес <a href="http:/#SERVER_NAME#">#SERVER_NAME#</a>. <br>
</div>
<br>
<b>Вопрос</b>:<br>
#TEXT#<br>
<br>
<b>Ответ на обращение</b>:<br>
<div>
#ANSWER#
</div>
<br>
<div>
    Ссылка, если у Вас создан личный кабинет:<br>
    <a href="http://#SERVER_NAME#/appeals/internet-reception/personal/list/detail.php?id=#ID#">http://#SERVER_NAME#/appeals/internet-reception/personal/list/detail.php?id=#ID#</a><br>
</div>
<br>
Письмо сгенерировано автоматически, не отправляйте ответ на #DEFAULT_EMAIL_FROM#.<br>
Если Вы зарегистрированы, то Вам доступен просмотр обращения в личном кабинете.
MESSAGEEXT;

$MESS["GOSSITE_IR_CHANGE_STATUS_SUBJECT"] = "Изменение статуса Вашего обращения на сайте #SITE_NAME#";
$MESS["GOSSITE_IR_CHANGE_STATUS_MESSAGE"] = <<<MESSAGEEXT
Изменение статуса Вашего обращения на сайте "#SITE_NAME#", адрес <a href="http:/#SERVER_NAME#">#SERVER_NAME#</a>.<br>
<br>
<b>Вопрос</b>:<br>
#TEXT#<br>
<br>
<b>Новый статус</b>: <br>
<div>
#STATUS#
</div>
<br>
<div>
    Ссылка, если у Вас создан личный кабинет:<br>
    <a href="http://#SERVER_NAME#/appeals/internet-reception/personal/list/detail.php?id=#ID#">http://#SERVER_NAME#/appeals/internet-reception/personal/list/detail.php?id=#ID#</a><br>
</div>
<br>
Письмо сгенерировано автоматически, не отправляйте ответ на #DEFAULT_EMAIL_FROM#.<br>
Если Вы зарегистрированы, то Вам доступен просмотр обращения в личном кабинете.
MESSAGEEXT;
