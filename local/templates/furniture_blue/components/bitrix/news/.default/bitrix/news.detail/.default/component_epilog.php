<?php
if (isset($arResult['CANONICAL_LINK']))
    $APPLICATION->setPageProperty('canonical', '<link rel="canonical" href="' . $arResult['CANONICAL_LINK'] . '">');
