<?php
use \VpnTester;

class adminUS14_editAdvertParcelCest
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

    public function addParcelSaleAdvert(VpnTester $I)
    {
        $I->realtyParcelAddComplex();
        $I->apiAdvertParcelAddPlain();
    }

    public function adminEditParcelAdvert(\Step\Vpn\AdminAdvert $I, VpnTester $common)
    {
        $common->loginAdmin();
        $I->openAdminEditParcelPage();
        $I->adminEditParcelAdvProperties();
        $I->adminFillInParcelAdvCheckboxes();
        $I->adminUploadParcelImages();
        $I->adminAddParcelOwnerAndSubmit();
        $common->acceptModal();
    }
    public function checkAdminEditedParcel(\Step\Vpn\AdminAdvert $I, VpnTester $web)
    {
        $web->loginAgency();
        $I->openWebParcelAdvPage();
        $I->checkEditedParcelProperties();
    }
}
