<?php

IncludeModuleLangFile(__FILE__);
AddEventHandler("iblock", "OnBeforeIBlockElementUpdate", Array("EventHandler", "showCounterProduct"));

class EventHandler
{
    function showCounterProduct(&$arFields)
    {
        if($arFields['IBLOCK_ID'] === IBLOCK_CATALOG){

            if($arFields['ACTIVE'] === 'N'){

                $arSelect = array("ID", "IBLOCK_ID", "NAME", "SHOW_COUNTER");
                $arFilter = array("IBLOCK_ID" => IBLOCK_CATALOG, 'ID' => $arFields['ID']);

                $res = CIBlockElement::GetList(array(), $arFilter, false, false, $arSelect);

                if ($arItems = $res->Fetch()) {

                    if($arItems['SHOW_COUNTER']  > MAX_SHOW_COUNTER){

                        global $APPLICATION;
                        $APPLICATION->throwException(GetMessage('SHOW_COUNT_EXCEPTION', ['#COUNT#' => $arItems['SHOW_COUNTER']]));
                        return false;

                    }
                }
            }
        }
    }
}
