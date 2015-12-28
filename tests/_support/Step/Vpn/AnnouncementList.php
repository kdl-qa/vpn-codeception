<?php
namespace Step\Vpn;


use Data\User;
use Page\AdvPage;
use Page\AnnouncementListPage;
use Page\SearchPage;

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
        $I->pauseExecution();
        $I->fillField(AnnouncementListPage::$groupNameField, User::$editGroupName);
        $I->click(AnnouncementListPage::$clientNameField);
        $I->fillField(AnnouncementListPage::$clientNameType, 'asd');
        $I->click(AnnouncementListPage::$clientName0);
        $I->pauseExecution();
        $I->click(AnnouncementListPage::$submitButton);
        $I->waitForElement(AnnouncementListPage::$submitButton);
        $I->click(AnnouncementListPage::$submitButton);
        $I->wait(3);
        $I->see(User::$groupName.User::$editGroupName,AnnouncementListPage::$groupTitle);
        $I->click(AnnouncementListPage::$showMore);
        $I->see('Интересных клиенту: 1', AnnouncementListPage::$groupInfLine);
        $I->see('Не интересных клиенту: 1', AnnouncementListPage::$groupInfLine);




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
    }

    public function viewGroup()
    {
        $I = $this;
        $I->amOnPage(AnnouncementListPage::$userGroupListUrl);
        $I->wait(2);
        $I->click(AnnouncementListPage::$showMore);
        $I->click(AnnouncementListPage::$groupUrl);
        $I->wait(2);
        $I->pauseExecution();
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

}