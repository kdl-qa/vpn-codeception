<?php
use \VpnTester;

class adminUS10_editCommercialObjectCest
{
    public function login(VpnTester $I)
    {
        $I->apiAdminLogin();
        $I->apiAgencyLogin();
    }

    public function addCommercialObject(VpnTester $I)
    {
        $I->realtyCommercialAddPlain();
    }

    public function adminEditCommercialObject(VpnTester $I, Step\Vpn\AdmEditRealtyObject $obj)
    {
        $I->loginAdmin();
        $obj->openAdmEditCommercialObjPage();
        $obj->editCommercialObject();
        $I->acceptModal();
        $obj->checkEditCommercialObject();
    }
}
