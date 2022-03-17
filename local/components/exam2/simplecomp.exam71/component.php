<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

use Bitrix\Main\Loader,
	Bitrix\Iblock;

if(!Loader::includeModule("iblock"))
{
	ShowError(GetMessage("SIMPLECOMP_EXAM2_IBLOCK_MODULE_NONE"));
	return;
}

if(!isset($arParams['CACHE_TIME']))
    $arParams['CACHE_TIME'] = 36000000;

if(!isset($arParams['PRODUCTS_IBLOCK_ID']))
    $arParams['PRODUCTS_IBLOCK_ID'] = 0;

if(!isset($arParams['CLASSIF_IBLOCK_ID']))
    $arParams['CLASSIF_IBLOCK_ID'] = 0;

$arParams['PROPERTY_CODE'] = trim($arParams['PROPERTY_CODE']);

global $USER;

if($this->startResultCache(false, array($USER->GetGroups()))){

    $arClassif = [];
    $arClassifId = [];
    $arResult['COUNT'] = 0;

    $arSelectElems = array (
        "ID",
        "IBLOCK_ID",
        "NAME",
    );

    $arFilterElems = array (
        "IBLOCK_ID" => $arParams["CLASSIF_IBLOCK_ID"],
        "CHECK_PERMISSIONS" => $arParams['CACHE_GROUPS'],
        "ACTIVE" => "Y"
    );

    $rsElements = CIBlockElement::GetList(array(), $arFilterElems, false, false, $arSelectElems);
    while($arElement = $rsElements->GetNext())
    {
        $arClassif[$arElement['ID']] = $arElement;
        $arClassifId[] = $arElement['ID'];
    }

    $arResult['COUNT'] = count($arClassifId);

    // получаем продукты с привязками к фирме

    $arSort = array(
        'NAME' => 'asc',
        'SORT' => 'asc'
    );

    $arSelectElems = array (
        "ID",
        "IBLOCK_ID",
        "IBLOCK_SECTION_ID",
        "CODE",
        "NAME"
    );
    $arFilterElems = array (
        "IBLOCK_ID" => $arParams["PRODUCTS_IBLOCK_ID"],
        "CHECK_PERMISSIONS" => $arParams['CACHE_GROUPS'],
        "PROPERTY_" . $arParams['PROPERTY_CODE'] => $arClassifId,
        "ACTIVE" => "Y"
    );

    $rsElements = CIBlockElement::GetList($arSort, $arFilterElems, false, false, $arSelectElems);
    $rsElements->SetUrlTemplates($arParams['TEMPLATE_DETAIL_URL'] . '.php');

    while($arElement = $rsElements->GetNextElement())
    {
        $arField = $arElement->GetFields();
        $arField['PROPERTIES'] = $arElement->GetProperties();

        foreach ($arField['PROPERTIES']['FIRMA']['VALUE'] as $value){
            $arClassif[$value]["PRODUCTS"][$arField["ID"]] = $arField;
        }
    }

    $arResult['CLASSIF'] = $arClassif;

    $this->setResultCacheKeys($arResult['COUNT']);
    $this->includeComponentTemplate();
}else{
    $this->abortResultCache();
}

$APPLICATION->SetTitle(GetMessage('COUNT_SECTION') . $arResult['COUNT']);
?>