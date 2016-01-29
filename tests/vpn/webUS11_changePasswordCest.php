<?php
use \VpnTester;

class webUS11_changePasswordCest
{
    protected function agentLogin(VpnTester $I)
    {
        $I->loginAgent1();
    }
    protected function userLogin(VpnTester $I)
    {
        $I->userLogin();
    }

    protected function loginAgency(VpnTester $I)
    {
        $I->loginAgency1();
    }

    /**
     *@before userLogin
     */
    public function changeUserPassword (\Step\Vpn\EditProfile $I)
    {
        $I->changePassword();
    }
    /**
     *@before agentLogin
     */
    public function changeAgentPassword (\Step\Vpn\EditProfile $I)
    {
        $I->changePassword();
    }
    /**
     *@before loginAgency
     */
    public function changeAgencyPassword (\Step\Vpn\EditProfile $I)
    {
        $I->changePassword();
    }
}
