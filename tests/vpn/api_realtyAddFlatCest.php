<?php
use \Helper\Api;
use Page\AdvertsList;
use \Step\Vpn\UserAdvertsList;
use \Data\Flat;

class api_realtyAddFlatCest
{
    public function before(VpnTester $I)
    {
        $I->apiAgencyLogin();
        $I->apiAdminLogin();
//        $I->realtyFlatAddPlain();
//        $I->realtyHouseAddPlain();
//        $I->realtyParcelAddPlain();
//        $I->realtyCommercialAddPlain();
//        $I->advertFlatAdd();
    }

    public function uploadImages(VpnTester $I)
    {
        $I->uploadSchema();
        $I->uploadLogo();
        $I->uploadAdvImage();
    }

    public function addAdv(VpnTester $I)
    {
        $I->realtyFlatAdd();
        $I->advertFlatAdd();
    }

    public function editFlatAdvert(VpnTester $I)
    {
        $I->apiAdminEditFlatAdvert();
    }
    // tests
//    public function checkCreatingAdvert(\Step\Vpn\Advert $I, \Step\Vpn\UserAdvertsList $listSteps)
//    {
//        $I->loginAgency();
//        $listSteps->checkAdvFlatProperties();
//
//    }
//
//    public function _after(VpnTester $I)
//    {
//    }

}
