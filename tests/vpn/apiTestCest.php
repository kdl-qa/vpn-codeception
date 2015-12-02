<?php
use \VpnTester;

class apiTestCest
{
    protected function uplCertificate(VpnTester $I)
    {
        $I->uploadCertificates();
    }

    protected function agencyLogin(VpnTester $I)
    {
        $I->apiAgencyLogin();
    }

    /**
     *@before agencyLogin
     */
    public function apiUsers(VpnTester $I)
    {
//        $I->apiAdminUsersList();
//        $I->apiAdminUsersStatistic();
//        $I->apiUserById();
//        $I->apiAgencyEditServices();

        $I->apiAgencyAgents();
    }
}
