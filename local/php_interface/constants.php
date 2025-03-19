<?php
// Свойство У кого документ из инфоблока Вопрос - ответ
const HOLDER_DIRECTOR_ID = 82;
const HOLDER_HEAD_ID = 83;
const HOLDER_EXECUTOR_ID = 84;

switch(SITE_ID) {
    case 's1':
        define('SCHEDULE_PROPERTY_STATUS_Y',28);
        define('SCHEDULE_PROPERTY_STATUS_N',29);
        define('USER_AGREEMENT', 1);
    break;
    case 'en':
        define('SCHEDULE_PROPERTY_STATUS_Y',40);
        define('SCHEDULE_PROPERTY_STATUS_N',41); 
        define('USER_AGREEMENT', 2);
    break;
}