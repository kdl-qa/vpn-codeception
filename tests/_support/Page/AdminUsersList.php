<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 10.11.15
 * Time: 10:54
 */

namespace Page;


class AdminUsersList
{
    public static $users_list_url = '/admin/users';
    public static $searchByName = '#name';
    public static $filterUsersBtn = '.filterContainer div button';
    public static $changeUserStatusBtn = '.stateContent .action .fa:nth-child(2)';
//    public static $agencyEmail = '.userList .email:last';
    public static $agencyEmail = ".//*[@id='page-wrapper']/div[2]/div/div/div/div/div/ul/li[2]/div[3]";
    public static $statusesSelect = '.modal-content .block-container input';
    public static $statusesSelectClick = '.modal-content .block-container .ui-select-match';
    public static $activeStateWord = "Активен";
    public static $modalBody= ".modal-content .modal-body";
    public static $chooseActiveState = "cc-change-reason0";
    public static $submitStatusChangeBtn = ".modal-body .buttonContainer";
}
