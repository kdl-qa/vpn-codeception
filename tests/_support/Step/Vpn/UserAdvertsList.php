<?php
namespace Step\Vpn;
use \Data\Flat;
use \Page\AdvertsList;

class UserAdvertsList extends \VpnTester
{
    public function openUserAdvertsList()
    {
        $I=$this;
        $I->amOnPage('/user/adverts');
        $I->wait(1);
        $I->see(Flat::category, 'html/body/div[1]/div[3]/div[2]/div/ul/li[1]/div[2]'); //Flat::categoryType1,Flat::city, Flat::street, Flat::houseNumber, Flat::flatNumber]);
    }

    public function newFlatAdvertContains()
    {
        $I=$this;
        $I->amOnPage(AdvertsList::$URL);
        $I->waitForElement(AdvertsList::$firstListAdvert);
        $I->see(Flat::category, AdvertsList::$firstListAdvert);
        $I->see(Flat::categoryType1, AdvertsList::$firstListAdvert);
        $I->see(Flat::city, AdvertsList::$firstListAdvert);
        $I->see(Flat::street, AdvertsList::$firstListAdvert);
        $I->see(Flat::houseNumber, AdvertsList::$firstListAdvert);
        $I->see(Flat::$currentFlatNumber, AdvertsList::$firstListAdvert);

    }

}