<?php


class webUS10c_editAgentProfileCest
{
    public function editAgentProfile(Step\Vpn\EditProfile $I,Step\Vpn\RegisterUser $Agency)
    {
        //Question about login as agent
        //$I->apiUserRegistration();
        $I->loginAgent();
        $I->editAgentProfile();
        $I->checkAgentEditProfile();
        $I->logout();
        $Agency->loginAgencyTmp();
        $Agency->agentDelete();
    }

}