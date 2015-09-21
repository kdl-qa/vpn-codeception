<?php 
$I = new VpnTester($scenario);
$I->wantTo('User Group create');
include_once('loginPrivatePersonCept.php');
$I->click('html/body/header/div/nav/div/div');
$I->click('Мои группы объявлений');
$I->amOnPage('/user/lists-of-adverts');
$I->waitForElementVisible("//a[@class='button yellow ng-scope']");
$I->seeInTitle('Мои группы объявлений');
//$I->see('Не добавлена ни одна группа'); /*this step actual only in case  when user do not have any added group of announcement*/
$I->click("html/body/div[2]/div[2]/div/div/a");
$I->waitForElementVisible("//input[@id='groupName']");
$I->seeInTitle('Создание группы объявлений');
$I->fillField("//input[@id='groupName']", 'Functional group of test adverts');
$I->fillField("//dl/dd[3]/textarea[@id='description']","Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s");
$I->fillField("//dl/dd[4]/input[@id='seoTitle']", 'SEO Title Lorem ipsum text');
$I->fillField("//dl/dd[6]/textarea[@id='seoDescription']", 'Lorem Ipsum has been the industry standard dummy text ever since the 1500s');
$I->fillField("//dl/dd[7]/input[@id='seoKeywords']", "Lorem ipsum, keyword 1, KeyWord 2, Keyword3");
$I->click("//button[@class='blue']");
$I->waitForElement('html/body/div[2]/div[3]/div[2]/div/ul/li[1]/div[1]');
?>