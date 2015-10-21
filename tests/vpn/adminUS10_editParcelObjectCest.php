<?php
use \VpnTester;

class adminUS10_editParcelObjectCest
{
    public function login(VpnTester $I)
    {
        $I->apiAdminLogin();
        $I->apiAgencyLogin();
    }

    public function addParcelObject(VpnTester $I)
    {
        $I->realtyParcelAddPlain();
    }

    public function adminEditParcelObject(VpnTester $I, Step\Vpn\AdmEditRealtyObject $obj)
    {
        $I->loginAdmin();
        $obj->openAdmEditParcelObjPage();
        $obj->editParcelObject();
        $I->acceptModal();
        $obj->checkEditParcelObject();
    }
}
