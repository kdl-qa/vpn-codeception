<?php 
$I = new VpnTester($scenario);
$I->wantTo('Edit Private person - Profile');
include_once('loginPrivatePersonCept.php');
$I->click('html/body/header/div/nav/div/div');
$I->click('Мой профиль');
$I->seeInTitle('Редактирование профиля');
$I->waitForElement(".//*[@id='phone0']");
$I->fillField("//input[@id='fname']",'Jan');
$I->fillField("//input[@id='lname']",'Teriyaki');
$I->fillField(".//*[@id='email']",'jt@flurred.com');
$I->fillField(".//*[@id='phone0']", '+380733101888');
$I->click('html/body/div[2]/div[3]/div[2]/div/form/dl/div[1]/dd/div/a[2]');
$I->fillField(".//*[@id='phone1']", '+380675554412');
$I->attachFile('#image', 'pit.jpg');
$I->click('html/body/div[2]/div[3]/div[2]/div/form/dl/div[2]/dd/div/a[1]');
$I->click("//button[@type='submit']");
$I->seeInField("//input[@id='fname']",'Jan');
$I->seeInField("//input[@id='lname']",'Teriyaki');
$I->seeInField(".//*[@id='email']",'jt@flurred.com');
$I->seeInField(".//*[@id='phone0']", '+380733101888');

?>