<?php

AddEventHandler("main", "OnBeforeProlog", array("EventHandler", "catchSeo"));

class EventHandler
{
    function catchSeo(){
        global $APPLICATION;

        $curPage = $APPLICATION->GetCurDir();

        if(\Bitrix\Main\Loader::includeModule('iblock')){

            $arFilter = ['IBLOCK_ID' => IBLOCK_META, 'NAME' => $curPage];

            $arSelect = array("ID", "IBLOCK_ID", "PROPERTY_TITLE", "PROPERTY_DESCRIPTION");

            $ob = CIBlockElement::GetList(array(), $arFilter, false, false, $arSelect);

            if($res = $ob->Fetch()){
                $APPLICATION->SetPageProperty('title', $res['PROPERTY_TITLE_VALUE']);
                $APPLICATION->SetPageProperty('description', $res['PROPERTY_DESCRIPTION_VALUE']);
            }
        }
    }
}
?>