<?php

AddEventHandler("main", "OnBuildGlobalMenu", array("EventHandler", "forbidGlobalMenu"));

class EventHandler
{

    function forbidGlobalMenu(&$aGlobalMenu, &$aModuleMenu){
        global $USER;
        $isManager = false;

        $userGroup = CUser::GetUserGroupList($USER->GetID());

        $contentCroupID = CGroup::GetList(
            $by = "c_sort",
            $order = "asc",
            ['STRING_ID' =>'content_editor']
        )->Fetch()['ID'];

        while ($group = $userGroup->Fetch()){

            if($group['GROUP_ID'] == $contentCroupID){
                $isManager = true;
            }
        }

        if($isManager){

            foreach ($aModuleMenu as $item){

                if($item['items_id'] == 'menu_iblock_/news'){
                    $aModuleMenu = [$item];
                    break;
                }
            }

            $aGlobalMenu = ['global_menu_content' => $aGlobalMenu['global_menu_content']];
        }
    }
}
?>