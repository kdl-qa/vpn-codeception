<?php
use \VpnTester;

class apiAgenciesSubdomainCest
{
    public function getProjectInfo(VpnTester $I)
    {

        $I->apiAgenciesInfo();
        $I->apiAgenciesServices();
        $I->apiAgenciesEmployees();
        $I->apiAgenciesAdverts();
    }
}