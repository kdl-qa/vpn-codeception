<?php


class webUS4_addParcelSaleComplexCest
{
    public function createAndModerateParcelAdvert(\Step\Vpn\Advert $I, \Step\Vpn\AdminAdvert $admin)
    {
        $I->loginAgency();

        $I->fillInStandardParcelType();
        $I->fillInParcelAddress();

        $I->acceptModal();
        $I->fillInParcelObjPropertiesComplex();
        $I->checkParcelObjectPropertiesComplex();
        $I->agreeObjectProperties();
        $I->fillInParcelAdvertPropertiesComplex();
        $I->fillInParcelAdvertCheckboxesComplex();
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
        $I->checkParcelPropertiesComplex();

    }

}