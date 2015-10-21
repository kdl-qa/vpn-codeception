<?php


class webUS13_editHouseRentCest
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

    public function addHouseRentAdvert(/*\Helper\Api $I,*/ VpnTester $I)
    {
        $I->realtyHouseAddComplex();
        $I->apiAdvertHouseAddPlain();
        $I->apiAdminEditHouseAdvertPlain();
    }

    public function editHouseSaleAdvert(\Step\Vpn\EditAdvert $I, \Step\Vpn\Advert $hi)
    {
        $I->loginAgency();
        $I->openEditHousePage();
//        $I->pauseExecution();
        $I->editHouseAdvert();
        $I->fillInEditHouseAdvertCheckboxes();
        $hi->uploadHouseImage();
        $hi->clickIamOwnerLink();
        $hi->clickCreateAdvertButton();
        $hi->acceptModal();
        $I->openAdvertPage();
    }

    public function checkHouseRentAdvert(\Step\Vpn\EditAdvert $I)
    {
        $I->checkEditedHouseProperties();
    }
}