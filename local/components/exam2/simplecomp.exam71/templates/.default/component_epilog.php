<?php
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

if(isset($arResult['MIN_PRICE']) && isset($arResult['MAX_PRICE'])){
    $infoTemplates = '<div style="color:red; margin: 34px 15px 35px 15px">#TEXT#</div>';

    $text = GetMessage('MIN_PRICE') . $arResult['MIN_PRICE'] . '<br>' . GetMessage('MAX_PRICE') . $arResult['MAX_PRICE'];

    $finalText = str_replace('#TEXT#', $text, $infoTemplates);

    $APPLICATION->AddViewContent('price', $finalText);
}
