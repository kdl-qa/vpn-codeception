<?php
use \Helper\Api;
use VpnTester;

class webUS2a_registerAgencyCest
{
    public function before(\Step\Vpn\RegisterUser $I)
    {
        $I->registerAgency();
        $I->loginAdmin();
        $I->checkAgencyRegistration();
    }


}

