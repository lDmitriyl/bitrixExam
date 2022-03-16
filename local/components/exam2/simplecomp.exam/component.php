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

if(!isset($arParams['NEWS_IBLOCK_ID']))
    $arParams['NEWS_IBLOCK_ID'] = 0;

if(!isset($arParams['PRODUCTS_IBLOCK_ID']))
    $arParams['PRODUCTS_IBLOCK_ID'] = 0;



if($this->startResultCache()){

    $arNews = [];
    $arNewsID = [];

    $objNews = CIBlockElement::GetList(
        array(),
        array (
            "IBLOCK_ID" => $arParams["NEWS_IBLOCK_ID"],
            "ACTIVE" => "Y"
        ),
        false,
        false,
        array ('NAME', 'ACTIVE_FROM', 'ID')
    );
    while($newsElements = $objNews->Fetch()){
        $arNewsID[] = $newsElements['ID'];
        $arNews[$newsElements['ID']] = $newsElements;
    }

    //получаем разделы

    $arSections = [];
    $arSectionID = [];

    $rsSections = CIBlockSection::GetList(
        array(),
        array (
            "IBLOCK_ID" => $arParams['PRODUCTS_IBLOCK_ID'],
            "ACTIVE" => "Y",
            $arParams['PRODUCTS_IBLOCK_ID_PROPERTY'] => $arNewsID
        ),
        false,
        array ('NAME', 'IBLOCK_ID', 'ID', $arParams['PRODUCTS_IBLOCK_ID_PROPERTY'])
    );

    while ($arSectionCatalog = $rsSections->Fetch()){
        $arSectionID[] = $arSectionCatalog['ID'];
        $arSections[$arSectionCatalog['ID']] = $arSectionCatalog;
    }

    //активные товары из разделов
    $objProducts = CIBlockElement::GetList(
        array(),
        array (
            "IBLOCK_ID" => $arParams["PRODUCTS_IBLOCK_ID"],
            "ACTIVE" => "Y",
            'SECTION_ID' => $arSectionID
        ),
        false,
        false,
        array (
            'NAME',
            'IBLOCK_ID',
            'ID',
            'IBLOCK_SECTION_ID',
            'PROPERTY_ARTNUMBER',
            'PROPERTY_MATERIAL',
            'PROPERTY_PRICE',
            )
    );

    $arResult['PRODUCT_COUNT'] = 0;

    while($arProduct = $objProducts->Fetch()){
        $arResult['PRODUCT_COUNT']++;
        //продукты по новостям
        foreach ($arSections[$arProduct['IBLOCK_SECTION_ID']][$arParams['PRODUCTS_IBLOCK_ID_PROPERTY']] as $newsId){
            $arNews[$newsId]['PRODUCTS'][] = $arProduct;
        }
    }

    //разделы по новостям

    foreach ($arSections as $arSection){
        foreach ($arSection[$arParams['PRODUCTS_IBLOCK_ID_PROPERTY']] as $newsId){
            $arNews[$newsId]['SECTIONS'][] = $arSection['NAME'];
        }
    }

    $arResult['NEWS'] = $arNews;

    $this->setResultCacheKeys($arResult['PRODUCT_COUNT']);
    $this->includeComponentTemplate();
}else{
    $this->abortResultCache();
}

$APPLICATION->SetTitle(GetMessage('COUNT_PRODUCTS') . $arResult['PRODUCT_COUNT']);

?>