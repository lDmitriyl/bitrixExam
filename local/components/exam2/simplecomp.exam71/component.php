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

$cfilter = false;

if($_GET['F']) $cfilter = true;

if($USER->IsAuthorized()){
    $arButtons = CIBlock::GetPanelButtons($arParams['PRODUCTS_IBLOCK_ID']);

    $this->AddIncludeAreaIcons(
        array(
            array(
                'ID' => 'linklb',
                'TITLE' => GetMessage("IB_IN_ADMIN"),
                'URL' => $arButtons['submenu']['element_list']['ACTION_URL'],
                'IN_PARAMS_MENU' => true
            )
        )
    );
}
$arNavParams = [
    "nPageSize" => $arParams['ELEMENT_PER_PAGE'],
    "bShowAll"  => true,
];

$arNavigation = CDBResult::GetNavParams($arNavParams);

global $CACHE_MANAGER;

if($this->startResultCache(false, array($USER->GetGroups(), $cfilter, $arNavigation), "/servicesIblock")){

    $CACHE_MANAGER->RegisterTag('iblock_id_3');

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

    $rsElements = CIBlockElement::GetList(array(), $arFilterElems, false, $arNavParams, $arSelectElems);

    $arResult['NAV_STRING'] = $rsElements->GetPageNavString(GetMessage('PAGE_TITLE'));

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

    if($cfilter){
        $arFilterElems = array(
            [
                'LOGIC' => 'OR',
                ['<=PROPERTY_PRICE' => 1700, 'PROPERTY_MATERIAL' => 'Дерево, ткань'],
                ['<PROPERTY_PRICE' => 1500, 'PROPERTY_MATERIAL' => 'Металл, пластик']

            ]
        );

        $this->AbortResultCache();
    }

    $rsElements = CIBlockElement::GetList($arSort, $arFilterElems, false, false, $arSelectElems);
    $rsElements->SetUrlTemplates($arParams['TEMPLATE_DETAIL_URL'] . '.php');

    while($arElement = $rsElements->GetNextElement())
    {
        $arField = $arElement->GetFields();
        $arField['PROPERTIES'] = $arElement->GetProperties();

        $arrButtons = CIBlock::GetPanelButtons(
            $arParams['PRODUCTS_IBLOCK_ID'],
            $arField['ID'],
            0,
            ['SECTION_BUTTONS' => false, 'SESSID' => false]
        );

        $arField["EDIT_LINK"] = $arrButtons['edit']['edit_element']['ACTION_URL'];
        $arField["DELETE_LINK"] = $arrButtons['edit']['delete_element']['ACTION_URL'];

        $arResult['ADD_LINK'] = $arrButtons['edit']['add_element']['ACTION_URL'];
        $arResult['IBLOCK_ID'] = $arParams['PRODUCTS_IBLOCK_ID'];

        foreach ($arField['PROPERTIES']['FIRMA']['VALUE'] as $value){
            if(in_array($value, $arClassifId))
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