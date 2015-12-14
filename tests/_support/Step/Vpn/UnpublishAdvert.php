<?php
namespace Step\Vpn;

use \Data\Flat;
use \Page\AdvertsList;
use \Data\Lists;
use \Step\Vpn\UserAdvertsList;

class UnpublishAdvert extends \VpnTester
{
    public function openFlatUnpublishPage()
    {
        $I=$this;
        $advFlatId = file_get_contents(codecept_data_dir('advertFlatId.json'));
        $I->amOnPage(AdvertsList::$URL .'/' .$advFlatId .'/request-to-unpublish');
        $I->waitForElement(AdvertsList::$descriptionReason);
    }

    public function addDealFinishedReason()
    {
        $I=$this;
        $I->click(AdvertsList::$chooseReason);
        $I->click(AdvertsList::$upublishReason0);
        $I->fillField(AdvertsList::$finalPrice, Flat::priceFlatSell);
        $I->click(AdvertsList::$chooseCurrency);
        $I->click(AdvertsList::$currencyUS);
        $I->fillField(AdvertsList::$descriptionReason, Flat::descriptionDealFinished);
        $I->click(AdvertsList::$unpublishSubmit);
        $I->wait(1);
    }

    public function addDealFinishedReasonNeru()
    {
        $I=$this;
        $I->click(AdvertsList::$chooseReason);
        $I->click(AdvertsList::$upublishReason1);
        $I->fillField(AdvertsList::$finalPrice, Flat::priceFlatSell);
        $I->click(AdvertsList::$chooseCurrency);
        $I->click(AdvertsList::$currencyUS);
        $I->fillField(AdvertsList::$descriptionReason, Flat::descriptionDealFinished);
        $I->click(AdvertsList::$unpublishSubmit);
        $I->wait(1);
    }

    public function addOtherReason()
    {
        $I=$this;
        $I->click(AdvertsList::$chooseReason);
        $I->click(AdvertsList::$upublishReason2);
        $I->fillField(AdvertsList::$descriptionReason, Flat::descriptionOtherReason);
        $I->click(AdvertsList::$unpublishSubmit);
        $I->wait(1);
    }

    public function checkDealFinishedRequest()
    {
        $I = $this;
        $advFlatId = file_get_contents(codecept_data_dir('advertFlatId.json'));
        $I->amOnPage(AdvertsList::$URL .'/' .$advFlatId .'/edit');
        $I->waitForElement(AdvertsList::$editAdvObjInfoTab);
        $I->see(Lists::unpubReason0, AdvertsList::$advInfoTable);
        $I->see(Flat::descriptionDealFinished,AdvertsList::$advInfoTable);
        $I->see(Flat::priceFlatSell,AdvertsList::$advInfoTable);
        $I->see(Lists::status3,AdvertsList::$advInfoTable);
    }
    public function checkDealFinishedRequestNeru()
    {
        $I = $this;
        $advFlatId = file_get_contents(codecept_data_dir('advertFlatId.json'));
        $I->amOnPage(AdvertsList::$URL .'/' .$advFlatId .'/edit');
        $I->waitForElement(AdvertsList::$editAdvObjInfoTab);
        $I->see(Lists::unpubReason1, AdvertsList::$advInfoTable);
        $I->see(Flat::descriptionDealFinished,AdvertsList::$advInfoTable);
        $I->see(Flat::priceFlatSell,AdvertsList::$advInfoTable);
        $I->see(Lists::status3,AdvertsList::$advInfoTable);
    }

    public function checkOtherReasonRequest()
    {
        $I = $this;
        $advFlatId = file_get_contents(codecept_data_dir('advertFlatId.json'));
        $I->amOnPage(AdvertsList::$URL .'/' .$advFlatId .'/edit');
        $I->waitForElement(AdvertsList::$editAdvObjInfoTab);
        $I->see(Lists::unpubReason2, AdvertsList::$advInfoTable);
        $I->see(Flat::descriptionOtherReason,AdvertsList::$advInfoTable);
        $I->see(Lists::status3,AdvertsList::$advInfoTable);
    }
}