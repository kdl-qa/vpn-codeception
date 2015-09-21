<?php 
$I = new VpnTester($scenario);
include 'constant.php';
$I->wantTo('webUS2-a / Регистрация частного лица');
$I->amOnPage(RegistrationUser::$url);
$I->waitForElement(RegistrationUser::$submit);
$I->fillField(RegistrationUser::$fname, $userFName);
$I->fillField(RegistrationUser::$lname, $userLName);
$I->fillField(RegistrationUser::$email, $userEmail);
$I->fillField(RegistrationUser::$pass, $userPass);
$I->fillField(RegistrationUser::$confirmPass, $userConfPass);
$I->fillField(RegistrationUser::$phone0, $userPhone0);
$I->attachFile(RegistrationUser::$image, 'pit.jpg');
$I->wait(2);
$I->click(RegistrationUser::$submit);
$I->wait(2);
$I->seeElement("//img[@alt='$userFName $userLName']");

?>



