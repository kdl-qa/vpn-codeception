<?php

use \VpnTester;

class apiCrudAnnouncementListCest
{
    //todo: create new api test
    protected function apiLogin(VpnTester $I)
    {
        $I->apiAdminLogin();
        $I->apiAgencyLogin1();
    }
    protected function userLogin(VpnTester $I)
    {
        $I->apiUserLogin();
    }
    protected function agentLogin(VpnTester $I)
    {
        $I->apiAgentLogin1();
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



    /**
     *@before apiLogin
     *@before addApiFlatAdvert
     *@before addApiHouseAdvert
     *@before addApiParcelAdvert
     *@before addApiCommercialAdvert
     *
     */

    public function apiAgencyAddAnnouncementsList(VpnTester $I)
    {
        $I->apiAgencyAddAnnouncementsList();
        $I->pauseExecution();
        $I->apiGetAgencyAnnouncementsList();
        $I->pauseExecution();
        $I->apiAgencyAddAdvertToAnnouncementsList();
        $I->pauseExecution();
        $I->apiAgencySendAnnouncementListToUser();
        $I->pauseExecution();

    }

    /**
     *@before userLogin
     */
    public function apiGetUserAnnouncementsList(VpnTester $I)
    {
        $I->apiGetUserAnnouncementsList();
        $I->apiUserAnnouncementList();
        $I->apiUserIsInterestingAdvert();
    }

    /**
     *@before apiLogin
     */
    public function apiAgencyAnnouncementList(VpnTester $I)
    {
        $I->apiAgencyAnnouncementList();
        $I->apiAgencyEditAnnouncementList();
        $I->apiAgencyDeleteAdvertAnnouncementList();
        $I->apiAgencyDeleteAnnouncementList();
    }

//---------------------------Agent-------------------------------//
    /**
     *@before agentLogin
     */
    public function apiAgentAddAnnouncementsList(VpnTester $I)
    {
        $I->apiAgentAddAnnouncementsList();
        $I->apiGetAgentAnnouncementsList();
        $I->apiAgentAddAdvertToAnnouncementsList();
        $I->apiAgentSendAnnouncementListToUser();
    }



    /**
     *@before userLogin
     */
    public function apiGetUserAnnouncementsList2(VpnTester $I)
    {
        $I->apiGetUserAnnouncementsList();
        $I->apiUserAnnouncementList();
        $I->apiUserIsInterestingAdvert();
    }

    /**
     *@before apiLogin
     */
    public function apiAgentAnnouncementList(VpnTester $I)
    {
        $I->apiAgentAnnouncementList();
        $I->apiAgentEditAnnouncementList();
        $I->apiAgentDeleteAdvertAnnouncementList();
        $I->apiAgentDeleteAnnouncementList();
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

    }



}
