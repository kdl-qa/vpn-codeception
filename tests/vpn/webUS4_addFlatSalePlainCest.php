<?php
use VpnTester;
use \Step\Vpn\Advert;


class webUS4_addFlatSalePlainCest
{
    public function createAndModerateFlatAdvert(\Step\Vpn\Advert $I, \Step\Vpn\AdminAdvert $admin)
    {
        $I->loginAgency();

        $I->fillInStandardFlatType();
        $I->fillInFlatAddress();

        $I->acceptModal();
        $I->fillInFlatObjPropertiesPlain();
        $I->checkFlatObjectPropertiesPlain();
        $I->agreeObjectProperties();
        $I->fillInFlatAdvertPropertiesPlain();
//        $I->fillInFlatAdvertCheckboxesComplex();
//        $I->uploadFlatImage();
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
        $I->checkFlatPropertiesPlain();

    }

    // tests
//    public function tryToTest(VpnTester $I)
//    {
//    }
}
