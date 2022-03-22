<?php

CJSCore::Init();

if($_GET['TYPE'] == 'REPORT_RESULT'){

    if($_GET['ID']){?>

        <script>
            let textElem = document.getElementById("ajax-report-text");
            textElem.innerText = "Ваше мнение учтено, № <?=$_GET["ID"]?>";
            window.history.pushState(null, null, "<?=$APPLICATION->GetCurPage()?>");
        </script>

    <?}else{?>

        <script>
            let textElem = document.getElementById("ajax-report-text");
            textElem.innerText = "Ошибка!" ;
            window.history.pushState(null, null, "<?=$APPLICATION->GetCurPage()?>");
        </script>

    <?php }

}elseif (isset($_GET['ID'])){

    $jsonObject = array();

    if(CModule::IncludeModule('iblock')){

        $arUser = '';

        if($USER->IsAuthorized()){
            $arUser = $USER->GetID() . '(' . $USER->GetLogin() . ')' . $USER->GetFullName();
        }else{
            $arUser = 'Не авторизован';
        }

        $arFields = array(
            'IBLOCK_ID' => 8,
            'NAME' => 'Новость' . $_GET['ID'],
            'ACTIVE_FROM' => \Bitrix\Main\Type\DateTime::createFromTimestamp(time()),
            'PROPERTY_VALUES' => array(
                'USER' => $arUser,
                'NEWS' => $_GET['ID']
            )
        );

        $element = new CIBlockElement();

        if($elId = $element->Add($arFields)){
            $jsonObject['ID'] = $elId;

            if($_GET['TYPE'] == 'REPORT_AJAX'){

                $APPLICATION->RestartBuffer();

                echo json_encode($jsonObject);
                die();
            }elseif ($_GET['TYPE'] == 'REPORT_GET'){

                LocalRedirect($APPLICATION->GetCurPage() . "?TYPE=REPORT_RESULT&ID=" . $jsonObject['ID']);
            }
        }else{
            LocalRedirect($APPLICATION->GetCurPage() . "?TYPE=REPORT_RESULT");
        }
    }
}
