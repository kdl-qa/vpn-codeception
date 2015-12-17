<?php
use \VpnTester;
use Data\User as User;

class apiTesttCest
{

    protected function agencyLogin(VpnTester $I)
    {
        $I->loginAgency();
    }
    /**
     *@before agencyLogin
     */

   public function searchFlatAndCheckProperties(\Step\Vpn\Search $I)
   {

       $I->searchFlat();

       $I->checkFlatObjectPropertiesSearch();
   }
    /**
     *@before agencyLogin
     */
    public function searchFlat1(\Step\Vpn\Search $I)
    {
        $I->searchFlat1();
//        $I->searchFlat2();
//        $I->searchFlat3();
//        $I->searchFlat4();
//        $I->searchFlat5();
//        $I->searchFlat6();
//        $I->searchFlat7();
//        $I->searchFlat8();
//        $I->searchFlat9();
//        $I->searchFlat10();
//        $I->searchFlat11();
//        $I->searchFlat12();
//        $I->searchFlat13();
//        $I->searchFlat14();
//        $I->searchFlat15();
//        $I->searchFlat16();
//        $I->searchFlat17();
//        $I->searchFlat18();
//        $I->searchFlat19();
//        $I->searchFlat20();
//        $I->searchFlat21();
//        $I->searchFlat22();
//        $I->searchFlat23();
//        $I->searchFlat24();
//        $I->searchFlat25();
//        $I->searchFlat26();
        $I->searchFlat27();
//        $I->pauseExecution();
        $I->searchFlat28();
//        $I->pauseExecution();
        $I->searchFlat29();
//        $I->pauseExecution();
        $I->searchFlat30();
        $I->pauseExecution();
    }
    /**
     *@before agencyLogin
     */

}