<?php
use \VpnTester;

class apiAdvertComplexCest
{

    protected function uploadFlatImages(VpnTester $I)
    {
        $I->uploadSchema(0);
        $I->uploadAdvImages(0);

    }
    protected function uploadHouseImages(VpnTester $I)
    {
        $I->uploadSchema(1);
        $I->uploadAdvImages(1);

    }
    protected function uploadParcelImages(VpnTester $I)
    {
        $I->uploadSchema(2);
        $I->uploadAdvImages(2);

    }
    protected function uploadCommercialImages(VpnTester $I)
    {
        $I->uploadSchema(1);
        $I->uploadAdvImages(3);

    }

    protected function uploadGarageImages(VpnTester $I)
    {
        $I->uploadSchema(3);
        $I->uploadAdvImages(4);

    }
    protected function agencyLogin(VpnTester $I)
    {
//        $I->getAllLists();
        $I->apiAgencyLogin1();
//        $I->apiAgentLogin1();
//        $I->apiUserLogin();
        $I->apiAdminLogin();
    }

    /**
     * @before uploadFlatImages
     *@before agencyLogin
     */
    public function addFlatComplex(VpnTester $I)
    {
        $I->realtyFlatAddComplex();
        $I->apiAdvertFlatAddComplex();
        $I->apiAdminEditFlatAdvertComplex();

    }

//    /**
//     * @before uploadHouseImages
//     *@before agencyLogin
//     */
//    public function addHouseComplex(VpnTester $I)
//    {
//        $I->realtyHouseAddComplex();
//        $I->apiAdvertHouseAddComplex();
//        $I->apiAdminEditHouseAdvertComplex();
//    }
//
//    /**
//     * @before uploadParcelImages
//     *@before agencyLogin
//     */
//    public function addParcelComplex(VpnTester $I)
//    {
//        $I->realtyParcelAddComplex();
//        $I->apiAdvertParcelAddComplex();
//        $I->apiAdminEditParcelAdvertComplex();
//    }
//
//    /**
//     * @before uploadCommercialImages
//     *@before agencyLogin
//     */
//    public function addCommercialComplex(VpnTester $I)
//    {
//        $I->realtyCommercialAddComplex();
//        $I->apiAdvertCommercialAddComplex();
//        $I->apiAdminEditCommercialAdvertComplex();
//    }
//    /**
//     * @before uploadGarageImages
//     *@before agencyLogin
//     */
//    public function addGarageComplex(VpnTester $I)
//    {
//        $I->realtyGarageAddComplex();
//        $I->apiAdvertGarageAddComplex();
//        $I->apiAdminEditGarageAdvertComplex();
//    }
}