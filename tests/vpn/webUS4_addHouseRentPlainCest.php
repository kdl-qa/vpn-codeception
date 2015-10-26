<?php
use \VpnTester;

class webUS4_addHouseRentPlainCest
{
    public function createAndModerateHouseAdvert(\Step\Vpn\Advert $I, \Step\Vpn\AdminAdvert $admin)
    {
        $I->loginAgency();

        $I->fillInStandardHouseType();
        $I->fillInHouseAddress();

        $I->fillInHouseObjPropertiesPlain();
        $I->checkHouseObjectPropertiesPlain();
        $I->agreeObjectProperties();
        $I->fillInHouseAdvertPropertiesPlain();
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
        $I->checkHousePropertiesPlain();

    }


}