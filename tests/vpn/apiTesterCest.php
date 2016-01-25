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
     *
     */

    public function apiAddGarageRealtyPlain (VpnTester $I)
    {

        $I->realtyGarageAddPlain();
        $I->realtyGarageEdit();
//        $I->apiAdvertGarageAddPlain();
//        $I->apiAdminEditGarageAdvertComplex();
    }
    /**
     * @before uploadImages
     *@before apiAgencyLogin
     * @before apiAdminLogin
     *
     */
    public function apiAddFlatRealtyPlain (VpnTester $I)
    {


        $I->realtyFlatAddPlain();
        $I->realtyFlatsEdit();
//        $I->apiAdvertFlatAddPlain();
//        $I->apiAdminEditFlatAdvertComplex();
    }
    /**
     * @before uploadImages
     *@before apiAgencyLogin
     * @before apiAdminLogin
     *
     */
    public function apiAddHouseRealtyPlai2n (VpnTester $I)
    {

        $I->realtyHouseAddPlain();
        $I->realtyHousesEdit();
//        $I->apiAdvertHouseAddComplex();
//        $I->apiAdminEditHouseAdvertPlain();
    }
    /**
     * @before uploadImages
     *@before apiAgencyLogin
     * @before apiAdminLogin
     *
     */
    public function apiAddParcel1RealtyPlai3n (VpnTester $I)
    {

        $I->realtyParcelAddComplex();
        $I->realtyParcelsEdit();
//        $I->apiAdvertParcelAddPlain();
//        $I->apiAdminEditParcelAdvertPlain();
    }
    /**
     * @before uploadImages
     *@before apiAgencyLogin
     * @before apiAdminLogin
     *
     */
    public function apiAddCommercial1RealtyPl4ain (VpnTester $I)
    {

        $I->realtyCommercialAddComplex();
        $I->realtyCommercialsEdit();
//        $I->apiAdvertCommercialAddPlain();
//        $I->apiAdminEditCommercialAdvertPlain();
    }


}