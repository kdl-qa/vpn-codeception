<?php
use \VpnTester;

class adminUS10_editHouseObjectCest
{
    public function login(VpnTester $I)
    {
        $I->apiAdminLogin();
        $I->apiAgencyLogin();
    }

    public function addHouseSaleAdvert(VpnTester $I)
    {
        $I->realtyHouseAddPlain();
    }

    public function adminEditHouseObject(VpnTester $I, Step\Vpn\AdmEditRealtyObject $obj)
    {
        $I->loginAdmin();
        $obj->openAdmEditHouseObjPage();
        $obj->editHouseObject();
        $I->acceptModal();
        $obj->checkEditHouseObject();
    }
}
