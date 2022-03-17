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

$arParams['PROPERTY'] = trim($arParams['PROPERTY']);

$arParams['PROPERTY_UF'] = trim($arParams['PROPERTY_UF']);

global $USER;

if($USER->IsAuthorized()){
    $arResult['COUNT'] = 0;
    $userID = $USER->GetID();

    $userType = CUser::GetList(
        $by = "id",
        $order = "asc",
        ['ID' => $userID],
        ['SELECT' => [$arParams['PROPERTY_UF']]]
    )->Fetch()[$arParams['PROPERTY_UF']];

    if($this->startResultCache(false, array($userType, $userID))){

        $rsUsers = CUser::GetList(
            $by = "id",
            $order = "desc",
            [$arParams['PROPERTY_UF'] => $userType],
            ['SELECT' => ['LOGIN', 'ID']]
        );

        while ($arUser = $rsUsers->Fetch()){
            $userList[$arUser['ID']] = ['LOGIN' => $arUser['LOGIN']];
            $userListID[] = $arUser['ID'];
        }

        $arNewsAuthor = [];
        $arNewsList = [];

        $arSelectElems = array (
            "ID",
            "IBLOCK_ID",
            "NAME",
            "ACTIVE_FROM",
            "PROPERTY_".$arParams['PROPERTY']
        );

        $arFilterElems = array (
            "IBLOCK_ID" => $arParams["NEWS_IBLOCK_ID"],
            "PROPERTY_".$arParams['PROPERTY'] => $userListID,
            "ACTIVE" => "Y"
        );
        $arNewsId = [];

        $rsElements = CIBlockElement::GetList(array(), $arFilterElems, false, false, $arSelectElems);
        while($arElement = $rsElements->Fetch())
        {
            $arNewsAuthor[$arElement['ID']][] = $arElement["PROPERTY_".$arParams['PROPERTY']. "_VALUE"];

            if(empty($arNewsList[$arElement['ID']])){
                $arNewsList[$arElement['ID']] = $arElement;
            }

            if($arElement["PROPERTY_".$arParams['PROPERTY']. "_VALUE"] != $userID){
                $arNewsList[$arElement['ID']]['AUTHORS'][] = $arElement["PROPERTY_".$arParams['PROPERTY']. "_VALUE"];
            }
        }

        foreach ($arNewsList as $key => $value){

            if(in_array($userID, $arNewsAuthor[$value['ID']])) continue;

            foreach ($value['AUTHORS'] as $authorId){
                $userList[$authorId]['NEWS'][] = $value;
                $arNewsId[$value['ID']] = $value['ID'];
            }
        }

        unset($userList[$userID]);

        $arResult['AUTHORS'] = $userList;
        $arResult['COUNT'] = count($arNewsId);
        $this->setResultCacheKeys($arResult['COUNT']);
        $this->includeComponentTemplate();

    }else{
        $this->abortResultCache();
    }

    $APPLICATION->SetTitle(GetMessage('COUNT_NEWS') . $arResult['COUNT']);
}