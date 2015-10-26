<?php
use \VpnTester;

class webUS4_addCommercialRentPlainCest
{
    public function createAndModerateCommercialAdvert(\Step\Vpn\Advert $I, \Step\Vpn\AdminAdvert $admin)
    {
        $I->loginAgency();

        $I->fillInStandardCommercialType();
        $I->fillInCommercialAddress();

        $I->fillInCommercialObjPropertiesPlain();
        $I->checkCommercialObjectPropertiesPlain();
        $I->agreeObjectProperties();
        $I->fillInCommercialAdvertPropertiesPlain();
        $I->clickIamOwnerLink();

        $I->clickCreateAdvertButton();
        $I->acceptModal();
//
        $admin->loginAdmin();
        $admin->moderateAdvActive();
    }

    public function checkNewCommercialAdvert(\Step\Vpn\Advert $I, \Step\Vpn\UserAdvertsList $list)
    {
        $I->loginAgency();
        $list->openUserAdvertsList();
        $list->openFirstListAdvert();
        $I->checkCommercialPropertiesPlain();
    }

}
