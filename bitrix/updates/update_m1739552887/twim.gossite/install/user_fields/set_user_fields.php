<?php
$arListEntity = [];
$rsData = CUserTypeEntity::GetList( array($by=>$order), array() );
while($arRes = $rsData->Fetch())
{
    $arListEntity[$arRes["FIELD_NAME"]] = $arRes["ENTITY_ID"];
}

$oUserTypeEntity    = new CUserTypeEntity();

if(!$arListEntity['UF_COUNTER_DOWNLOAD'] == 'OPEN_DATA'){
// counter open data download file
$aUserFields  = array(
    'ENTITY_ID'         => 'OPEN_DATA',
    'FIELD_NAME'        => 'UF_COUNTER_DOWNLOAD',
    'USER_TYPE_ID'      => 'integer',
    'XML_ID'            => 'XML_ID_COUNTER_DOWNLOAD',
    'SORT'              => 100,
    'MULTIPLE'          => 'N',
    'MANDATORY'         => 'N',
    'EDIT_IN_LIST'      => '',
    'IS_SEARCHABLE'     => 'N',
    'SETTINGS'          => array(
        'DEFAULT_VALUE' => '',
        'SIZE'          => '20',
        'ROWS'          => '1',
        'MIN_LENGTH'    => '0',
        'MAX_LENGTH'    => '0',
        'REGEXP'        => '',
    ),
    'EDIT_FORM_LABEL'   => array(
        'ru'    => getMessage("GOSSITE_NAME_UF_COUNTER_DOWNLOAD"),
        'en'    => 'Count download file opendata',
    ),
    'LIST_COLUMN_LABEL' => array(
        'ru'    => getMessage("GOSSITE_NAME_UF_COUNTER_DOWNLOAD"),
        'en'    => 'Count download file opendata',
    ),
    'LIST_FILTER_LABEL' => array(
        'ru'    => getMessage("GOSSITE_NAME_UF_COUNTER_DOWNLOAD"),
        'en'    => 'Count download file opendata',
    ),
);
$oUserTypeEntity->Add($aUserFields);
}

// internet-reciption flag iblock
if(!$arListEntity['UF_SEND_MAIL_IR'] == 'ASD_IBLOCK'){
$aUserFields  = array (
    'ENTITY_ID' => 'ASD_IBLOCK',
    'FIELD_NAME' => 'UF_SEND_MAIL_IR',
    'USER_TYPE_ID' => 'boolean',
    'XML_ID' => 'SEND_MAIL_IR',
    'SORT' => '100',
    'MULTIPLE' => 'N',
    'MANDATORY' => 'N',
    'SHOW_FILTER' => 'N',
    'SHOW_IN_LIST' => 'Y',
    'EDIT_IN_LIST' => 'Y',
    'IS_SEARCHABLE' => 'N',
    'SETTINGS' => 
    array (
      'DEFAULT_VALUE' => 0,
      'DISPLAY' => 'CHECKBOX',
      'LABEL_CHECKBOX' => '',
    ),
    'EDIT_FORM_LABEL' => 
    array (
      'en' => '',
      'ru' => getMessage("GOSSITE_NAME_UF_SEND_MAIL_IR"),
    ),
    'LIST_COLUMN_LABEL' => 
    array (
      'en' => '',
      'ru' => getMessage("GOSSITE_NAME_UF_SEND_MAIL_IR"),
    ),
    'LIST_FILTER_LABEL' => 
    array (
      'en' => '',
      'ru' => '',
    ),
    'ERROR_MESSAGE' => 
    array (
      'en' => '',
      'ru' => '',
    ),
    'HELP_MESSAGE' => 
    array (
      'en' => '',
      'ru' => getMessage("GOSSITE_HELP_UF_SEND_MAIL_IR"),
    ),
  );
$oUserTypeEntity->Add($aUserFields);
}

// question flag iblock
if(!$arListEntity['UF_SEND_MAIL_QUEST'] == 'ASD_IBLOCK'){
$aUserFields  = array (
    'ENTITY_ID' => 'ASD_IBLOCK',
    'FIELD_NAME' => 'UF_SEND_MAIL_QUEST',
    'USER_TYPE_ID' => 'boolean',
    'XML_ID' => 'SEND_MAIL_QUEST',
    'SORT' => '100',
    'MULTIPLE' => 'N',
    'MANDATORY' => 'N',
    'SHOW_FILTER' => 'N',
    'SHOW_IN_LIST' => 'Y',
    'EDIT_IN_LIST' => 'Y',
    'IS_SEARCHABLE' => 'N',
    'SETTINGS' => 
    array (
      'DEFAULT_VALUE' => 0,
      'DISPLAY' => 'CHECKBOX',
      'LABEL_CHECKBOX' => '',
    ),
    'EDIT_FORM_LABEL' => 
    array (
      'en' => '',
      'ru' => getMessage("GOSSITE_NAME_UF_SEND_MAIL_QUEST")
    ),
    'LIST_COLUMN_LABEL' => 
    array (
      'en' => '',
      'ru' => getMessage("GOSSITE_NAME_UF_SEND_MAIL_QUEST"),
    ),
    'LIST_FILTER_LABEL' => 
    array (
      'en' => '',
      'ru' => '',
    ),
    'ERROR_MESSAGE' => 
    array (
      'en' => '',
      'ru' => '',
    ),
    'HELP_MESSAGE' => 
    array (
      'en' => '',
      'ru' => getMessage("GOSSITE_HELP_UF_SEND_MAIL_QUEST"),
    ),
  );
$oUserTypeEntity->Add($aUserFields);
}