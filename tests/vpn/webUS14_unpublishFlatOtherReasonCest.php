<?php
use \VpnTester;

class webUS14_unpublishFlatOtherReasonCest
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

    public function addOtherReasonRequest(\Step\Vpn\UnpublishAdvert $I, VpnTester $common)
    {
        $common->loginAgency();
        $I->openFlatUnpublishPage();
        $I->addOtherReason();
        $common->acceptModal();
        $I->checkOtherReasonRequest();
    }

}
