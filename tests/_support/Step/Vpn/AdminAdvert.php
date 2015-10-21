<?php

namespace Step\Vpn;

use Page\BackoffAdverts;
use \Data\Flat;

class AdminAdvert extends \VpnTester
{
    public function moderateAdvActive()
    {
        $I=$this;
        $I->amOnPage(BackoffAdverts::$advListURL);
        $I->waitForElement(BackoffAdverts::$advListActionLink0);
        $I->click(BackoffAdverts::$advListActionLink0);
        $I->waitForElement(BackoffAdverts::$advEditStatus);
        $I->wait(2);
        $I->click(BackoffAdverts::$advEditStatus);
        $I->fillField('[ng-model="$select.search"]', /*Flat::status1*/'Опубликовано');
        $I->click(BackoffAdverts::$chooseFirstRow);
        $I->click(BackoffAdverts::$advEditSubmit);

    }

}