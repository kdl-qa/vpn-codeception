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

    public function addParcelSellAdvert(/*\Helper\Api $I,*/ VpnTester $I)
    {
        $I->realtyParcelAdd();
        $I->apiAdvertParcelAddPlain();
        $I->apiAdminEditParcelAdvertPlain();
    }

    public function editFlatSaleAdvert(\Step\Vpn\EditAdvert $I, \Step\Vpn\Advert $hi)
    {
        $I->loginAgency();
        $I->openEditParcelPage();
//        $I->pauseExecution();
        $I->editParcelAdvert();
        $I->fillInEditParcelAdvertCheckboxes();
        $hi->uploadFlatImage();
        $hi->clickIamOwnerLink();
        $hi->clickCreateAdvertButton();
        $hi->acceptModal();
        $I->openAdvertPage();
    }

    public function checkFlatRentAdvert(\Step\Vpn\EditAdvert $I)
    {
        $I->checkEditedParcelProperties();
    }
}
