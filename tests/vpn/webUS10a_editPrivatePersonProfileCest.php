<?php


class webUS10a_editPrivatePersonProfileCest
{
    public function editPrivatePersonProfile(Step\Vpn\EditProfile $I)
    {
        //$I->apiUserRegistration();
        $I->userLogin();
        $I->editUserProfile();
        $I->checkUserEditProfile();
    }

}