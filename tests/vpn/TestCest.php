<?php


class TestCest
{

    protected function agencyLogin(VpnTester $I)
    {
        $I->loginAgency();
    }
    protected function agentLogin(VpnTester $I)
    {
        $I->loginAgent1();
    }
    protected function userLogin(VpnTester $I)
    {
        $I->userLogin();
    }


    /**
     * @before agencyLogin
     */
    public function createGroupByAgency(\Step\Vpn\AnnouncementList $I, \Step\Vpn\UserAdvertsList $list)
    {
        $I->createAnnouncementList();
        $list->openUserAdvertsList();
        $list->openFirstListAdvert();
        $I->addAdvertToGroupFromAdvPage();

        $list->openUserAdvertsList();
        $list->openSecondListAdvert();
        $I->addAdvertToGroupFromAdvPage();

        $list->openUserAdvertsList();
        $list->openThirdListAdvert();
        $I->addAdvertToGroupFromAdvPage();


        $I->sendGroupToUser();
//        $I->pauseExecution();

    }

    /**
     * @before userLogin
     */
    public function viewAdvert(\Step\Vpn\AnnouncementList $I)
    {
        $I->viewAgencyGroup();

    }

    /**
     * @before agencyLogin
     */
    public function editDeleteAdv(\Step\Vpn\AnnouncementList $I)
    {
        $I->editGroupSaveInterest();
        $I->deleteAdvert();
        $I->deleteGroup();
    }


    /**
     * @before agentLogin
     */

    public function createGroup(\Step\Vpn\AnnouncementList $I, \Step\Vpn\Search $search)
    {
        $I->createAnnouncementList();
        $search->searchFlatCategory();
        $I->addAdvertToGroupFromListResultSearch();

        $search->mapSearchHouseCategory();
        $I->addAdvertToGroupFromListResultSearch();

        $I->sendGroupToUser();

//        $I->pauseExecution();
    }

    /**
     * @before userLogin
     */
    public function viewAdverts(\Step\Vpn\AnnouncementList $I)
    {
        $I->viewAgentGroup();

    }
    /**
     * @before agentLogin
     */
    public function deleteAgentGroup(\Step\Vpn\AnnouncementList $I)
    {
        $I->editGroupResetInterest();
        $I->deleteAdvert();
        $I->deleteGroup();
    }



}