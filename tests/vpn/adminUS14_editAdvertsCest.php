<?php
use \VpnTester;

class adminUS14_editAdvertsCest
{
    protected function apiLogin(VpnTester $I)
    {
        $I->apiAdminLogin();
        $I->apiAgencyLogin();
    }

    protected function uploadImages(VpnTester $I)
    {
        $I->uploadSchema();
    }

    protected function webLoginAdmin(VpnTester $I)
    {
        $I->loginAdmin();
    }

    protected function webLoginAgency($common)
    {
        $common->loginAgency();
    }

    protected function addApiFlatAdvert(VpnTester $I)
    {
        $I->realtyFlatAddComplex();
        $I->apiAdvertFlatAddPlain();
    }

    protected function addApiHouseAdvert(VpnTester $I)
    {
        $I->realtyHouseAddComplex();
        $I->apiAdvertHouseAddPlain();
    }

    protected function addApiParcelAdvert(VpnTester $I)
    {
        $I->realtyParcelAddComplex();
        $I->apiAdvertParcelAddPlain();
    }

    protected function addApiCommercialAdvert(VpnTester $I)
    {
        $I->realtyCommercialAddComplex();
        $I->apiAdvertCommercialAddPlain();
    }

    /**
     *@before uploadImages
     *@before apiLogin
     *@before addApiFlatAdvert
     *@before webLoginAdmin
     */
    public function adminEditFlatAdvert(\Step\Vpn\AdminAdvert $I, VpnTester $common)
    {
//        $common->loginAdmin();
        $I->openAdminEditFlatPage();
        $I->adminEditFlatAdvProperties();
        $I->adminFillInFlatAdvCheckboxes();
        $I->adminUploadFlatImages();
        $I->adminAddFlatOwnerAndSubmit();
        $common->acceptModal();

        $this->webLoginAgency($common);
        $I->openWebFlatAdvPage();
        $I->checkEditedFlatProperties();
    }

    /**
     *@before uploadImages
     *@before apiLogin
     *@before addApiHouseAdvert
     *@before webLoginAdmin
     */
    public function adminEditHouseAdvert(\Step\Vpn\AdminAdvert $I, VpnTester $common)
    {
        $I->openAdminEditHousePage();
        $I->adminEditHouseAdvProperties();
        $I->adminFillInHouseAdvCheckboxes();
        $I->adminUploadHouseImages();
        $I->adminAddHouseOwnerAndSubmit();
        $common->acceptModal();

        $this->webLoginAgency($common);
        $I->openWebHouseAdvPage();
        $I->checkEditedHouseProperties();
    }

    /**
     *@before uploadImages
     *@before apiLogin
     *@before addApiParcelAdvert
     *@before webLoginAdmin
     */
    public function adminEditParcelAdvert(\Step\Vpn\AdminAdvert $I, VpnTester $common)
    {
        $I->openAdminEditParcelPage();
        $I->adminEditParcelAdvProperties();
        $I->adminFillInParcelAdvCheckboxes();
        $I->adminUploadParcelImages();
        $I->adminAddParcelOwnerAndSubmit();
        $common->acceptModal();

        $this->webLoginAgency($common);
        $I->openWebParcelAdvPage();
        $I->checkEditedParcelProperties();
    }

    /**
     *@before uploadImages
     *@before apiLogin
     *@before addApiCommercialAdvert
     *@before webLoginAdmin
     */
    public function adminEditCommercialAdvert(\Step\Vpn\AdminAdvert $I, VpnTester $common)
    {
        $I->openAdminEditCommercialPage();
        $I->adminEditCommercialAdvProperties();
        $I->adminFillInCommercialAdvCheckboxes();
        $I->adminUploadCommercialImages();
        $I->adminAddCommercialOwnerAndSubmit();
        $common->acceptModal();

        $this->webLoginAgency($common);
        $I->openWebCommercialAdvPage();
        $I->checkEditedCommercialProperties();
    }

}
