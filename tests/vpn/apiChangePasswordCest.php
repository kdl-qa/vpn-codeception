<?php
use \VpnTester;

class apiChangePasswordCest
{

    protected function apiAgencyLogin3(VpnTester $I)
    {
        $I->apiAgencyLogin1();
    }
    protected function apiAgentLogin(VpnTester $I)
    {
        $I->apiAgentLogin();
    }
    protected function apiAgentLogin1(VpnTester $I)
    {
        $I->apiAgentLogin1();
    }
    protected function apiUserLogin(VpnTester $I)
    {
        $I->apiUserLogin();
    }

    /**
    //     *@before apiAgencyLogin3
    //     */
    public function apiChangeAgencyPassword(VpnTester $I)
    {
        $I->changeAgencyPassword();
    }

    /**
     *@before apiAgentLogin1
     */
    public function apiChangeAgentPassword(VpnTester $I)
    {
        $I->changeAgentPassword();
    }

    /**
     *@before apiUserLogin
     */
    public function apiChangeUserPassword (VpnTester $I)
    {
        $I->changeUserPassword();
    }
}
