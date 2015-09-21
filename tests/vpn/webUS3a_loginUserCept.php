<?php 
$I = new VpnTester($scenario);
include 'constant.php';
$I->wantTo('US3-a. Частное лицо. Аутентификация в системе');
$I->amOnPage('/login');
$I->waitForElement(Login::$email);
$I->fillField(Login::$email, $userEmail);
$I->fillField(Login::$pass, $userPass);
$I->click(Login::$submit);
$I->wait(3);
$I->seeElement("//img[@alt='$userFName $userLName']");
$I->dontSee('Войти');
//$userToken = $I->grabCookie('token');

/*
$I->waitForElement(".//*[@id='email']");
$I->fillField(".//*[@id='email']",'jt@flurred.com');
$I->fillField(".//*[@id='password']",'qwaszx');
$I->click("//button[@type='submit']");
$I->waitForElement('html/body/header/div/nav/div');
$I->click('html/body/header/div/nav/div/div');
//$I->waitForElement('Мой профиль');
$I->see('Мой профиль');
$I->see('Мои объявления');
$I->see('Мои группы объявлений');
$I->see('Выход');
$I->click('html/body/header/div/nav/ul/li[5]/a');
$I->amOnUrl('http://vpn.ua/new-advert/step1');
$I->waitForElementVisible("//h1[@class='container ng-binding']");
$I->seeInTitle('Добавление объявления');
*/
?> 