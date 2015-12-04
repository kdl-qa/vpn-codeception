<?php

use \Helper\Api;

class apiChangeUserStatusesCest
{
    function changeUserStatuses(VpnTester $I){

        $I->uploadLogo();
        $I->uploadUserAvatar();

        $I->apiAdminLogin();

        $I->apiUserRegistration();
        $I->apiDeActivateUser();
        $I->apiActivateUser();


        $I->apiAgencyRegistration();
        $I->apiActivateAgency();


        $I->apiAgentRegistration();

        $I->apiDeActivateAgent();
        $I->apiActivateAgent();

        $I->apiDeActivateAgency();
        $I->apiActivateAgency();

    }
}
