<?php
use \VpnTester;
use \Helper\Api;

class api_realtyAddFlatCest
{
    public function _before(VpnTester $I)
    {
        $I->apiAgencyLogin();
    }

    public function _after(VpnTester $I)
    {
    }

    // tests
    public function realtyFlatAdd(VpnTester $I)
    {

    }
}
