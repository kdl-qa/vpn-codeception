<?php
use \Helper\Api;
use VpnTester;

class webUS18_deleteAgentCest
{
    public function before(\Step\Vpn\RegisterUser $I)
    {
        $I->loginAgencyTmp();
        $I->registerAgent();
        $I->checkAgentRegistration();
        $I->agentDelete();
    }
}
