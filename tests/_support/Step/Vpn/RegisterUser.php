<?php
namespace Step\Vpn;
use Page\AdminUsersList;
use Page\AgencyEmployees;
use Page\Registration;
use Data\User;
use \Facebook\WebDriver\WebDriverKeys;


class RegisterUser extends  \VpnTester
{
    public function registerPrivatePerson(){
        $I=$this;
        $I->wantTo('register private person');
        $I->amOnPage(Registration::$register_private_person_url);
        $I->wait(2);
        $I->fillField(Registration::$name, User::$userFirstName);
        $I->fillField(Registration::$email, User::uniqueUserEmail());
        $I->click(Registration::$submitRegistrationBtn);
        $I->acceptRegistrationModal();
    }

    public function registerAgent()
    {
        $I=$this;
        $I->wantTo('register agent as agency');
        $I->amOnPage(Registration::$register_agent_url);
        $I->wait(2);
        $I->fillField(Registration::$agentFirstName, User::$agentFirstName);
        $I->fillField(Registration::$agentLastName, User::$agentLastName);
        $I->fillField(Registration::$email, User::uniqueAgentEmail());
        $I->fillField(Registration::$agentPhone0, User::$agentPhone0);
        $I->attachFile(Registration::$agencyAvatar,'/img/avatar.jpg');
        $I->wait(1);
        $I->click(Registration::$addPhoneBtn);
        $I->wait(1);
        $I->fillField(Registration::$agentPhone1, User::$agentPhone1);
        $I->click(Registration::$deletePhoneBtn);
        $I->wait(3);
        $I->fillField(Registration::$agentPass, User::$agentPass);
        $I->wait(2);
        $I->click(Registration::$submitRegistrationBtn);
        $I->wait(2);
    }

    public function checkAgentRegistration(){
        $agentFirstName = User::$agentFirstName;
        $agentLastName = User::$agentLastName;


        $I=$this;
        $I->wantTo('check registration of agent');
        $I->amOnPage(Registration::$employees_list_url);
        $I->waitForElement(AgencyEmployees::$listFirstAgent);
        $I->see(User::$agentFirstName.' '.User::$agentLastName, AgencyEmployees::$agentName);
        $I->see(User::getCurrentAgentEmail(),AgencyEmployees::$agentEmail);
        $I->seeElement("//img[@alt='$agentFirstName $agentLastName']");
    }


    public function agentDelete(){
        $I=$this;
        $I->wantTo('delete agent');
        $I->amOnPage(Registration::$employees_list_url);
        $I->waitForElement(AgencyEmployees::$listFirstAgent);
        $I->click(AgencyEmployees::$agentDeleteBtn);
        $I->wait(2);
        $I->acceptDeleteUserModal();
        $I->reloadPage();
        $I->wait(3);
        $I->cantSee(User::getCurrentAgentEmail(),AgencyEmployees::$listFirstAgent);
    }

    public function  registerAgency()
    {
        $I=$this;
        $I->wantTo('register agency from the webApp');
        $I->amOnPage(Registration::$register_agency_url);
        $I->wait(2);
        $I->fillField(Registration::$agencyName,User::$agencyName);
        $I->fillField(Registration::$agencySubdomain,User::uniqueSubdomain());
        $I->wait(2);
        $I->attachFile(Registration::$agencyAvatar,'/img/avatar.jpg');
        $I->wait(2);
        $I->fillField(Registration::$agentFirstName,User::$agencyFirstName);
        $I->fillField(Registration::$agentLastName,User::$agencyLastName);
        $I->wait(3);
        $I->attachFile(Registration::$agencyLogo,'/img/agency_logo.png');
        $I->wait(3);
        $I->fillField(Registration::$email,User::uniqueAgencyEmail());
        $I->fillField(Registration::$agentPass,User::$agencyRegPass);
        $I->fillField(Registration::$agencyAbout,User::$agencyDescription);
        $I->fillField(Registration::$agencyPhoneNumber1,User::$agencyOfficePhoneNumber0_0);
        //$this->click(EditProfilePage::$deletePhoneBtn2);  use when agency's office has 2 phone-numbers
        $I->fillField(Registration::$agencyOfficeName0,User::$agencyOfficeName0);
        $I->wait(2);
        $I->fillField(Registration::$agencyAddressName0,User::$agencyAddressName0);
        $I->fillField(Registration::$agencyCabinet0,User::$agencyCabinet0Edit);
        //$this->click(EditProfilePage::$deleteOffice1);
        $I->fillField(Registration::$agencySocialVk, User::$agencySocialEmpty);
        $I->fillField(Registration::$agencySocialTw, User::$agencySocialTw);
        $I->wait(3);
        $I->click(Registration::$submit_edit_profileBtn);
        $I->wait(5);
//        $I->click(Registration::$submit_edit_profileModal);
        $I->wait(3);


        //TODO shedule
    }

    public function checkAgencyRegistration(){
        $I=$this;
        $I->wantTo('check registration of agency');
        $I->amOnPage(AdminUsersList::$users_list_url);
        $I->wait(2);
        $I->waitForElement(AdminUsersList::$searchByName);
        $I->fillField(AdminUsersList::$searchByName, User::getCurrentAgencyEmail());
        $I->click(AdminUsersList::$filterUsersBtn);
        $I->wait(2);
        $I->see(User::getCurrentAgencyEmail(), AdminUsersList::$agencyEmail);
        $I->wait(2);
        $I->click(AdminUsersList::$changeUserStatusBtn);
        $I->wait(2);
        $I->click(AdminUsersList::$statusesSelectClick);
        $I->wait(1);
        $I->fillField(AdminUsersList::$statusesSelect,AdminUsersList::$activeStateWord);
        $I->pressKey(AdminUsersList::$statusesSelect,WebDriverKeys::ENTER);
        $I->click(AdminUsersList::$submitStatusChangeBtn);
    }

    // ToDo in the future (if we need to delete agency)
    /*public function agencyDelete(){
        $I=$this;
        $I->wantTo('delete agent');
        $I->amOnPage(Registration::$employees_list_url);
        $I->wait(2);
        $I->click(AgencyEmployees::$agentDeleteBtn);
        $I->wait(2);
        $I->acceptDeleteUserModal();
    }*/

    function changeAgentStatus(){
        $I=$this;
        $I->wantTo('change agent status');
        $I->checkAgentRegistration();
        $I->see(User::$agentActiveStatus,AgencyEmployees::$agentStatus);
        $I->click(AgencyEmployees::$agentChangeStatusBtn);
        $I->reloadPage();
        $I->wait(3);
        $I->see(User::$agentNotActiveStatus,AgencyEmployees::$agentStatus);
        $I->click(AgencyEmployees::$agentChangeStatusBtn);
        $I->see(User::$agentNotActiveStatus,AgencyEmployees::$agentStatus);
    }
}