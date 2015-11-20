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
        $I->uploadAdvImage();
    }

    public function addHouseRentAdvert(VpnTester $I)
    {
        $I->realtyHouseAddComplex();
        $I->apiAdvertHouseAddPlain();
        $I->apiAdminEditHouseAdvertPlain();
    }

    public function editHouseRentAdvert(\Step\Vpn\EditAdvert $I, \Step\Vpn\Advert $hi)
    {
        $I->loginAgency();
        $I->openEditHousePage();
        $I->editHouseAdvert();
        $I->fillInEditHouseAdvertCheckboxes();
        $hi->uploadHouseImage();
        $hi->clickIamOwnerLink();
        $hi->clickCreateAdvertButton();
        $hi->acceptModal();
        $I->openAdvertPage();
    }

    public function checkHouseSaleAdvert(\Step\Vpn\EditAdvert $I)
    {
        $I->checkEditedHouseProperties();
    }
}