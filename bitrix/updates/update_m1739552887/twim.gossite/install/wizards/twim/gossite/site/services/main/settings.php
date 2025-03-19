<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)
	die();

COption::SetOptionString(
    "fileman", 
    "propstypes", 
    serialize(array(
        "description"=>GetMessage("MAIN_OPT_DESCRIPTION"), 
        "keywords"=>GetMessage("MAIN_OPT_KEYWORDS"), 
        "title"=>GetMessage("MAIN_OPT_TITLE"), 
        "og:title"=>GetMessage("MAIN_OPT_OG_TITLE"),
        "og:description"=>GetMessage("MAIN_OPT_OG_DESCRIPTION"),
        "og:image"=>GetMessage("MAIN_OPT_OG_IMAGE"),
        "og:url"=>GetMessage("MAIN_OPT_OG_URL"),
        "page_one_column"=>GetMessage("MAIN_OPT_ONE_COLUMN_PAGE"),
        "show_timestamp_x"=>GetMessage("MAIN_show_timestamp_x_PAGE"),
        )
    ), 
    false, 
    $siteID
);
COption::SetOptionInt("search", "suggest_save_days", 250);
COption::SetOptionString("search", "use_tf_cache", "Y");
COption::SetOptionString("search", "use_word_distance", "Y");
COption::SetOptionString("search", "use_social_rating", "Y");
COption::SetOptionString("iblock", "use_htmledit", "Y");
?>
