<?php
use \Helper\Api;
use VpnTester;

class webUS2a_registerPrivatePersonCest
{
    public function before(\Step\Vpn\RegisterUser $I)
    {
        $I->registerPrivatePerson();
    }


    public function after(VpnTester $I){
        //TODo - refactor method - we need to check that user was really registered
    }

}

