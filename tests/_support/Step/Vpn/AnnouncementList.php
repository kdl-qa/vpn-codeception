<?php
namespace Step\Vpn;


use Data\User;
use Page\AdvPage;
use Page\AnnouncementListPage;
use Page\SearchPage;
use \Facebook\WebDriver\WebDriverKeys;

class AnnouncementList extends \VpnTester
{
    public function createAnnouncementList()
    {
        $I = $this;
        $I->amOnPage(AnnouncementListPage::$groupListUrl);
        $I->waitForElement(AnnouncementListPage::$createGroupButton);
        $I->click(AnnouncementListPage::$createGroupButton);
        $I->fillField(AnnouncementListPage::$groupNameField, User::$groupName);
        $I->click(AnnouncementListPage::$clientNameField);
        $I->fillField(AnnouncementListPage::$clientNameType, User::$userEmail);
        $I->click(AnnouncementListPage::$clientName0);
        $I->click(AnnouncementListPage::$submitButton);
        $I->waitForElement(AnnouncementListPage::$advGroupList);
    }

    public function addAdvertToGroupFromAdvPage()
    {
        $I = $this;
        $I->click(AdvPage::$advInfoAddGroup);
        $I->waitForElement(AnnouncementListPage::$selectGroupField);
        $I->click(AnnouncementListPage::$selectGroupField);
        $I->fillField(AnnouncementListPage::$selectGroupType, User::$groupName);
        $I->click(AnnouncementListPage::$selectGroup0);
        $I->click(AnnouncementListPage::$submitButton);
    }
    public function addAdvertToGroupFromListResultSearch()
    {
        $I = $this;
        $I->click(SearchPage::$addToGroup);
        $I->waitForElement(AnnouncementListPage::$selectGroupField);
        $I->click(AnnouncementListPage::$selectGroupField);
        $I->fillField(AnnouncementListPage::$selectGroupType, User::$groupName);
        $I->click(AnnouncementListPage::$selectGroup0);
        $I->click(AnnouncementListPage::$submitButton);
    }

    public function sendGroupToUser()
    {
        $I = $this;
        $I->amOnPage(AnnouncementListPage::$groupListUrl);
        $I->wait(2);
        $I->click(AnnouncementListPage::$showMore);
//        $I->see('Всего объявлений: 3', AnnouncementListPage::$groupInfLine);
        $I->see('Интересных клиенту: 0', AnnouncementListPage::$groupInfLine);
        $I->see('Не интересных клиенту: 0', AnnouncementListPage::$groupInfLine);
        $I->click(AnnouncementListPage::$sendUrlLink);
        $I->waitForElement(AnnouncementListPage::$modalPopup);
        $I->seeInField(AnnouncementListPage::$emailField, User::$userEmail);
        $I->fillField(AnnouncementListPage::$themeField, 'TEST');
        $I->click(AnnouncementListPage::$submitButton);


    }
    public function editGroupSaveInterest()
    {
        $I = $this;
        $I->amOnPage(AnnouncementListPage::$groupListUrl);
        $I->wait(2);
        $I->click(AnnouncementListPage::$showMore);
        $I->see('Интересных клиенту: 1', AnnouncementListPage::$groupInfLine);
        $I->see('Не интересных клиенту: 1', AnnouncementListPage::$groupInfLine);
        $I->click(AnnouncementListPage::$editGroupLink);
        $I->click(AnnouncementListPage::$generalInfo);
        $I->waitForElement(AnnouncementListPage::$groupNameField);
        $I->doubleClick(AnnouncementListPage::$groupNameField);
        $I->pressKey(AnnouncementListPage::$groupNameField, WebDriverKeys::DELETE);
        $I->wait(1);
        $I->fillField(AnnouncementListPage::$groupNameField, User::$editGroupName);
        $I->click(AnnouncementListPage::$clientNameField);
        $I->fillField(AnnouncementListPage::$clientNameType, 'asd');
        $I->click(AnnouncementListPage::$clientName0);
//        $I->pauseExecution();
        $I->click(AnnouncementListPage::$submitButton);
        $I->waitForElement(AnnouncementListPage::$modalPopup);
        $I->click(AnnouncementListPage::$goodButton);
        $I->wait(3);
        $I->see(User::$editGroupName,AnnouncementListPage::$groupTitle);
        $I->click(AnnouncementListPage::$showMore);
        $I->see('Интересных клиенту: 1', AnnouncementListPage::$groupInfLine);
        $I->see('Не интересных клиенту: 1', AnnouncementListPage::$groupInfLine);




    }
    public function editGroupResetInterest()
    {
        $I = $this;
        $I->amOnPage(AnnouncementListPage::$groupListUrl);
        $I->wait(2);
        $I->click(AnnouncementListPage::$showMore);
        $I->see('Интересных клиенту: 1', AnnouncementListPage::$groupInfLine);
        $I->see('Не интересных клиенту: 1', AnnouncementListPage::$groupInfLine);
        $I->click(AnnouncementListPage::$editGroupLink);
        $I->click(AnnouncementListPage::$generalInfo);
        $I->waitForElement(AnnouncementListPage::$groupNameField);
        $I->doubleClick(AnnouncementListPage::$groupNameField);
        $I->pressKey(AnnouncementListPage::$groupNameField, WebDriverKeys::DELETE);
        $I->wait(1);
        $I->fillField(AnnouncementListPage::$groupNameField, User::$editGroupName);
        $I->click(AnnouncementListPage::$clientNameField);
        $I->fillField(AnnouncementListPage::$clientNameType, 'asd');
        $I->click(AnnouncementListPage::$clientName0);
        $I->click(AnnouncementListPage::$clearInter);
//        $I->pauseExecution();
        $I->click(AnnouncementListPage::$submitButton);
        $I->waitForElement(AnnouncementListPage::$modalPopup);
        $I->click(AnnouncementListPage::$goodButton);
        $I->wait(3);
        $I->see(User::$editGroupName,AnnouncementListPage::$groupTitle);
        $I->click(AnnouncementListPage::$showMore);
        $a = file_get_contents(codecept_data_dir('advCount1.txt'));
        $b = file_get_contents(codecept_data_dir('advCount2.txt'));
        $count = array ($a,$b);
        $c = array_sum($count);
        $I->see('Всего объявлений: '.$c ,AnnouncementListPage::$groupInfLine);
        $I->see('Интересных клиенту: 0', AnnouncementListPage::$groupInfLine);
        $I->see('Не интересных клиенту: 0', AnnouncementListPage::$groupInfLine);




    }

    public function deleteGroup()
    {
        $I = $this;
        $I->amOnPage(AnnouncementListPage::$groupListUrl);
        $I->wait(2);
        $I->click(AnnouncementListPage::$showMore);
        $I->click(AnnouncementListPage::$deleteGroupLink);
        $I->waitForElement(AnnouncementListPage::$modalPopup);
        $I->click(AnnouncementListPage::$yesButton);
        $I->wait(2);
        $I->dontSeeElement(AnnouncementListPage::$showMore);
        $I->dontSeeElement(AnnouncementListPage::$noGroupDisplayed);
    }
    public function deleteAdvert()
    {
        $I = $this;
        $I->amOnPage(AnnouncementListPage::$groupListUrl);
        $I->wait(2);
        $I->click(AnnouncementListPage::$showMore);
        $I->click(AnnouncementListPage::$editGroupLink);
        $I->wait(2);
        $I->click(AnnouncementListPage::$deleteAdv1);
        $I->waitForElement(AnnouncementListPage::$modalPopup);
        $I->click(AnnouncementListPage::$goodButton);
        $I->wait(1);
        $I->click(AnnouncementListPage::$deleteAdv1);
        $I->waitForElement(AnnouncementListPage::$modalPopup);
        $I->click(AnnouncementListPage::$goodButton);
        $I->wait(1);
        $I->click(AnnouncementListPage::$deleteAdv1);
        $I->waitForElement(AnnouncementListPage::$modalPopup);
        $I->click(AnnouncementListPage::$goodButton);
        $I->wait(1);
//        $I->dontSeeElement(AnnouncementListPage::$deleteAdv1);
        $I->amOnPage(AnnouncementListPage::$groupListUrl);
        $I->wait(2);
        $I->click(AnnouncementListPage::$showMore);


    }
    public function checkAgencyAdvCount()
    {
        $I = $this;
        $I->amOnPage(AnnouncementListPage::$groupListUrl);
        $I->wait(2);
        $I->click(AnnouncementListPage::$showMore);

        $I->see('Всего объявлений: 0',AnnouncementListPage::$groupInfLine);
    }
    public function checkAgentAdvCount()
    {
        $I = $this;
        $I->amOnPage(AnnouncementListPage::$groupListUrl);
        $I->wait(2);
        $I->click(AnnouncementListPage::$showMore);
        $a = file_get_contents(codecept_data_dir('advCount1.txt'));
        $b = file_get_contents(codecept_data_dir('advCount2.txt'));
        $count = array ($a,$b);
        $c = array_sum($count) - 3;
        $I->see('Всего объявлений: '.$c,AnnouncementListPage::$groupInfLine);
    }

    public function viewAgencyGroup()
    {
        $I = $this;
        $I->amOnPage(AnnouncementListPage::$userGroupListUrl);
        $I->wait(2);
        $I->click(AnnouncementListPage::$showMore);
        $I->click(AnnouncementListPage::$groupUrl);
        $I->wait(2);
//        $I->pauseExecution();
        $I->see(User::$agencyUhomeName, AnnouncementListPage::$agencyInfoField);
        $I->see(User::$agencyEmail, AnnouncementListPage::$agencyInfoField);
        $I->seeElement(AnnouncementListPage::$image);
        $I->seeElement(AnnouncementListPage::$basicInfo);

        $I->click(AnnouncementListPage::$showMore1);
        $I->seeElement(AnnouncementListPage::$address);
        $I->seeElement(AnnouncementListPage::$mainProp);
        $I->seeElement(AnnouncementListPage::$description);
        $I->seeElement(AnnouncementListPage::$gallery);
        $I->click(AnnouncementListPage::$showMore2);
        $I->click(AnnouncementListPage::$interest1);
        $I->click(AnnouncementListPage::$unInterest2);


    }
    public function viewAgentGroup()
    {
        $I = $this;
        $I->amOnPage(AnnouncementListPage::$userGroupListUrl);
        $I->wait(2);
        $I->click(AnnouncementListPage::$showMore);
        $I->click(AnnouncementListPage::$groupUrl);
        $I->wait(2);
//        $I->pauseExecution();
        $I->see(User::$agentName, AnnouncementListPage::$agencyInfoField);
        $I->see(User::$agentEmail, AnnouncementListPage::$agencyInfoField);
        $I->seeElement(AnnouncementListPage::$image);
        $I->seeElement(AnnouncementListPage::$basicInfo);

        $I->click(AnnouncementListPage::$showMore1);
        $I->seeElement(AnnouncementListPage::$address);
        $I->seeElement(AnnouncementListPage::$mainProp);
        $I->seeElement(AnnouncementListPage::$description);
        $I->seeElement(AnnouncementListPage::$gallery);
        $I->click(AnnouncementListPage::$showMore2);
        $I->click(AnnouncementListPage::$interest1);
        $I->click(AnnouncementListPage::$unInterest2);


    }

}