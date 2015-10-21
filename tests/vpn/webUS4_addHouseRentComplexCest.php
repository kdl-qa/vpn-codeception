<?php
use \VpnTester;

class webUS4_addHouseRentComplexCest
{
    public function createAndModerateHouseAdvert(\Step\Vpn\Advert $I, \Step\Vpn\AdminAdvert $admin)
    {
        $I->loginAgency();

        $I->fillInStandardHouseType();
        $I->fillInHouseAddress();

        $I->acceptModal();
        $I->fillInHouseObjPropertiesPlain();
        $I->checkHouseObjectProperties();
        $I->agreeObjectProperties();
        $I->fillInHouseAdvertProperties();
        $I->fillInHouseAdvertCheckboxes();
        $I->uploadHouseImage();
//        $I->fillInOwnerContactsData(); /*clickIamOwnerLink()*/
        $I->clickIamOwnerLink();
//        $I->pauseExecution();
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
        $I->checkHouseProperties();

    }

    // tests
//    public function tryToTest(VpnTester $I)
//    {
//    }
}
