<?php

use \VpnTester;

class apiTesterCest
{
    //todo: create new api test
    protected function agencyLogin(VpnTester $I)
    {
        $I->apiAgencyLogin();
    }
    protected function userLogin(VpnTester $I)
    {
        $I->apiUserLogin();
    }
    protected function agentLogin(VpnTester $I)
    {
        $I->apiAgentLogin1();
    }

//    protected function moderateAdv($admin)
//    {
//        $admin->loginAdmin();
//        $admin->moderateAdvActive();
//    }
//
//    protected function open1stAdvert($list)
//    {
//        $list->openUserAdvertsList();
//        $list->openFirstListAdvert();
//    }
//
//    protected function addFlatSaleAdvert($api)
//    {
//        $api->realtyFlatAddComplex();
//        $api->apiAdvertFlatAddPlain();
//
//    }
//
//    protected function addHouseRentAdvert($api)
//    {
//        $api->realtyHouseAddComplex();
//        $api->apiAdvertHouseAddPlain();
//
//    }
//
//    protected function addParcelRentAdvert($api)
//    {
//        $api->realtyParcelAddComplex();
//        $api->apiAdvertParcelAddPlain();
//
//    }
//
//    protected function addCommercialSaleAdvert($api)
//    {
//        $api->realtyCommercialAddComplex();
//        $api->apiAdvertCommercialAddPlain();
//
//    }
//    /**
//     * @before agencyLogin
//     * @before adminLogin
//     *@before addCommercialSaleAdvert
//     *
//     */
//    function AddAdv (VpnTester $I)
//    {
//
//    }

    /**
     *@before agencyLogin
     */

    public function apiAgencyAddAnnouncementsList(VpnTester $I)
    {
        $I->apiAgencyAddAnnouncementsList();
        $I->apiGetAgencyAnnouncementsList();
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
     *@before agencyLogin
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
     *@before agencyLogin
     */
    public function apiAgentAnnouncementList(VpnTester $I)
    {
        $I->apiAgentAnnouncementList();
        $I->apiAgentEditAnnouncementList();
        $I->apiAgentDeleteAdvertAnnouncementList();
        $I->apiAgentDeleteAnnouncementList();
    }



}
