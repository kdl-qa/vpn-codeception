<?php
use \VpnTester;
use \Step\Vpn\Advert;

class webUS4_addFlatSaleComplexCest
{
    public function createAndModerateFlatAdvert(\Step\Vpn\Advert $I, \Step\Vpn\AdminAdvert $admin)
    {
        $I->loginAgency();

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


        $admin->loginAdmin();
        $admin->moderateAdvActive();
    }

    public function checkNewFlatAdvert(\Step\Vpn\Advert $I, \Step\Vpn\UserAdvertsList $list)
    {
        $I->loginAgency();
        $list->openUserAdvertsList();
        $list->openFirstListAdvert();
        $I->checkFlatPropertiesComplex();

    }
}
