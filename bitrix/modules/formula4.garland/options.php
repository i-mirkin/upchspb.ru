<?php
	if($USER->IsAdmin()) {
		IncludeModuleLangFile(__FILE__);

		$module_id = 'formula4.garland';

		$arAllOptions = Array(
			GetMessage('SETTINGS'),
			Array('ENABLED', GetMessage('ENABLED'), COption::GetOptionString($module_id, 'ENABLED'), Array('checkbox')),
			Array('OVER', GetMessage('OVER'), COption::GetOptionString($module_id, 'OVER'), Array('checkbox')),
			Array('SOUND', GetMessage('SOUND'), COption::GetOptionString($module_id, 'SOUND'), Array('checkbox')),
			
		);

		if($REQUEST_METHOD=='POST' && check_bitrix_sessid()) {

			foreach($arAllOptions as &$option) {
				if(!is_array($option) || isset($option['note'])) continue;

				$name = $option[0];
				$val = $_REQUEST[$name];
				if($option[3][0] == 'checkbox' && $val != 'Y') $val = 'N';

				COption::SetOptionString($module_id, $name, $val, $option[1]);

				$option[2] = $_REQUEST[$name];
			}
		}

		$aTabs[] = array('DIV' => 'set', 'TAB' => GetMessage('MAIN_TAB'), 'TITLE' => GetMessage('MAIN_TAB'));
		$tabControl = new CAdminTabControl('tabControl', $aTabs);

		?>

		<form method="POST" enctype="multipart/form-data" action="<?echo $APPLICATION->GetCurPage()?>?mid=<?=htmlspecialcharsbx($mid)?>&lang=<?=LANGUAGE_ID?>" name="garland">
			<?$tabControl->Begin();?>
			<?$tabControl->BeginNextTab();?>

			<?__AdmSettingsDrawList($module_id, $arAllOptions);?>

			

			<?$tabControl->Buttons();?>
			<input type="submit" name="save" value="<?echo GetMessage('SAVE')?>"/>
			<?=bitrix_sessid_post();?>

			<?$tabControl->EndTab();?>
			<?$tabControl->End();?>
		</form>

		
<? } ?>
