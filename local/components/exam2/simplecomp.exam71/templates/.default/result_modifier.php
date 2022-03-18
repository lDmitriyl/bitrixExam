<?php
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

$price = [];

foreach ($arResult['CLASSIF'] as $arNews){

    foreach ($arNews['PRODUCTS'] as $product){

        if(!empty($product['PROPERTIES']['PRICE']['VALUE']))
            $price[] = $product['PROPERTIES']['PRICE']['VALUE'];
    }
}

$arResult['MIN_PRICE'] = min($price);
$arResult['MAX_PRICE'] = max($price);

$this->__component->setResultCacheKeys(['MIN_PRICE', 'MAX_PRICE']);
