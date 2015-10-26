<?php
use \VpnTester;

class adminUS14_editAdvertHouseCest
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

    public function addHouseSaleAdvert(VpnTester $I)
    {
        $I->realtyHouseAddComplex();
        $I->apiAdvertHouseAddPlain();
    }

    public function adminEditHouseAdvert(\Step\Vpn\AdminAdvert $I, VpnTester $common)
    {
        $common->loginAdmin();
        $I->openAdminEditHousePage();
        $I->adminEditHouseAdvProperties();
        $I->adminFillInHouseAdvCheckboxes();
        $I->adminUploadHouseImages();
        $I->adminAddHouseOwnerAndSubmit();
        $common->acceptModal();
    }
    public function checkAdminEditedHouse(\Step\Vpn\AdminAdvert $I, VpnTester $web)
    {
        $web->loginAgency();
        $I->openWebHouseAdvPage();
        $I->checkEditedHouseProperties();
    }
}

