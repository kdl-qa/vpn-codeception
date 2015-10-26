<?php


class webUS4_addParcelSalePlainCest
{
    public function createAndModerateParcelAdvert(\Step\Vpn\Advert $I, \Step\Vpn\AdminAdvert $admin)
    {
        $I->loginAgency();

        $I->fillInStandardParcelType();
        $I->fillInParcelAddress();

        $I->fillInParcelObjPropertiesPlain();
        $I->checkParcelObjectPropertiesPlain();
        $I->agreeObjectProperties();
        $I->fillInParcelAdvertPropertiesPlain();
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
        $I->checkParcelPropertiesPlain();

    }

}
