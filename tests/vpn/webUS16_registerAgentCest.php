<?php
use \Helper\Api;
use VpnTester;

class webUS16_registerAgentCest
{
    public function before(\Step\Vpn\RegisterUser $I)
    {
        $I->loginAgencyTmp();
        $I->registerAgent();
        $I->checkAgentRegistration();
        $I->agentDelete();
    }
}
