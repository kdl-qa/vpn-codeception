<?php

use \VpnTester;

class apiCrudAnnouncementListCest
{
    //todo: create new api test
    protected function apiAdminLogin(VpnTester $I)
    {
        $I->apiAdminLogin();
    }
    protected function apiAgencyLogin(VpnTester $I)
    {
        $I->apiAgencyLogin1();
    }
    protected function userLogin(VpnTester $I)
    {
        $I->apiUserLogin();
    }
    protected function apiAgentLogin(VpnTester $I)
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
     *@before apiAdminLogin
     *@before apiAgencyLogin
     *@before addApiFlatAdvert
     *@before addApiHouseAdvert
     *@before addApiParcelAdvert
     *@before addApiCommercialAdvert
     *
     */

    public function apiAgencyAddAnnouncementsList(VpnTester $I)
    {

        $I->apiAgencyAddAnnouncementsList();
        $I->apiAgencyAddAdvertToAnnouncementsList();
        $I->apiAgencySendAnnouncementListToUser();
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
     *@before apiAgencyLogin
     */
    public function apiAgencyAnnouncementList(VpnTester $I)
    {
        $I->apiAgencyAnnouncementList();
        $I->apiAgencyEditAnnouncementList();
        $I->apiGetAgencyAnnouncementsList();
        $I->apiAgencyDeleteAdvertAnnouncementList();
        $I->apiAgencyDeleteAnnouncementList();
    }

//---------------------------Agent-------------------------------//
    /**
     *@before apiAgentLogin
    */
    public function apiAgentAddAnnouncementsList(VpnTester $I)
    {
        $I->apiAgentAddAnnouncementsList();
        $I->apiAgentAddAdvertToAnnouncementsList();
        $I->apiAgentSendAnnouncementListToUser();
    }


    /**
     *@before userLogin
     */
    public function apiGetUserAnnouncementsList2(VpnTester $I)
    {
        $I->apiGetUserAnnouncementsList();
        $I->apiUserAnnouncementList1();
        $I->apiUserIsInterestingAdvert();
    }

    /**
     *@before apiAgentLogin
     */
    public function apiAgentAnnouncementList(VpnTester $I)
    {
        $I->apiAgentAnnouncementList();
        $I->pauseExecution();
        $I->apiAgentEditAnnouncementList();
        $I->apiGetAgentAnnouncementsList();
        $I->apiAgentDeleteAdvertAnnouncementList();
        $I->apiAgentDeleteAnnouncementList();
    }

    /**
     *@before apiAdminLogin
     */
    public function apiDeleteAdverts(VpnTester $I)
    {
        $I->apiDeleteFlatAdvert();
        $I->apiDeleteHouseAdvert();
        $I->apiDeleteParcelAdvert();
        $I->apiDeleteCommercialAdvert();
    }



}
