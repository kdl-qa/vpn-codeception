<?php



class apiTesterCest
{

    protected function apiLogin(VpnTester $I)
    {
//        $I->getAllLists();
        $I->apiAdminLogin();
        $I->apiAgencyLogin1();
    }

    /**
     * @before apiLogin
     */
    public function addApiFlatAdvert(VpnTester $I)
    {
        $I->apiAgencySaveFlatSearch();
//        $I->realtyFlatAddForSearch();
//        $I->wait(2);
//        $I->apiAdvertFlatAddForSearch();
//        $I->wait(2);
//        $I->apiAdminEditFlatAdvertSearch();
//        $I->wait(2);

    }
//    /**
//     * @before apiLogin
//     */
//    public function addApiHouseAdvert(VpnTester $I)
//    {
//        $I->realtyHouseAddSearch();
//        $I->wait(2);
//        $I->apiAdvertHouseAddSearch();
//        $I->wait(2);
//        $I->apiAdminEditHouseAdvertSearch();
//        $I->wait(2);
//    }
//    /**
//     * @before apiLogin
//     */
//    public function addApiParcelAdvert(VpnTester $I)
//    {
//        $I->realtyParcelAddSearch();
//        $I->wait(2);
//        $I->apiAdvertParcelAddSearch();
//        $I->wait(2);
//        $I->apiAdminEditParcelAdvertSearch();
//        $I->wait(2);
//    }
//    /**
//     * @before apiLogin
//     */
//    public function addApiCommercialAdvert(VpnTester $I)
//    {
//        $I->realtyCommercialAddSearch();
//        $I->wait(2);
//        $I->apiAdvertCommercialAddSearch();
//        $I->wait(2);
//        $I->apiAdminEditCommercialAdvertSearch();
//        $I->wait(2);
//    }
//    /**
//     * @before apiLogin
//     */
//    public function addApiGarageAdvert(VpnTester $I)
//    {
//        $I->realtyGarageAddForSearch();
//        $I->wait(2);
//        $I->apiAdvertGarageAddForSearch();
//        $I->wait(2);
//        $I->apiAdminEditGarageAdvertSearch();
//        $I->wait(2);
//    }


}