<?php
use \VpnTester;

class apiTesttCest
{
    protected function login(VpnTester $I)
    {
        $I->apiAdminLogin();
        $I->apiAgencyLogin();
    }

    public function findLastAverts(VpnTester $I)
    {
//        $I->apiGetLastRentAdverts();
//        $I->apiGetLastSaleAdverts();
        $I->getPeriod(1);
    }
}
