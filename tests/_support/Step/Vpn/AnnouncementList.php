<?php
namespace Step\Vpn;


use Data\User;
use Page\AdvPage;
use Page\AnnouncementListPage;

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
    }

    public function AgencyAddAdvertToAnnouncementsList()
    {
        $I = $this;
        $I->click(AdvPage::$advInfoAddGroup);

    }

}