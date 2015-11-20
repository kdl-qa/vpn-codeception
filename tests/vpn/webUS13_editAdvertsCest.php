<?php
use \VpnTester;

class webUS13_editAdvertsCest
{
/*=========================================dependencies=========================================*/
    protected function login(VpnTester $I)
    {
        $I->apiAdminLogin();
        $I->apiAgencyLogin();
    }

    protected function moderateAdv($admin)
    {
        $admin->loginAdmin();
        $admin->moderateAdvActive();
    }

    protected function open1stAdvert($list)
    {
        $list->openUserAdvertsList();
        $list->openFirstListAdvert();
    }

    protected function addFlatSaleAdvert($api)
    {
        $api->realtyFlatAddComplex();
        $api->apiAdvertFlatAddPlain();
        $api->apiAdminEditFlatAdvertPlain();
    }

    protected function addHouseRentAdvert($api)
    {
        $api->realtyHouseAddComplex();
        $api->apiAdvertHouseAddPlain();
        $api->apiAdminEditHouseAdvertPlain();
    }

    protected function addParcelRentAdvert($api)
    {
        $api->realtyParcelAddComplex();
        $api->apiAdvertParcelAddPlain();
        $api->apiAdminEditParcelAdvertPlain();
    }

    protected function addCommercialSaleAdvert($api)
    {
        $api->realtyCommercialAddComplex();
        $api->apiAdvertCommercialAddPlain();
        $api->apiAdminEditCommercialAdvertPlain();
    }

    protected function uploadImages(VpnTester $I)
    {
        $I->uploadAdvImage();
        $I->uploadSchema();
    }

/*==============================================webUS13==========================================*/

    /**
     * @before uploadImages
     * @before login
     */
    public function addEditCheckFlatSaleAdvert(VpnTester $api, \Step\Vpn\EditAdvert $I, \Step\Vpn\Advert $he, \Step\Vpn\AdminAdvert $admin, \Step\Vpn\UserAdvertsList $list)
    {
        $this->addFlatSaleAdvert($api);

        $I->loginAgency();
        $I->openEditFlatPage();
        $I->editFlatAdvert();
        $I->fillInEditFlatAdvertCheckboxes();
        $he->uploadHouseImage();
        $he->clickIamOwnerLink();
        $he->clickCreateAdvertButton();
        $he->acceptModal();

        //todo: add admin function to do 2nd moderate (new functional)
        $this->moderateAdv($admin);

        $this->open1stAdvert($list);

        $I->checkEditedFlatProperties();
    }


    /**
     * @before uploadImages
     * @before login
     */
    public function addEditCheckHouseRentAdvert(VpnTester $api, \Step\Vpn\EditAdvert $I, \Step\Vpn\Advert $he, \Step\Vpn\AdminAdvert $admin, \Step\Vpn\UserAdvertsList $list)
    {
        $this->addHouseRentAdvert($api);

        $I->loginAgency();
        $I->openEditHousePage();
        $I->editHouseAdvert();
        $I->fillInEditHouseAdvertCheckboxes();
        $he->uploadHouseImage();
        $he->clickIamOwnerLink();
        $he->clickCreateAdvertButton();
        $he->acceptModal();

        //todo: add admin function to do 2nd moderate (new functional)
        $this->moderateAdv($admin);

        $this->open1stAdvert($list);

        $I->checkEditedHouseProperties();
    }

    /**
     * @before uploadImages
     * @before login
     */
    public function addEditCheckParcelRentAdvert(VpnTester $api, \Step\Vpn\EditAdvert $I, \Step\Vpn\Advert $he, \Step\Vpn\AdminAdvert $admin, \Step\Vpn\UserAdvertsList $list)
    {
        $this->addParcelRentAdvert($api);

        $I->loginAgency();
        $I->openEditParcelPage();
        $I->editParcelAdvert();
        $I->fillInEditParcelAdvertCheckboxes();
        $he->uploadParcelImage();
        $he->clickIamOwnerLink();
        $he->clickCreateAdvertButton();
        $he->acceptModal();

        //todo: add admin function to do 2nd moderate (new functional)
        $this->moderateAdv($admin);

        $this->open1stAdvert($list);

        $I->checkEditedParcelProperties();
    }

    /**
     * @before uploadImages
     * @before login
     */
    public function addEditCheckCommercialRentAdvert(VpnTester $api, \Step\Vpn\EditAdvert $I, \Step\Vpn\Advert $he, \Step\Vpn\AdminAdvert $admin, \Step\Vpn\UserAdvertsList $list)
    {
        $this->addCommercialSaleAdvert($api);

        $I->loginAgency();
        $I->openEditCommercialPage();
        $I->editCommercialAdvert();
        $I->fillInEditCommercialAdvertCheckboxes();
        $he->uploadCommercialImage();
        $he->clickIamOwnerLink();
        $he->clickCreateAdvertButton();
        $he->acceptModal();

        //todo: add admin function to do 2nd moderate (new functional)
        $this->moderateAdv($admin);

        $this->open1stAdvert($list);

        $I->checkEditedCommercialProperties();
    }
}
