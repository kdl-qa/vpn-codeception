<?php

use \Helper\Api;

class apiDeleteUserCest
{
    function deleteUsers(VpnTester $I){

        $I->apiAdminLogin();

        $I->apiUserRegistration();
        $I->apiAgentRegistration();
        $I->apiAgencyRegistration();

        $I->apiUserDelete();
        $I->apiAgentDelete();
        $I->apiAgencyDelete();

    }
}