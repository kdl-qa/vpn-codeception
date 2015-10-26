<?php
use \VpnTester;

class webUS13_editFlatSaleCest
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

    public function addFlatSaleAdvert( VpnTester $I)
    {
        $I->realtyFlatAddComplex();
        $I->apiAdvertFlatAddPlain();
        $I->apiAdminEditFlatAdvertPlain();
    }

    public function editFlatSaleAdvert(\Step\Vpn\EditAdvert $I, \Step\Vpn\Advert $he)
    {
        $I->loginAgency();
        $I->openEditFlatPage();
        $I->editFlatAdvert();
        $I->fillInEditFlatAdvertCheckboxes();
        $he->uploadHouseImage();
        $he->clickIamOwnerLink();
        $he->clickCreateAdvertButton();
        $he->acceptModal();
        $I->openAdvertPage();
    }

    public function checkFlatRentAdvert(\Step\Vpn\EditAdvert $I)
    {
        $I->checkEditedFlatProperties();
    }
}
