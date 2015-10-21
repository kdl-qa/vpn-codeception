<?php
use \VpnTester;

class webUS4_addParcelSalePlainCest
{
    public function createAndModerateParcelAdvert(\Step\Vpn\Advert $I, \Step\Vpn\AdminAdvert $admin)
    {
        $I->loginAgency();

        $I->fillInStandardParcelType();
        $I->fillInParcelAddress();

        $I->acceptModal();
        $I->fillInParcelObjPropertiesPlain();
        $I->checkParcelObjectPropertiesPlain();
        $I->agreeObjectProperties();
        $I->fillInParcelAdvertPropertiesPlain();
        $I->fillInParcelAdvertCheckboxesComplex();
        $I->uploadParcelImage();
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
        $I->checkParcelProperties();

    }

    // tests
//    public function tryToTest(VpnTester $I)
//    {
//    }
}
