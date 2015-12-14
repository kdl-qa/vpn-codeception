<?php
use \VpnTester;

class webUS14_unpublishCest
{
    protected function uploadImages(VpnTester $I)
    {
//        $I->uploadSchema();
        $I->uploadAdvImages();
    }

    protected function apiLogin(VpnTester $I)
    {
        $I->apiAdminLogin();
        $I->apiAgencyLogin();
    }

    protected function addFlatSaleAdvert(VpnTester $I)
    {
        $I->realtyFlatAddPlain();
        $I->apiAdvertFlatAddComplex();
        $I->apiAdminEditFlatAdvertComplex();
    }

    /**
     *@before uploadImages
     *@before apiLogin
     *@before addFlatSaleAdvert
     */
    public function addOtherReasonRequest(\Step\Vpn\UnpublishAdvert $I, VpnTester $common)
    {
        $common->loginAgency();
        $I->openFlatUnpublishPage();
        $I->addOtherReason();
        $common->acceptModal();
        $I->checkOtherReasonRequest();
    }

    /**
     *@before uploadImages
     *@before apiLogin
     *@before addFlatSaleAdvert
     */
    public function addDealFinishedRequest(\Step\Vpn\UnpublishAdvert $I, VpnTester $common)
    {
        $common->loginAgency();
        $I->openFlatUnpublishPage();
        $I->addDealFinishedReason();
        $common->acceptModal();
        $I->checkDealFinishedRequest();
    }
    public function addDealFinishedRequestWithNeru(\Step\Vpn\UnpublishAdvert $I, VpnTester $common)
    {
        $common->loginAgency();
        $I->openFlatUnpublishPage();
        $I->addDealFinishedReasonNeru();
        $common->acceptModal();
        $I->checkDealFinishedRequestNeru();
    }
}
