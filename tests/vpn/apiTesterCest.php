<?php



class apiTesterCest
{

    protected function apiAdminLogin(VpnTester $I)
    {
    $I->apiAdminLogin();
    }

    protected function apiAgencyLogin(VpnTester $I)
    {
        $I->apiAgencyLogin();
    }

    protected function uploadImages(VpnTester $I)
    {
        $I->uploadSchema();
        $I->uploadAdvImages();
    }

    /**
     * @before uploadImages
     *@before apiAgencyLogin
     * @before apiAdminLogin
     */

    public function apiAddGarageRealtyPlain (VpnTester $I)
    {
//        $I->realtyGarageAddPlain();
        $I->apiAdvertGarageAddPlain();
//        $I->apiAdvertGarageAddComplex();
//        $I->realtyGarageCheck();
//        $I->realtyGarageEdit();
//        $I->pauseExecution();
//        $I->realtyGarageValidate();
//        $I->realtyGarageDelete();
    }
//    /**
//     * @before uploadImages
//     *@before apiAgencyLogin
//     * @before apiAdminLogin
//     */
//    public function apiAddGarageRealtyComplex (VpnTester $I)
//    {
//        $I->realtyGarageAddComplex();
//        $I->realtyGarageDelete();
//    }


}