<?php

// окончания у слов, взависимости от количества
function human_plural_form_od($number, $titles){
    $cases = array (2, 0, 1, 1, 1, 2);
    return $titles[($number%100 >4 && $number%100< 20)? 2 : $cases[min($number%10, 5)] ];
}

function SetUserFieldOD ($entity_id, $value_id, $uf_id, $uf_value) //запись значения
{
    return $GLOBALS["USER_FIELD_MANAGER"]->Update ($entity_id, $value_id,
    Array ($uf_id => $uf_value));
}
 
function GetUserFieldOD ($entity_id, $value_id, $uf_id) //считывание значения
{
    $arUF = $GLOBALS["USER_FIELD_MANAGER"]->GetUserFields ($entity_id, $value_id);
    return $arUF[$uf_id]["VALUE"];
}
 
// отдача файла
function file_force_download_od($file, $name='') {
  if (file_exists($file)) {
    // сбрасываем буфер вывода PHP, чтобы избежать переполнения памяти выделенной под скрипт
    // если этого не сделать файл будет читаться в память полностью!
    if (ob_get_level()) {
      ob_end_clean();
    }
    if($name=="") $name = $file;
    // заставляем браузер показать окно сохранения файла
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename=' . basename($name));
    header('Content-Transfer-Encoding: binary');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($file));
    // читаем файл и отправляем его пользователю
    readfile($file);
    exit;
  }
}
