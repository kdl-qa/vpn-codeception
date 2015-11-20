<?php
use \VpnTester;
use \Step\Vpn\Advert;

class webUS4_webUS6_PlainComplexCest
{
    protected function loginAgency(VpnTester $I)
    {
        $I->loginAgency();
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


     /**
      * @before loginAgency
      */
    public function createModerateCheckFlatSaleComplex(\Step\Vpn\Advert $I, \Step\Vpn\AdminAdvert $admin, \Step\Vpn\UserAdvertsList $list)
    {
        $I->fillInStandardFlatType();
        $I->fillInFlatAddress();
        $I->fillInFlatObjPropertiesComplex();
        $I->checkFlatObjectPropertiesComplex();
        $I->agreeObjectProperties();
        $I->fillInFlatAdvertPropertiesComplex();
        $I->fillInFlatAdvertCheckboxesComplex();
        $I->uploadFlatImage();
        $I->clickIamOwnerLink();
        $I->clickCreateAdvertButton();
        $I->acceptModal();

        $this->moderateAdv($admin);
        $this->open1stAdvert($list);

        $I->checkFlatPropertiesComplex();
    }


    /**
     * @before loginAgency
     */
    public function createModerateCheckFlatSalePlain(\Step\Vpn\Advert $I, \Step\Vpn\AdminAdvert $admin, \Step\Vpn\UserAdvertsList $list)
    {
        $I->fillInStandardFlatType();
        $I->fillInFlatAddress();
        $I->fillInFlatObjPropertiesPlain();
        $I->checkFlatObjectPropertiesPlain();
        $I->agreeObjectProperties();
        $I->fillInFlatAdvertPropertiesPlain();
        $I->clickIamOwnerLink();
        $I->clickCreateAdvertButton();
        $I->acceptModal();

        $this->moderateAdv($admin);
        $this->open1stAdvert($list);

        $I->checkFlatPropertiesPlain();
    }

    /**
     * @before loginAgency
     */
    public function createModerateCheckHouseRentComplex(\Step\Vpn\Advert $I, \Step\Vpn\AdminAdvert $admin, \Step\Vpn\UserAdvertsList $list)
    {
        $I->fillInStandardHouseType();
        $I->fillInHouseAddress();
        $I->fillInHouseObjPropertiesComplex();
        $I->checkHouseObjectPropertiesComplex();
        $I->agreeObjectProperties();
        $I->fillInHouseAdvertPropertiesComplex();
        $I->fillInHouseAdvertCheckboxesComplex();
        $I->uploadHouseImage();
        $I->clickIamOwnerLink();
        $I->clickCreateAdvertButton();
        $I->acceptModal();

        $this->moderateAdv($admin);
        $this->open1stAdvert($list);

        $I->checkHousePropertiesComplex();
    }

    /**
     * @before loginAgency
     */
    public function createModerateCheckHouseRentPlain(\Step\Vpn\Advert $I, \Step\Vpn\AdminAdvert $admin, \Step\Vpn\UserAdvertsList $list)
    {
        $I->fillInStandardHouseType();
        $I->fillInHouseAddress();
        $I->fillInHouseObjPropertiesPlain();
        $I->checkHouseObjectPropertiesPlain();
        $I->agreeObjectProperties();
        $I->fillInHouseAdvertPropertiesPlain();
        $I->clickIamOwnerLink();
        $I->clickCreateAdvertButton();
        $I->acceptModal();

        $this->moderateAdv($admin);
        $this->open1stAdvert($list);

        $I->checkHousePropertiesPlain();
    }

    /**
     * @before loginAgency
     */
    public function createModerateCheckParcelRentComplex(\Step\Vpn\Advert $I, \Step\Vpn\AdminAdvert $admin, \Step\Vpn\UserAdvertsList $list)
    {
        $I->fillInStandardParcelType();
        $I->fillInParcelAddress();
        $I->fillInParcelObjPropertiesComplex();
        $I->checkParcelObjectPropertiesComplex();
        $I->agreeObjectProperties();
        $I->fillInParcelAdvertPropertiesComplex();
        $I->fillInParcelAdvertCheckboxesComplex();
        $I->uploadCommercialImage();
        $I->clickIamOwnerLink();
        $I->clickCreateAdvertButton();
        $I->acceptModal();

        $this->moderateAdv($admin);
        $this->open1stAdvert($list);

        $I->checkParcelPropertiesComplex();
    }

    /**
     * @before loginAgency
     */
    public function createModerateCheckParcelRentPlain(\Step\Vpn\Advert $I, \Step\Vpn\AdminAdvert $admin, \Step\Vpn\UserAdvertsList $list)
    {
        $I->fillInStandardParcelType();
        $I->fillInParcelAddress();
        $I->fillInParcelObjPropertiesPlain();
        $I->checkParcelObjectPropertiesPlain();
        $I->agreeObjectProperties();
        $I->fillInParcelAdvertPropertiesPlain();
        $I->clickIamOwnerLink();
        $I->clickCreateAdvertButton();
        $I->acceptModal();

        $this->moderateAdv($admin);
        $this->open1stAdvert($list);

        $I->checkParcelPropertiesPlain();
    }

    /**
     * @before loginAgency
     */
    public function createModerateCheckCommercialSaleComplex(\Step\Vpn\Advert $I, \Step\Vpn\AdminAdvert $admin, \Step\Vpn\UserAdvertsList $list)
    {
        $I->fillInStandardCommercialType();
        $I->fillInCommercialAddress();
        $I->fillInCommercialObjPropertiesComplex();
        $I->checkCommercialObjectPropertiesComplex();
        $I->agreeObjectProperties();
        $I->fillInCommercialAdvertPropertiesComplex();
        $I->fillInCommercialAdvertCheckboxesComplex();
        $I->uploadCommercialImage();
        $I->clickIamOwnerLink();
        $I->clickCreateAdvertButton();
        $I->acceptModal();

        $this->moderateAdv($admin);
        $this->open1stAdvert($list);

        $I->checkCommercialPropertiesComplex();
    }

    /**
     * @before loginAgency
     */
    public function createModerateCheckCommercialSalePlain(\Step\Vpn\Advert $I, \Step\Vpn\AdminAdvert $admin, \Step\Vpn\UserAdvertsList $list)
    {
        $I->fillInStandardCommercialType();
        $I->fillInCommercialAddress();
        $I->fillInCommercialObjPropertiesPlain();
        $I->checkCommercialObjectPropertiesPlain();
        $I->agreeObjectProperties();
        $I->fillInCommercialAdvertPropertiesPlain();
        $I->clickIamOwnerLink();
        $I->clickCreateAdvertButton();
        $I->acceptModal();

        $this->moderateAdv($admin);
        $this->open1stAdvert($list);

        $I->checkCommercialPropertiesPlain();
    }
}
