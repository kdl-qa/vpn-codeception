<?php
use \VpnTester;

class webUS14_unpublishFlatDealFinishedCest
{
    public function login(VpnTester $I)
    {
        $I->apiAdminLogin();
        $I->apiAgencyLogin();
    }

    public function uploadImages(VpnTester $I)
    {
        $I->uploadSchema();
        $I->uploadLogo();
        $I->uploadAdvImage();
    }

    public function addParcelSaleAdvert(/*\Helper\Api $I,*/ VpnTester $I)
    {
        $I->realtyFlatAdd();
        $I->apiAdvertFlatAddComplex();
        $I->apiAdminEditFlatAdvertComplex();
    }

    public function addDealFinishedRequest(\Step\Vpn\UnpublishAdvert $I, VpnTester $common)
    {
        $common->loginAgency();
        $I->openFlatUnpublishPage();
        $I->addDealFinishedReason();
        $common->acceptModal();
        $I->checkDealFinishedRequest();
    }

}
