<?php
use \VpnTester;
use \Helper\Api;

class api_realtyAddFlatCest
{
    public function _before(VpnTester $I)
    {
        $I->apiAgencyLogin();
        $I->realtyFlatAdd();
        $I->realtyHouseAdd();
        $I->realtyParcelAdd();
        $I->realtyCommercialAdd();

    }

    // tests
    public function realtySomeTest(VpnTester $I)
    {

    }

    public function _after(VpnTester $I)
    {
    }

}
