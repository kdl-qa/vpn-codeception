<?php


class webUS10b_editAgencyProfileCest
{
    public function editAgentProfile(Step\Vpn\EditProfile $I)
    {
        //Question about login as agency
        $I->loginAgencyTmp();
        $I->editAgencyProfile();
        $I->checkAgencyEditProfile();
    }

}