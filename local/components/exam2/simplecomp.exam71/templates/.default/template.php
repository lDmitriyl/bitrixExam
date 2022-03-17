<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<p><b><?=GetMessage("SIMPLECOMP_EXAM2_CAT_TITLE")?></b></p>


<?php if(count($arResult['CLASSIF'] > 0)) {?>

    <ul>
        <?php foreach ($arResult['CLASSIF'] as $arClassif):?>

            <li>
                <b><?=$arClassif['NAME']?></b>

                <?php if(count($arClassif['PRODUCTS'] > 0)) {?>

                    <ul>

                        <?php foreach ($arClassif['PRODUCTS'] as $arProduct):?>

                            <li>
                                <?=$arProduct['NAME']?>
                                <?=$arProduct['PROPERTIES']['PRICE']['VALUE']?>
                                <?=$arProduct['PROPERTIES']['ARTNUMBER']['VALUE']?>
                                <?=$arProduct['PROPERTIES']['MATERIAL']['VALUE']?>
                                <a href="<?=$arProduct['DETAIL_PAGE_URL']?>">Ссылка на детальный просмотр</a>
                            </li>
                        <?php endforeach;?>
                    </ul>
                <?php }?>
            </li>
        <?php endforeach;?>
    </ul>
<?php }?>