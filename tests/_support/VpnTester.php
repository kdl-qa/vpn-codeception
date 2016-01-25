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
    protected $agencyEmail3 = "rblkkk@ukr.net";
    protected $agencyPass3 = "123456";



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

    function loginAgency1()
    {
//        if ($this->getScenario()->current('env') != 'firefox') {
        if ($this->loadSessionSnapshot('loginAgency')) return;
//        }
        $this->amOnPage(Login::$URL);
        $this->waitForElement(Login::$email);
        $this->fillField(Login::$email, $this->agencyEmail3);
        $this->fillField(Login::$pass, $this->agencyPass3);
        $this->click(Login::$submit);
        $this->wait(3);
//        $this->seeElement("//img[@alt='$this->agencyChiefFName $this->agencyChiefLName']");
        $this->saveSessionSnapshot('loginAgency');
    }


    function loginAgencyTmp()
    {
//        if ($this->getScenario()->current('env') != 'firefox') {
        if ($this->loadSessionSnapshot('loginAgency')) return;
//        }
        $this->amOnPage(Login::$URL);
        $this->waitForElement(Login::$email);
        $this->fillField(Login::$email, User::getCurrentAgencyEmail());
        $this->fillField(Login::$pass, User::$agencyPass2);
        $this->click(Login::$submit);
        $this->wait(3);
        //$this->seeElement("//img[@alt='$this->agencyChiefFName $this->agencyChiefLName']");
        $this->saveSessionSnapshot('loginAgency');
    }

    function loginAgent()
    {
//          if ($this->getScenario()->current('env') != 'firefox') {
        if ($this->loadSessionSnapshot('agent_login')) return;
//        }
        $this->amOnPage(Login::$URL);
        $this->waitForElement(Login::$email);
        $this->fillField(Login::$email, User::getCurrentAgentEmail());
        $this->fillField(Login::$pass, User::$agentPass);
        $this->click(Login::$submitLoginBtn);
        $this->wait(3);
        //$this->seeElement("//img[@alt='$this->agencyChiefFName $this->agencyChiefLName']");
        $this->saveSessionSnapshot('agent_login');
    }
    function loginAgent1()
    {
//          if ($this->getScenario()->current('env') != 'firefox') {
        if ($this->loadSessionSnapshot('agent_login')) return;
//        }
        $this->amOnPage(Login::$URL);
        $this->waitForElement(Login::$email);
        $this->fillField(Login::$email, User::$agentEmail);
        $this->fillField(Login::$pass, User::$agentPass);
        $this->click(Login::$submitLoginBtn);
        $this->wait(3);
        //$this->seeElement("//img[@alt='$this->agencyChiefFName $this->agencyChiefLName']");
        $this->saveSessionSnapshot('agent_login');
    }

    function userLogin()
    {
//        if ($this->getScenario()->current('env') != 'firefox') {
        if ($this->loadSessionSnapshot('user_login')) return;
//        }
        $this->amOnPage(Login::$URL);
        $this->waitForElement(Login::$email);
        $this->fillField(Login::$email, User::$userEmail);
        $this->fillField(Login::$pass, User::$userPass);
        $this->click(Login::$submitLoginBtn);
        $this->wait(3);
        //$this->seeElement("//img[@alt='$this->agencyChiefFName $this->agencyChiefLName']");
        $this->saveSessionSnapshot('user_login');
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
        $this->wait(1);
        $this->click(['css' => '.modal-content button.blue']);
        $this->wait(1);
    }

    function acceptRegistrationModal(){
        $this->click(['css' => 'button.blue']);
    }

    function rejectModal()
    {
        $this->waitForElement(['css' => '.modal-content button.red']);
        $this->click(['css' => '.modal-content button.red']);
    }



    function acceptDeleteUserModal(){
        $this->click(['css' => 'button.blue']);
    }


    function submitBtnBlue(){
        $this->click(['css' => 'button.blue']);
    }

    function acceptEditProfileModal(){
        $this->click(['css' => 'button.blue']);
    }


    function logout(){
        $this->click(Login::$menuBtn);
        $this->click(Login::$logoutBtn);

    }




}
