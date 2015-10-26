<?php
use \VpnTester;

class adminUS14_editAdvertFlatCest
{
    public function login(VpnTester $I)
    {
        $I->apiAdminLogin();
        $I->apiAgencyLogin();
    }

    public function uploadImages(VpnTester $I)
    {
        $I->uploadSchema();
    }

    public function addFlatSaleAdvert(VpnTester $I)
    {
        $I->realtyFlatAddComplex();
        $I->apiAdvertFlatAddPlain();
    }

    public function adminEditFlatAdvert(\Step\Vpn\AdminAdvert $I, VpnTester $common)
    {
        $common->loginAdmin();
        $I->openAdminEditFlatPage();
        $I->adminEditFlatAdvProperties();
        $I->adminFillInFlatAdvCheckboxes();
        $I->adminUploadFlatImages();
        $I->adminAddFlatOwnerAndSubmit();
        $common->acceptModal();
    }
    public function checkAdminEditedFlat(\Step\Vpn\AdminAdvert $I, VpnTester $web)
    {
        $web->loginAgency();
        $I->openWebFlatAdvPage();
        $I->checkEditedFlatProperties();
    }
}
