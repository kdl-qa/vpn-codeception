<?php
use \Page\Login as Login;
use \Page\BackoffAdverts;
use \Data\User;


/**
 * Inherited Methods
 * @method void wantToTest($text)
 * @method void wantTo($text)
 * @method void execute($callable)
 * @method void expectTo($prediction)
 * @method void expect($prediction)
 * @method void amGoingTo($argumentation)
 * @method void am($role)
 * @method void lookForwardTo($achieveValue)
 * @method void comment($description)
 * @method \Codeception\Lib\Friend haveFriend($name, $actorClass = null)
 *
 * @SuppressWarnings(PHPMD)
*/
class VpnTester extends \Codeception\Actor
{
    use _generated\VpnTesterActions;

    protected $agencyName = 'uhome';
    protected $agencyEmail = 'support@uhome.ck.ua';
    protected $agencyChiefFName = 'Андрей';
    protected $agencyChiefLName = 'Сорокин';
    protected $agencyPass = 'L7KZXX';



    function loginAgency()
    {
//        if ($this->getScenario()->current('env') != 'firefox') {
            if ($this->loadSessionSnapshot('loginAgency')) return;
//        }
        $this->amOnPage(Login::$URL);
        $this->waitForElement(Login::$email);
        $this->fillField(Login::$email, $this->agencyEmail);
        $this->fillField(Login::$pass, $this->agencyPass);
        $this->click(Login::$submit);
        $this->wait(3);
        $this->seeElement("//img[@alt='$this->agencyChiefFName $this->agencyChiefLName']");
        $this->saveSessionSnapshot('loginAgency');
    }

    function seeInModal($title)
    {
        $this->waitForElement('.modal-content');
        $this->seeElement('.modal-content');
        $this->see($title);
    }

    function acceptModal()
    {
//        $this->waitForElement(['css' => '.modal-content button.blue']);
        $this->click(['css' => '.modal-content button.blue']);
        $this->wait(1);
    }

    function rejectModal()
    {
        $this->waitForElement(['css' => '.modal-content button.red']);
        $this->click(['css' => '.modal-content button.red']);
    }

    function loginAdmin()
    {
//        if ($this->getScenario()->current('env') != 'firefox') {
        if ($this->loadSessionSnapshot('loginAdmin')) return;
//        }
        $this->amOnPage(BackoffAdverts::$authURL);
        $this->waitForElement(BackoffAdverts::$authEmail);
        $this->fillField(BackoffAdverts::$authEmail, User::$adminEmail);
        $this->fillField(BackoffAdverts::$authPass, User::$adminPass);
        $this->click(BackoffAdverts::$loginButton);
        $this->wait(3);
        $this->see('Выход');
        $this->saveSessionSnapshot('loginAdmin');
    }
}
