<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<p><b><?=GetMessage("SIMPLECOMP_EXAM2_CAT_TITLE")?></b></p>
<?php


$url = $APPLICATION->GetCurPage() . '?F=Y';

echo GetMessage('FILTER_TITLE')."<a href = '{$url}'>{$url}</a>"

?>

<?php if(count($arResult['CLASSIF'] > 0)) {?>

    <ul>
        <?php foreach ($arResult['CLASSIF'] as $arClassif):?>

            <li>
                <b><?=$arClassif['NAME']?></b>

                <?php if(count($arClassif['PRODUCTS'] > 0)) {?>

                    <?php $this->AddEditAction('add_element', $arResult['ADD_LINK'], CIBlock::GetArrayByID($arResult["IBLOCK_ID"], "ELEMENT_ADD"));?>

                    <ul id="<?=$this->GetEditAreaId('add_element');?>">

                        <?php foreach ($arClassif['PRODUCTS'] as $arProduct):?>
                            <?
                            $this->AddEditAction($arClassif['ID'] . '_' . $arProduct['ID'], $arProduct['EDIT_LINK'], CIBlock::GetArrayByID($arResult["IBLOCK_ID"], "ELEMENT_EDIT"));
                            $this->AddDeleteAction($arClassif['ID'] . '_' . $arProduct['ID'], $arProduct['DELETE_LINK'], CIBlock::GetArrayByID($arResult["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
                            ?>
                            <li id="<?=$this->GetEditAreaId($arClassif['ID'] . '_' . $arProduct['ID']);?>">
                                <?=$arProduct['NAME']?>
                                <?=$arProduct['PROPERTIES']['PRICE']['VALUE']?>
                                <?=$arProduct['PROPERTIES']['ARTNUMBER']['VALUE']?>
                                <?=$arProduct['PROPERTIES']['MATERIAL']['VALUE']?>-
                                (<?=$arProduct['DETAIL_PAGE_URL']?>)
                            </li>
                        <?php endforeach;?>
                    </ul>
                <?php }?>
            </li>
        <?php endforeach;?>
    </ul>
    <br>
    ---
    <p>
        <b>
            <?= GetMessage('NAVIGATION')?>
        </b>
    </p>
    <?php echo $arResult['NAV_STRING']?>
<?php }?>