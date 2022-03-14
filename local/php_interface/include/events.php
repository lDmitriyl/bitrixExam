<?php
IncludeModuleLangFile(__FILE__);
AddEventHandler("main", "OnBeforeEventAdd", array("EventHandler", "feedbackForm"));

class EventHandler
{

    function feedbackForm(&$event, &$lid, &$arFields){

        if($event === 'FEEDBACK_FORM'){
            global $USER;

            if($USER->isAuthorized()){
                $arFields['AUTHOR'] = GetMessage('FEEDBACK_FORM_AUTH_USER', [
                    '#ID#' => $USER->GetID(),
                    '#LOGIN#' => $USER->GetLogin(),
                    '#NAME#' => $USER->GetFullName(),
                    '#NAME_FORM#' => $arFields['AUTHOR']
                ]);
            }else{
                $arFields['AUTHOR'] = GetMessage('FEEDBACK_FORM_NO_AUTH_USER', ['#NAME_FORM#' => $arFields['AUTHOR']]);
            }
        }

        CEventLog::Add([
            'SEVERITY' => 'INFO',
            'AUDIT_TYPE_ID' => GetMessage('FEEDBACK_FORM_REPLACE', ['#AUTHOR#' => '']),
            'MODULE_ID' => 'main',
            'DESCRIPTION' => GetMessage('FEEDBACK_FORM_REPLACE', ['#AUTHOR#' => $arFields['AUTHOR']]),
        ]);
    }
}
?>