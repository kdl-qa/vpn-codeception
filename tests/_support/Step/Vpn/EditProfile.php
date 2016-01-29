<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 10.11.15
 * Time: 12:34
 */

namespace Step\Vpn;
use Page\EditProfiles;
use Data\User;
use Page\Registration;
use Page\AgencyEmployees;

class EditProfile extends \VpnTester
{
    public function editUserProfile(){
        $this->wantTo('edit profile of private person');
        $this->amOnPage(EditProfiles::$edit_profile_url);
        $this->waitForElement(EditProfiles::$firstName);
        $this->fillField(EditProfiles::$firstName,User::$userFirstNameEdit);
        $this->fillField(EditProfiles::$lastName,User::$userLastNameEdit);
        $this->attachFile(EditProfiles::$userAvatar,'/img/avatar_edit.jpg');
        $this->fillField(EditProfiles::$email,User::$userEmailEdit);
        file_put_contents(codecept_data_dir('userEmail.txt'),User::$userEmailEdit);
        $this->fillField(EditProfiles::$userPhoneNumber1,User::$userPhoneNumber1);
        $this->click(EditProfiles::$addPhoneBtn);
        $this->waitForElement(EditProfiles::$userPhoneNumber2);
        $this->fillField(EditProfiles::$userPhoneNumber2,User::$userPhoneNumber2);
        $this->click(EditProfiles::$deletePhoneBtn);
        $this->waitForElement(EditProfiles::$buttonBlue);
        $this->submitBtnBlue();
        $this->acceptEditProfileModal();
        $this->wait(1);
    }

    function checkUserEditProfile(){
        $userFirstName = User::$userFirstNameEdit;
        $userLastName = User::$userLastNameEdit;

        $this->wantTo('check edited user profile');
        $this->reloadPage();
        $this->wait(3);
        $this->seeElement("//img[@alt='$userFirstName $userLastName']");
        $this->waitForElement(EditProfiles::$firstName);
        $this->seeInField(EditProfiles::$firstName,User::$userFirstNameEdit);
        $this->seeInField(EditProfiles::$lastName,User::$userLastNameEdit);
        $this->seeInField(EditProfiles::$email,User::$userEmailEdit);
        $this->seeInField(EditProfiles::$userPhoneNumber1,User::$userPhoneNumber2);
    }

    public function editAgentProfile(){
        $this->wantTo('edit agent profile');
        $this->amOnPage(EditProfiles::$edit_profile_url);
        $this->waitForElement(EditProfiles::$firstName);
        $this->fillField(EditProfiles::$firstName,User::$agentFirstNameEdit);
        $this->fillField(EditProfiles::$lastName,User::$agentLastNameEdit);
        $this->attachFile(EditProfiles::$userAvatar,'/img/avatar_edit.jpg');
        $this->fillField(EditProfiles::$email,User::$agentEmailEdit);
        file_put_contents(codecept_data_dir('agentEmail.txt'),User::$agentEmailEdit);
        $this->fillField(EditProfiles::$userPhoneNumber1,User::$userPhoneNumber1);
        $this->click(EditProfiles::$addPhoneBtn);
        $this->wait(1);
        $this->fillField(EditProfiles::$userPhoneNumber2,User::$userPhoneNumber2);
        $this->click(EditProfiles::$deletePhoneBtn);
        $this->wait(2);
        $this->submitBtnBlue();
        $this->acceptEditProfileModal();
        $this->wait(1);
    }


    function checkAgentEditProfile(){
        $agentFirstName = User::$agentFirstNameEdit;
        $agentLastName = User::$agentLastNameEdit;

        $this->wantTo('check edited agent profile');
        $this->reloadPage();
        $this->wait(3);
        $this->waitForElement(EditProfiles::$firstName);
        $this->seeInField(EditProfiles::$firstName,User::$agentFirstNameEdit);
        $this->seeInField(EditProfiles::$lastName,User::$agentLastNameEdit);
        $this->seeElement("//img[@alt='$agentFirstName $agentLastName']");
        $this->seeInField(EditProfiles::$email,User::$agentEmailEdit);
        $this->seeInField(EditProfiles::$userPhoneNumber1,User::$userPhoneNumber2);
    }

    function editAgencyProfile(){
        $this->wantTo('edit profile of agency');
        $this->amOnPage(EditProfiles::$edit_profile_url);
        $this->waitForElement(EditProfiles::$agencyName);
        $this->fillField(EditProfiles::$agencyName,User::$agencyNameEdit);
        $this->attachFile(EditProfiles::$agencyAvatar,'/img/avatar_edit.jpg');
        $this->fillField(EditProfiles::$firstName,User::$agencyfirstNameEdit);
        $this->fillField(EditProfiles::$lastName,User::$agencylastNameEdit);
        $this->waitForElement(EditProfiles::$agencyLogo);
        $this->attachFile(EditProfiles::$agencyLogo,'/img/agency_logo.png');
        $this->wait(3);
        $this->fillField(EditProfiles::$email,User::$agencyEmailEdit);
        file_put_contents(codecept_data_dir('agencyEmail.txt'),User::$agencyEmailEdit);
        $this->fillField(EditProfiles::$agencyAbout,User::$agencyAboutNew);
        $this->fillField(EditProfiles::$agencyPhoneNumber1,User::$agencyOfficePhoneNumberEdit0_0);
        //$this->click(EditProfilePage::$deletePhoneBtn2);  use when agency's office has 2 phone-numbers
        $this->fillField(EditProfiles::$agencyOfficeName0,User::$agencyOfficeName0Edit);
        $this->wait(2);
        $this->fillField(EditProfiles::$agencyAddressName0,User::$agencyAddressName0Edit);
        $this->fillField(EditProfiles::$agencyCabinet0,User::$agencyCabinet0Edit);
//        $this->click(EditProfiles::$agencyScheduleMonday);
//        $this->click(EditProfiles::$agencyScheduleMonday);
//        $this->click(EditProfiles::$agencyScheduleMondayFromSelect);
//        $this->fillField(EditProfiles::$agencyScheduleMondayFrom,User::$scheduleMondayFrom);
//        $this->click(EditProfiles::$agencyScheduleMondayToSelect);
//        $this->fillField(EditProfiles::$agencyScheduleMondayTo,User::$scheduleMondayTo);

        $this->wait(3);

        //$this->click(EditProfiles::$deleteOffice1);


        $this->fillField(EditProfiles::$agencySocialVk, User::$agencySocialEmpty);
        $this->fillField(EditProfiles::$agencySocialTw, User::$agencySocialTw);
        $this->wait(3);
        $this->click(EditProfiles::$submitEditAgencyProfileBtn);
        $this->wait(5);
//        $this->click(EditProfiles::$acceptEditAgencyProfileModal);
        $this->wait(3);
    }

    function checkAgencyEditProfile(){
        $agencyFirstName = User::$agencyfirstNameEdit;
        $agencyLastName = User::$agencylastNameEdit;

        $this->wantTo('check edited agency profile');
        $this->reloadPage();
        $this->wait(3);
        $this->waitForElement(EditProfiles::$agencyName);
        $this->seeInField(EditProfiles::$agencyName,User::$agencyNameEdit);
        $this->seeInField(EditProfiles::$agencySubdomain,User::getCurrentSubdomain());
        $this->seeInField(EditProfiles::$firstName,User::$agencyfirstNameEdit);
        $this->seeInField(EditProfiles::$lastName,User::$agencylastNameEdit);
        $this->seeElement("//img[@alt='$agencyFirstName $agencyLastName']");
        $this->seeInField(EditProfiles::$email,User::getCurrentAgencyEmail());
        $about_text = $this->grabValueFrom(EditProfiles::$agencyAbout);
        $this->seeInDescriptionField($about_text);
        $this->seeInField(EditProfiles::$agencyOfficeName0,User::$agencyOfficeName0Edit);
        $this->seeInField(EditProfiles::$agencyAddressName0,User::$agencyAddressName0Edit);
        $this->seeInField(EditProfiles::$agencyCabinet0,User::$agencyCabinet0Edit);
        $this->seeInField(EditProfiles::$agencyPhoneNumber1,User::$agencyOfficePhoneNumberEdit0_0);
        $this->seeInField(EditProfiles::$agencySocialVk,User::$agencySocialEmpty);
        $this->seeInField(EditProfiles::$agencySocialTw,User::$agencySocialTw);
    }

    function changePassword()
    {
        $I = $this;
        $I->amOnPage(EditProfiles::$changePassUrl);
        $I->waitForElement(EditProfiles::$submitButton);
        $I->fillField(EditProfiles::$oldPasswordField, User::$userPass);
        $I->fillField(EditProfiles::$newPasswordField, User::$editUserPass);
        $I->fillField(EditProfiles::$confirmPasswordField, User::$editUserPass);
        $I->click(EditProfiles::$submitButton);
        $I->waitForElement(EditProfiles::$acceptEditAgencyProfileModal);
        $I->click(EditProfiles::$goodButton);

        $I->fillField(EditProfiles::$oldPasswordField, User::$editUserPass);
        $I->fillField(EditProfiles::$newPasswordField, User::$userPass);
        $I->fillField(EditProfiles::$confirmPasswordField, User::$userPass);
        $I->click(EditProfiles::$submitButton);
        $I->waitForElement(EditProfiles::$acceptEditAgencyProfileModal);
        $I->click(EditProfiles::$goodButton);



    }

    function seeInDescriptionField($about_text){
        codecept_debug($about_text);
        if($about_text == User::$agencyAboutNew) return;
    }




}