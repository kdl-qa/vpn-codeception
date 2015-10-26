<?php
use \VpnTester;

class webUS4_addHouseRentComplexCest
{
    public function createAndModerateHouseAdvert(\Step\Vpn\Advert $I, \Step\Vpn\AdminAdvert $admin)
    {
        $I->loginAgency();

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

        $admin->loginAdmin();
        $admin->moderateAdvActive();
    }

    public function checkNewFlatAdvert(\Step\Vpn\Advert $I, \Step\Vpn\UserAdvertsList $list)
    {
        $I->loginAgency();
        $list->openUserAdvertsList();
        $list->openFirstListAdvert();
        $I->checkHousePropertiesComplex();

    }

    // tests
//    public function tryToTest(VpnTester $I)
//    {
//    }
}
