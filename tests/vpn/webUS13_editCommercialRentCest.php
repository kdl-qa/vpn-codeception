<?php
use \VpnTester;

class webUS13_editCommercialRentCest
{
    public function login(VpnTester $I)
    {
        $I->apiAdminLogin();
        $I->apiAgencyLogin();
    }

    public function uploadImages(VpnTester $I)
    {
        $I->uploadSchema();
        $I->uploadLogo();
        $I->uploadAdvImage();
    }

    public function addCommercialSaleAdvert(/*\Helper\Api $I,*/ VpnTester $I)
    {
        $I->realtyCommercialAddComplex();
        $I->apiAdvertCommercialAddPlain();
        $I->apiAdminEditCommercialAdvertPlain();
    }

    public function editCommercialRentAdvert(\Step\Vpn\EditAdvert $I, \Step\Vpn\Advert $hi)
    {
        $I->loginAgency();
        $I->openEditCommercialPage();
        $I->editCommercialAdvert();
        $I->fillInEditCommercialAdvertCheckboxes();
        $hi->uploadCommercialImage();
        $hi->clickIamOwnerLink();
        $hi->clickCreateAdvertButton();
        $hi->acceptModal();
        $I->openAdvertPage();
    }

    public function checkCommercialRentAdvert(\Step\Vpn\EditAdvert $I)
    {
        $I->checkEditedCommercialProperties();
    }
}
