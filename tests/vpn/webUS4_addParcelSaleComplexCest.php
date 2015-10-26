<?php


class webUS4_addParcelSaleComplexCest
{
    public function createAndModerateParcelAdvert(\Step\Vpn\Advert $I, \Step\Vpn\AdminAdvert $admin)
    {
        $I->loginAgency();

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

        $admin->loginAdmin();
        $admin->moderateAdvActive();
    }

    public function checkNewParcelAdvert(\Step\Vpn\Advert $I, \Step\Vpn\UserAdvertsList $list)
    {
        $I->loginAgency();
        $list->openUserAdvertsList();
        $list->openFirstListAdvert();
        $I->checkParcelPropertiesComplex();

    }

}