<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
CModule::IncludeModule("iblock");
global $USER;

//$_POST['action'] = 'find_executor';
//$_POST['id_executor'] = 6;

if($_POST['action'] == 'find_executor'){
	$id_executor = $_POST['id_executor'];
	$rsUser = CUser::GetList($by, $order,
		array(
			"ID" => $id_executor,
		),
		array(
			"SELECT" => array(
				"UF_DEPARTMENT",
			),
		)
	);
	if($arUser = $rsUser->Fetch())
	{
		$rsDepartment = CUserFieldEnum::GetList(array(), array(
			"ID" => $arUser["UF_DEPARTMENT"],
		));
		if($arDepartment = $rsDepartment->GetNext()){
			
			//print_r($arDepartment);
			$rsUser = CUser::GetList($by, $order,
				array(
					"UF_DEPARTMENT" => $arDepartment['ID'],
					"GROUPS_ID" => array(10)
				),
				array(
					"SELECT" => array(
						"ID",
					),
				)
			);
			if($arUser = $rsUser->Fetch()) {
				echo $arUser['ID'];
			}
		}
			 
	}
	
	
	
	
	
}





?>