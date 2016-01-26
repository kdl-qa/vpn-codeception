<?php
use Page\AnnouncementListPage;
use \VpnTester;

class webUS20_webUS26_crudGroupsCest
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

    protected function apiLogin(VpnTester $I)
    {
        $I->apiAdminLogin();
        $I->apiAgencyLogin();
    }
    protected function addApiFlatAdvert(VpnTester $I)
    {
        $I->realtyFlatAddForSearch();
        $I->apiAdvertFlatAddForSearch();
        $I->apiAdminEditFlatAdvertSearch();
    }


    protected function addApiHouseAdvert(VpnTester $I)
    {
        $I->realtyHouseAddSearch();
        $I->apiAdvertHouseAddSearch();
        $I->apiAdminEditHouseAdvertSearch();
    }

    protected function addApiParcelAdvert(VpnTester $I)
    {
        $I->realtyParcelAddSearch();
        $I->apiAdvertParcelAddSearch();
        $I->apiAdminEditParcelAdvertSearch();
    }
    protected function addApiCommercialAdvert(VpnTester $I)
    {
        $I->realtyCommercialAddSearch();
        $I->apiAdvertCommercialAddSearch();
        $I->apiAdminEditCommercialAdvertSearch();
    }
    protected function addApiGarageAdvert(VpnTester $I)
    {
        $I->realtyGarageAddForSearch();
        $I->apiAdvertGarageAddForSearch();
        $I->apiAdminEditGarageAdvertSearch();
    }

    /**
     *@before apiLogin
     *@before addApiFlatAdvert
     *@before addApiHouseAdvert
     *@before addApiParcelAdvert
     *@before addApiCommercialAdvert
     *@before addApiGarageAdvert
     *@before agencyLogin
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

    $list->openUserAdvertsList();
    $list->openFourthListAdvert();
    $I->addAdvertToGroupFromAdvPage();

    $list->openUserAdvertsList();
    $list->openFifthListAdvert();
    $I->addAdvertToGroupFromAdvPage();


    $I->sendGroupToUser();
//        $I->pauseExecution();

}

    /**
     * @before userLogin
     */
    public function viewAdvert(\Step\Vpn\AnnouncementList $I, Step\Vpn\Search $S)
{
    $I->viewAgencyGroupAndCheckProperties();



}

    /**
     * @before agencyLogin
     */
    public function editDeleteAdv(\Step\Vpn\AnnouncementList $I)
{
    $I->editGroupSaveInterest();
    $I->deleteAdvert();
    $I->checkAgencyAdvCount();
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
    $I->checkAgentAdvCount();
    $I->deleteGroup();
    }
    /**
     *@before apiLogin
     */
    public function apiDeleteAdverts(VpnTester $I)
    {
        $I->apiDeleteFlatAdvert();
        $I->apiDeleteHouseAdvert();
        $I->apiDeleteParcelAdvert();
        $I->apiDeleteCommercialAdvert();
        $I->apiDeleteGarageAdvert();

    }
}
