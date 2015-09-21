<?php
// @skip
use \Page\AddAdvert;
use \Data\Flat as FlatObject;
use \Step\Vpn\Advert as AdvertTester;

$I = new AdvertTester($scenario);
$I->wantTo('webUS4. Добавление объявления. Продажа квартиры.');
$I->login();
$I->amOnPage('/new-advert/step1');
$I->waitForElement(AddAdvert::$yandexMap);

?>