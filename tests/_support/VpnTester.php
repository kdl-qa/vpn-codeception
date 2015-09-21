<?php
use \Page\Login as Login;

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

    function login()
    {
//        if ($this->getScenario()->current('env') != 'firefox') {
            if ($this->loadSessionSnapshot('login')) return;
//        }
        $this->amOnPage(Login::$URL);
        $this->waitForElement(Login::$email);
        $this->fillField(Login::$email, $this->agencyEmail);
        $this->fillField(Login::$pass, $this->agencyPass);
        $this->click(Login::$submit);
        $this->wait(3);
        $this->seeElement("//img[@alt='$this->agencyChiefFName $this->agencyChiefLName']");
        $this->saveSessionSnapshot('login');
    }

    function seeInModal($title)
    {
        $this->waitForElement('.modal-content');
        $this->seeElement('.modal-content');
        $this->see($title);
    }

    function acceptModal()
    {
        $this->click(['css' => '.modal-content button.blue']);
    }

    function rejectModal()
    {
        $this->click(['css' => '.modal-content button.red']);
    }
}
