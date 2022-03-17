<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<p><b><?=GetMessage("SIMPLECOMP_EXAM2_CAT_TITLE")?></b></p>


<?php if(count($arResult['AUTHORS'] > 0)) {?>

    <ul>
        <?php foreach ($arResult['AUTHORS'] as $key => $arAuthor):?>

            <li>
                [<?=$key?>]-<?=$arAuthor['LOGIN']?>

                <?php if(count($arAuthor['NEWS'] > 0)) {?>

                    <ul>

                        <?php foreach ($arAuthor['NEWS'] as $arNews):?>

                            <li>
                                <?=$arNews['NAME']?>

                            </li>
                        <?php endforeach;?>
                    </ul>
                <?php }?>
            </li>
        <?php endforeach;?>
    </ul>
<?php }?>