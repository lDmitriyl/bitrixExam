<?php

function CheckUserCount(){

    $date = new DateTime();

    $date = \Bitrix\Main\Type\DateTime::createFromTimestamp($date->getTimestamp());

    $lastDate = COption::GetOptionString('main', 'last_date_agent_checkUserCount');

    if($lastDate){
        $arFilter = array("DATE_REGISTER_1" => $lastDate);
    }else{
        $arFilter = array();
    }

    $rsUser = CUser::GetList(
        $by = "DATE_REGISTER",
        $order = "ASC",
        $arFilter
    );

    while($user = $rsUser->Fetch()){
        $arUsers[] = $user;
    }

    if(!$lastDate){
        $lastDate = $arUsers[0]["DATE_REGISTER"];
    }


    $difference = intval(abs(strtotime($lastDate) - strtotime($date->toString())));

    $days = round($difference / (3600 * 24));

    $countUsers = count($arUsers);


    $rsAdmin = CUser::GetList(
        $by = "ID",
        $order = "ASC",
        array("GROUPS_ID" => 1)
    );

    while($admin = $rsAdmin->Fetch()){
        CEvent::Send(
            'COUNT_REGISTERED_USER',
            's1',
            array(
                'EMAIL_TO' => $admin['EMAIL'],
                'COUNT_USERS' => $countUsers,
                'COUNT_DAYS' => $days,
            ),
            'Y',
            '32' //id шаблона
        );
    }

    COption::SetOptionString('main', 'last_date_agent_checkUserCount', $date->toString());

    return "CheckUserCount();";
}