<?php


class TestCest
{

    protected function agencyLogin(VpnTester $I)
    {
        $I->loginAgency();
    }
    protected function open1stAdvert($list)
    {
        $list->openUserAdvertsList();
        $list->openFirstListAdvert();
    }

    /**
     *@before agencyLogin
     */
    public function createGroupByAgency (\Step\Vpn\AnnouncementList $I)
    {
        $I->createAnnouncementList();

    }
    /**
     *@before agencyLogin
     *@before open1stAdvert
     */


}