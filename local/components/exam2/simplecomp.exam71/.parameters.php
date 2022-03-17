<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
$arComponentParameters = array(
	"PARAMETERS" => array(

		"PRODUCTS_IBLOCK_ID" => array(
			"NAME" => GetMessage("SIMPLECOMP_EXAM2_CAT_IBLOCK_ID_71"),
            'PARENT' => 'BASE',
			"TYPE" => "STRING",
		),

        "CLASSIF_IBLOCK_ID" => array(
            "NAME" => GetMessage("SIMPLECOMP_EXAM2_CLASSIF_IBLOCK_ID"),
            'PARENT' => 'BASE',
            "TYPE" => "STRING",
        ),

        "TEMPLATE_DETAIL_URL" => array(
            "NAME" => GetMessage("SIMPLECOMP_EXAM2_TEMPLATE_ID"),
            'PARENT' => 'BASE',
            "TYPE" => "STRING",
            "DEFAULT" => "catalog_exam/#SECTION_ID#/#ELEMENT_CODE#"
        ),

        "PROPERTY_CODE" => array(
            "NAME" => GetMessage("SIMPLECOMP_EXAM2_PROPERTY_ID"),
            'PARENT' => 'BASE',
            "TYPE" => "STRING",
        ),

        "CACHE_TIME"  =>  array("DEFAULT"=>36000000),
        "CACHE_GROUPS" => array(
            "PARENT" => "CACHE_SETTINGS",
            "NAME" => GetMessage("CP_BNL_CACHE_GROUPS_71"),
            "TYPE" => "CHECKBOX",
            "DEFAULT" => "Y",
        ),

    ),
);