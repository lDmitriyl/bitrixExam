<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Простой компонент");
?><?$APPLICATION->IncludeComponent(
	"exam2:simplecomp.exam97", 
	".default", 
	array(
		"COMPONENT_TEMPLATE" => ".default",
		"NEWS_IBLOCK_ID" => "1",
		"PROPERTY" => "AUTHOR",
		"PROPERTY_UF" => "UF_AUTHOR_TYPE",
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "36000000",
		"CACHE_GROUPS" => "Y"
	),
	false
);?><br><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>