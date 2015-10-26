<?php
use \VpnTester;

class adminUS14_editAdvertCommercialCest
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

    public function addCommercialSaleAdvert(VpnTester $I)
    {
        $I->realtyCommercialAddComplex();
        $I->apiAdvertCommercialAddPlain();
    }

    public function adminEditCommercialAdvert(\Step\Vpn\AdminAdvert $I, VpnTester $common)
    {
        $common->loginAdmin();
        $I->openAdminEditCommercialPage();
        $I->adminEditCommercialAdvProperties();
        $I->adminFillInCommercialAdvCheckboxes();
        $I->adminUploadCommercialImages();
        $I->adminAddCommercialOwnerAndSubmit();
        $common->acceptModal();
    }
    public function checkAdminEditedCommercial(\Step\Vpn\AdminAdvert $I, VpnTester $web)
    {
        $web->loginAgency();
        $I->openWebCommercialAdvPage();
        $I->checkEditedCommercialProperties();
    }
}
