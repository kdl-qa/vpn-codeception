<?php

namespace Step\Vpn;

use Page\BackoffAdverts;
use \Data\Flat;

class AdminAvert extends \VpnTester
{
    public function moderateAdvActive()
    {
        $I=$this;
        $I->amOnPage(BackoffAdverts::$advListURL);
        $I->waitForElement(BackoffAdverts::$advListActionLink0);
        $I->click(BackoffAdverts::$advListActionLink0);
        $I->waitForElement(BackoffAdverts::$advEditStatus);
        $I->click(BackoffAdverts::$advEditStatus);
        $I->fillField(BackoffAdverts::$advEditStatus, Flat::status1);
        $I->click(BackoffAdverts::$chooseFirstRow);
        $I->click(BackoffAdverts::$advEditSubmit);

    }

}