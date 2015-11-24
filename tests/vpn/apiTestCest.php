<?php
use \VpnTester;

class apiTestCest
{
    protected function loginAdmin(VpnTester $I)
    {
        $I->apiAdminLogin();
    }

    protected function addRealty(VpnTester $I)
    {
        $I->realtyCommercialAddPlain();
    }

    /**
     *@before loginAdmin
     *@before addRealty
     */
    public function getUserAdverts(VpnTester $I)
    {
        $I->apiAdminGetCommercialRealties();
    }
}
