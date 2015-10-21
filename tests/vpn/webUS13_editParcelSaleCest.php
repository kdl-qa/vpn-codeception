<?php
use \VpnTester;

class webUS13_editParcelSaleCest
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

    public function addParcelRentAdvert(/*\Helper\Api $I,*/ VpnTester $I)
    {
        $I->realtyParcelAddPlain();
        $I->apiAdvertParcelAddPlain();
        $I->apiAdminEditParcelAdvertPlain();
    }

    public function editParcelSaleAdvert(\Step\Vpn\EditAdvert $I, \Step\Vpn\Advert $he)
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

    public function checkParcelRentAdvert(\Step\Vpn\EditAdvert $I)
    {
        $I->checkEditedParcelProperties();
    }
}
