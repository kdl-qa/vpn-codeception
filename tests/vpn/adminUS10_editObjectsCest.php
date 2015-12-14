<?php
use \VpnTester;

class adminUS10_editObjectsCest
{
    protected function apiLogin(VpnTester $I)
    {
        $I->apiAdminLogin();
        $I->apiAgencyLogin();
    }

    protected function addFlatObject(VpnTester $I)
    {
        $I->realtyFlatAddPlain();
    }

    protected function addHouseObject(VpnTester $I)
    {
        $I->realtyHouseAddPlain();
    }

    protected function addParcelObject(VpnTester $I)
    {
        $I->realtyParcelAddPlain();
    }

    protected function addCommercialObject(VpnTester $I)
    {
        $I->realtyCommercialAddPlain();
    }

    /**
     *@before apiLogin
     *@before addFlatObject
     */
    public function adminEditFlatObject(VpnTester $I, Step\Vpn\AdmEditRealtyObject $obj)
    {
        $I->loginAdmin();
        $obj->openAdmEditFlatObjPage();
        $obj->editFlatObject();
        $I->acceptModal();
        $I->wait(2);
        $obj->checkEditFlatObject();
    }

    /**
     *@before apiLogin
     *@before addHouseObject
     */
    public function adminEditHouseObject(VpnTester $I, Step\Vpn\AdmEditRealtyObject $obj)
    {
        $I->loginAdmin();
        $obj->openAdmEditHouseObjPage();
        $obj->editHouseObject();
        $I->acceptModal();
        $I->wait(2);
        $obj->checkEditHouseObject();
    }

    /**
     *@before apiLogin
     *@before addParcelObject
     */
    public function adminEditParcelObject(VpnTester $I, Step\Vpn\AdmEditRealtyObject $obj)
    {
        $I->loginAdmin();
        $obj->openAdmEditParcelObjPage();
        $obj->editParcelObject();
        $I->acceptModal();
        $I->wait(2);
        $obj->checkEditParcelObject();
    }

    /**
     *@before apiLogin
     *@before addCommercialObject
     */
    public function adminEditCommercialObject(VpnTester $I, Step\Vpn\AdmEditRealtyObject $obj)
    {
        $I->loginAdmin();
        $obj->openAdmEditCommercialObjPage();
        $obj->editCommercialObject();
        $I->acceptModal();
        $I->wait(2);
        $obj->checkEditCommercialObject();
    }
}