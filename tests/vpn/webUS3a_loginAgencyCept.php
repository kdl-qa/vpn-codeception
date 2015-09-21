<?php 
$I = new VpnTester($scenario);
$I->wantTo('US3a. Агентство. Аутентификация в сисетме');
$I->login();
$I->dontSee('Войти');
//$agencyToken = $I->grabCookie('token');

?>
