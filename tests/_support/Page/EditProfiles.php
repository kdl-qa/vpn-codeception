<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 10.11.15
 * Time: 12:34
 */

namespace Page;


class EditProfiles
{
    //----------------------------------- Private person, Agent locators ---------------------------------------//

    public static $edit_profile_url = '/user/edit-profile';
    public static $firstName = "#fname";
    public static $lastName = "#lname";
    public static $userAvatar = '#image';
    public static $email = "#email";
    public static $userPhoneNumber1 = '#phone0';
    public static $userPhoneNumber2 = '#phone1';
    public static $addPhoneBtn = '.white_bg .linkContainer';
    public static $deletePhoneBtn = ".white_bg .linkContainer .red";


    //----------------------------------- Agency locators -------------------------------------------------------//

    public static $agencyName = "#aname";
    public static $agencySubdomain = "#ahost";
    public static $agencyLogo = "#image";
    public static $agencyAvatar = '#image2';
    public static $agencyAbout = '#description';
    //public static $addPhoneBtn = 'html/body/div[1]/div[3]/div[2]/div/form/dl/div[1]/dd/div/a[2]';
    public static $agencyPhoneNumber1 = '#phone0_0';
    public static $agencyOfficeName0 = '#officeName0';
    public static $agencyAddressName0 = 'address0';
    public static $agencyCabinet0 = '#cabinet0';
    public static $agencySocialVk = '#vk';
    public static $agencySocialTw = '#twitter';
    public static $deletePhoneBtn2 = ".white_bg .linkContainer .red";
//    public static $deleteOffice1 = ".//*[@id='editAgencyForm']/dl/div[5]/dd[7]/button[1]";
    public static $submitEditAgencyProfileBtn = ".buttonBlock";
    public static $acceptEditAgencyProfileModal = ".modal-dialog .buttonContainer";

    public static $agencyScheduleMonday = ".sheduleLine .cc-day-checked0";
    public static $agencyScheduleMondayFromSelect = ".sheduleLine:nth-child(1)";
    public static $agencyScheduleMondayFromInput = ".sheduleLine:nth-child(1)";

    public static $agencyScheduleMondayToSelect = " ";
    public static $agencyScheduleMondayToInput= " ";



    //-----------------------------------------------------------------------------------------------------------//

    public static $buttonBlue = ['css' => 'button.blue'];

    //-----------------------Change Password-------------------------//

    public static $changePassUrl = '/user/change-password';
    public static $oldPasswordField = '#oldPass';
    public static $newPasswordField = '#newPass';
    public static $confirmPasswordField = '#confirm';
    public static $submitButton = '.buttonBlock';
    public static $goodButton = '[ng-click="ctrl.apply()"]';

}