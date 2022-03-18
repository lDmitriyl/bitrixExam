<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Простой компонент");
?><?$APPLICATION->IncludeComponent(
	"exam2:simplecomp.exam71", 
	".default", 
	array(
		"COMPONENT_TEMPLATE" => ".default",
		"PRODUCTS_IBLOCK_ID" => "2",
		"CLASSIF_IBLOCK_ID" => "7",
		"TEMPLATE" => "",
		"PROPERTY_CODE" => "FIRMA",
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "36000000",
		"CACHE_GROUPS" => "Y",
		"TEMPLATE_DETAIL_URL" => "catalog_exam/#SECTION_ID#/#ELEMENT_CODE#",
		"ELEMENT_PER_PAGE" => "2"
	),
	false
);?><br><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>