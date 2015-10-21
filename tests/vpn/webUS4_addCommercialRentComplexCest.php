<?php


class webUS4_addCommercialRentComplexCest
{
    public function createAndModerateCommercialAdvert(\Step\Vpn\Advert $I, \Step\Vpn\AdminAdvert $admin)
    {
        $I->loginAgency();

        $I->fillInStandardCommercialType();
        $I->fillInCommercialAddress();

        $I->acceptModal();
        $I->fillInCommercialObjPropertiesComplex();
        $I->checkCommercialObjectPropertiesComplex();
        $I->agreeObjectProperties();
        $I->fillInCommercialAdvertPropertiesComplex();
        $I->fillInCommercialAdvertCheckboxesComplex();
        $I->uploadCommercialImage();
        $I->clickIamOwnerLink();

        $I->clickCreateAdvertButton();
        $I->acceptModal();
//
        $admin->loginAdmin();
        $admin->moderateAdvActive();
    }

    public function checkNewFlatAdvert(\Step\Vpn\Advert $I, \Step\Vpn\UserAdvertsList $list)
    {
        $I->loginAgency();
        $list->openUserAdvertsList();
        $list->openFirstListAdvert();
        $I->checkCommercialPropertiesComplex();
    }
}