<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
require_once($_SERVER['DOCUMENT_ROOT']."/bitrix/modules/main/install/wizard_sol/wizard.php");

class CSiteLicenseNew extends CWizardStep
{

	function InitStep()
	{
        $wizard =& $this->GetWizard();
		$wizard->solutionName = "gossite";
        $this->SetStepID("license");
		$this->SetTitle(GetMessage("WIZ_STEP_LICENSE"));
		$this->SetTitle(GetMessage("MAIN_WIZARD_LICENSE_STEP_TITLE"));
		$this->SetSubTitle(GetMessage("MAIN_WIZARD_LICENSE_STEP_SUBTITLE"));
		$this->SetNextCaption(GetMessage("NEXT_BUTTON"));
        if(defined("WIZARD_DEFAULT_SITE_ID")){
            $this->SetNextStep("select_template");
        } else{
            $this->SetNextStep("select_site");
        }	
	}

	function OnPostForm()
	{
		$wizard = $this->GetWizard();

		if ($wizard->IsPrevButtonClick())
			return;

		$agree = $wizard->GetVar("__agree_license");
		if ($agree != "Y")
			$this->SetError(GetMessage("MAIN_WIZARD_LICENSE_STEP_ERROR"));
	}

	function ShowStep()
	{
		$wizard = $this->GetWizard();
        
		if (strlen($this->content) == 0)
			$this->content .= GetMessage("MAIN_WIZARD_LICENSE_STEP_CONTENT");
       
		$licensePath = $wizard->GetPath() . '/license.php';

		$this->content .= '<div class="wizard-iframe-container"><iframe name="license_text" src="'.$licensePath.'" width="100%" height="160" border="0" frameBorder="1" vspace="5" scrolling="yes" class="wizard-license-iframe"></iframe></div>';
		$this->content .= $this->ShowCheckboxField("__agree_license", "Y", Array("id" => "agree_license_id"));
		$this->content .= '<label for="agree_license_id">'.GetMessage("MAIN_WIZARD_LICENSE_STEP_AGREE").'</label>';

	}
}

class SelectSiteStep extends CSelectSiteWizardStep
{
	function InitStep()
	{
		parent::InitStep();

		$wizard =& $this->GetWizard();
		$wizard->solutionName = "gossite";
        $this->SetPrevStep("license");
		$this->SetPrevCaption(GetMessage("PREVIOUS_BUTTON"));
	}
}


class SelectTemplateStep extends CSelectTemplateWizardStep
{
    function InitStep()
	{
        parent::InitStep();
		$this->SetNextStep("site_settings");
	}
}

class SelectThemeStep extends CSelectThemeWizardStep
{

}

class SiteSettingsStep extends CSiteSettingsWizardStep
{
	function InitStep()
	{
		parent::InitStep();
        $this->SetPrevStep("select_template");
        
        $wizard =& $this->GetWizard();
		$wizard->solutionName = "gossite";
        
		$siteLogo = "/upload/twim.gossite/logo.svg";
        $bossLogo = "/upload/twim.gossite/boss.jpg";
        
		$wizard->SetDefaultVars(
			Array(
				"siteLogo" => $siteLogo,
				"siteSlogan" => $this->GetFileContent(WIZARD_SITE_PATH."include/title-site.php", GetMessage("WIZ_COMPANY_SLOGAN_DEF")),
				"sitePhone" => GetMessage("WIZ_COMPANY_PHONE_DEF"),
                "siteEmail" =>  GetMessage("WIZ_COMPANY_MAIL_DEF"),
                "siteEmailForm" =>  GetMessage("WIZ_COMPANY_MAIL_FORM_DEF"),
                "siteAddress" =>  GetMessage("WIZ_COMPANY_ADDRESS_DEF"),
				"siteMetaDescription" => GetMessage("wiz_site_desc"),
				"siteMetaKeywords" => GetMessage("wiz_keywords"), 
                "photoBoss" => $bossLogo,
                "fio_boss" => GetMessage("WIZ_COMPANY_EXAMPLE_FIO_BOSS_DEF"),
                "post_boss" => GetMessage("WIZ_COMPANY_EXAMPLE_POST_BOSS_DEF"),
			)
		);	
	}

	function ShowStep()
	{
		$wizard =& $this->GetWizard();
				
		$this->content .= '<div class="wizard-upload-img-block"><div class="wizard-catalog-title">'.GetMessage("WIZ_COMPANY_SLOGAN").'</div>';
		$this->content .= $this->ShowInputField("textarea", "siteSlogan", Array("id" => "site-slogan", "class" => "wizard-field", "rows"=>"3"))."</div>";

		$this->content .= '<div class="wizard-upload-img-block"><div class="wizard-catalog-title">'.GetMessage("WIZ_COMPANY_PHONE_DES").'</div>';
		$this->content .= $this->ShowInputField("text", "sitePhone", Array("id" => "site-phone", "class" => "wizard-field"))."</div>";
        
        $this->content .= '<div class="wizard-upload-img-block"><div class="wizard-catalog-title">'.GetMessage("WIZ_COMPANY_MAIL_DES").'</div>';
		$this->content .= $this->ShowInputField("text", "siteEmail", Array("id" => "site-email", "class" => "wizard-field"))."</div>";
        
        $this->content .= '<div class="wizard-upload-img-block"><div class="wizard-catalog-title">'.GetMessage("WIZ_COMPANY_MAIL_FORM_DES").'</div>';
		$this->content .= $this->ShowInputField("text", "siteEmailForm", Array("id" => "site-email-form", "class" => "wizard-field"))."</div>";
        
        $this->content .= '<div class="wizard-upload-img-block"><div class="wizard-catalog-title">'.GetMessage("WIZ_COMPANY_ADDRESS_DES").'</div>';
		$this->content .= $this->ShowInputField("text", "siteAddress", Array("id" => "site-address", "class" => "wizard-field"))."</div>";
        
        $siteLogo = $wizard->GetVar("siteLogo", true);
        $this->content .= '<div class="wizard-upload-img-block"><div class="wizard-catalog-title">'.GetMessage("WIZ_COMPANY_LOGO").'</div>';
		$this->content .= '<img src="'.$siteLogo.'" alt="" vspace=15 style="display:block, max-width: 100px; height:auto">';
		$this->content .= "<br />".$this->ShowFileField("siteLogo", Array("show_file_info" => "N", "id" => "site-logo"))."</div>";
 
        $this->content .= '<div class="wizard-metadata-title">'.GetMessage("WIZ_COMPANY_BOSS").':</div>';
        $this->content .= '<div class="wizard-upload-img-block"><div class="wizard-input-title">'.GetMessage("WIZ_COMPANY_FIO_BOSS").':</div>';
		$this->content .= $this->ShowInputField("text", "fio_boss", Array("id" => "site-fio-boss", "class" => "wizard-field"))."</div>";
        
        $this->content .= '<div class="wizard-upload-img-block"><div class="wizard-input-title">'.GetMessage("WIZ_COMPANY_POST_BOSS").':</div>';
		$this->content .= $this->ShowInputField("text", "post_boss", Array("id" => "site-post-boss", "class" => "wizard-field"))."</div>";
        
        $photoBoss = $wizard->GetVar("photoBoss", true);
        $this->content .= '<div class="wizard-upload-img-block"><div class="wizard-catalog-title">'.GetMessage("WIZ_COMPANY_PHOTO_BOSS").':</div>';
		$this->content .= CFile::ShowImage($photoBoss, 320, 480, "border=0 vspace=15");
		$this->content .= "<br />".$this->ShowFileField("photoBoss", Array("show_file_info" => "N", "id" => "photo-boss"))."</div>";
        
        $this->content .= '<div class="wizard-upload-img-block"><div class="wizard-catalog-title">'.GetMessage("WIZ_API_KEY_YA_MAP").':</div>';
        $this->content .= '<div>'.GetMessage("WIZ_API_KEY_YA_MAP_DESC").'</div>';
		$this->content .= $this->ShowInputField("text", "api_key_ya_map", Array("id" => "site-ya_map_key", "class" => "wizard-field"))."</div>";   

		$firstStep = COption::GetOptionString("main", "wizard_first" . substr($wizard->GetID(), 7)  . "_" . $wizard->GetVar("siteID"), false, $wizard->GetVar("siteID"));

		$styleMeta = 'style="display:block"';
		if($firstStep == "Y") $styleMeta = 'style="display:none"';
		
		$this->content .= '
		<div  id="bx_metadata" '.$styleMeta.'>
			<div class="wizard-input-form-block">
				<div class="wizard-metadata-title">'.GetMessage("wiz_meta_data").'</div>
				<div class="wizard-upload-img-block">
					<label for="siteMetaDescription" class="wizard-input-title">'.GetMessage("wiz_meta_description").'</label>
					'.$this->ShowInputField("textarea", "siteMetaDescription", Array("id" => "siteMetaDescription", "class" => "wizard-field", "rows"=>"3")).'
				</div>';
			$this->content .= '
				<div class="wizard-upload-img-block">
					<label for="siteMetaKeywords" class="wizard-input-title">'.GetMessage("wiz_meta_keywords").'</label><br>
					'.$this->ShowInputField('text', 'siteMetaKeywords', array("id" => "siteMetaKeywords", "class" => "wizard-field")).'
				</div>
			</div>
		</div>';
		
		if($firstStep == "Y"){
			$this->content .= $this->ShowCheckboxField("installDemoData", "Y",
				(array("id" => "install-demo-data", "onClick" => "if(this.checked == true){document.getElementById('bx_metadata').style.display='block';}else{document.getElementById('bx_metadata').style.display='none';}")));
			$this->content .= '<label for="install-demo-data">'.GetMessage("wiz_structure_data").'</label><br />';
		}else{
			$this->content .= $this->ShowHiddenField("installDemoData","Y");
		}

		$formName = $wizard->GetFormName();
		$installCaption = $this->GetNextCaption();
		$nextCaption = GetMessage("NEXT_BUTTON");
	}

	function OnPostForm()
	{
		$wizard =& $this->GetWizard();
		$this->SaveFile("siteLogo", Array("extensions" => "gif,jpg,jpeg,png,svg", "max_height" => 1200, "max_width" => 1200, "make_preview" => "N"));
        $this->SaveFile("photoBoss", Array("extensions" => "gif,jpg,jpeg,png,svg", "max_height" => 1200, "max_width" => 1200, "make_preview" => "N"));
	}
}

class DataInstallStep extends CDataInstallWizardStep
{
	function CorrectServices(&$arServices)
	{
		$wizard =& $this->GetWizard();
		if($wizard->GetVar("installDemoData") != "Y")
		{
		}
	}
}

class FinishStep extends CFinishWizardStep{}
?>
