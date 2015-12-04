<?php
use \Helper\Api;
use VpnTester;

class webUS17_changeAgentStatusCest
{
    public function before(Step\Vpn\RegisterUser $I)
    {
        $I->loginAgencyTmp();
        $I->registerAgent();
        $I->changeAgentStatus();
    }
}
