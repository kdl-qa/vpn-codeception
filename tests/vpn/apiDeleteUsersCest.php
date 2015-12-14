<?php

use \Helper\Api;

class apiDeleteUserCest
{
    function deleteUsers(VpnTester $I){

        $I->apiAdminLogin();

        $I->apiUserRegistration();
        $I->apiAgencyRegistration();
        $I->apiAgentRegistration();


        $I->apiUserDelete();
        $I->apiAgentDelete();
        $I->apiAgencyDelete();

    }
}
