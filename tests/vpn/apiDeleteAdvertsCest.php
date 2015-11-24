<?php
use \VpnTester;

class apiDeleteAdvertsCest
{
    protected function apiAdminLogin(VpnTester $I)
    {
        $I->apiAdminLogin();
    }

    protected function apiAddRealties(VpnTester $I)
    {
        $I->realtyFlatAddPlain();
        $I->realtyHouseAddPlain();
        $I->realtyParcelAddPlain();
        $I->realtyCommercialAddPlain();
    }

    protected function apiAddAdverts(VpnTester $I)
    {
        $I->apiAdvertFlatAddPlain();
        $I->apiAdvertHouseAddPlain();
        $I->apiAdvertParcelAddPlain();
        $I->apiAdvertCommercialAddPlain();
    }

    /**
     *@before apiAdminLogin
     *@before apiAddRealties
     *@before apiAddAdverts
     */
    public function apiDeleteAdverts(VpnTester $I)
    {
        $I->apiDeleteFlatAdvert();
        $I->apiDeleteHouseAdvert();
        $I->apiDeleteParcelAdvert();
        $I->apiDeleteCommercialAdvert();

    }
}
