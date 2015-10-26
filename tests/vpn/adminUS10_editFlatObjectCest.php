<?php
use \VpnTester;

class adminUS10_editFlatObjectCest
{
    public function login(VpnTester $I)
    {
        $I->apiAdminLogin();
        $I->apiAgencyLogin();
    }

    public function addFlatObject(VpnTester $I)
    {
        $I->realtyFlatAddPlain();
    }

    public function adminEditFlatObject(VpnTester $I, Step\Vpn\AdmEditRealtyObject $obj)
    {
        $I->loginAdmin();
        $obj->openAdmEditFlatObjPage();
        $obj->editFlatObject();
        $I->acceptModal();
        $obj->checkEditFlatObject();
    }

}