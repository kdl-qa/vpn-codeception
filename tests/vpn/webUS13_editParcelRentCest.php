<?php
use \VpnTester;

class webUS13_editParcelRentCest
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

    public function addParcelRentAdvert(VpnTester $I)
    {
        $I->realtyParcelAddComplex();
        $I->apiAdvertParcelAddPlain();
        $I->apiAdminEditParcelAdvertPlain();
    }

    public function editParcelRentAdvert(\Step\Vpn\EditAdvert $I, \Step\Vpn\Advert $he)
    {
        $I->loginAgency();
        $I->openEditParcelPage();
        $I->editParcelAdvert();
        $I->fillInEditParcelAdvertCheckboxes();
        $he->uploadParcelImage();
        $he->clickIamOwnerLink();
        $he->clickCreateAdvertButton();
        $he->acceptModal();
        $I->openAdvertPage();
    }

    public function checkParcelSaleAdvert(\Step\Vpn\EditAdvert $I)
    {
        $I->checkEditedParcelProperties();
    }
}
