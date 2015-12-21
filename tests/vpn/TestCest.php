<?php
use \VpnTester;
use Data\User as User;

class TestCest
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
    public function searchFlat1(\Step\Vpn\Search $I, VpnTester $P)
    {
        $I->searchFlat1();
        $I->searchFlat2();
        $I->searchFlat3();
        $I->searchFlat4();
        $I->searchFlat5();
        $I->searchFlat6();
        $I->searchFlat7();
        $I->searchFlat8();
        $I->searchFlat9();
        $I->searchFlat10();
        $I->searchFlat11();
        $I->searchFlat12();
        $I->searchFlat13();
        $I->searchFlat14();
        $I->searchFlat15();
        $I->searchFlat16();
        $I->searchFlat17();
        $I->searchFlat18();
        $I->searchFlat19();
        $I->searchFlat20();
        $I->searchFlat21();
        $I->searchFlat22();
        $I->searchFlat23();
        $I->searchFlat24();
        $I->searchFlat25();
        $I->searchFlat26();
        $I->searchFlat27();
        $I->searchFlat28();
        $I->searchFlat29();

//        $I->pauseExecution();
    }

    //--------------------House---------------------//

    public function searchHouse(\Step\Vpn\Search $H)
    {
        $H->searchHouse();
        $H->checkHouseObjectPropertiesSearch();

        $H->searchHouse1();
        $H->searchHouse2();
        $H->searchHouse3();
        $H->searchHouse4();
        $H->searchHouse5();
        $H->searchHouse6();
        $H->searchHouse7();
        $H->searchHouse8();
        $H->searchHouse9();
        $H->searchHouse10();
        $H->searchHouse12();
        $H->searchHouse13();
        $H->searchHouse14();
        $H->searchHouse15();
        $H->searchHouse16();
        $H->searchHouse17();
        $H->searchHouse18();
        $H->searchHouse19();
        $H->searchHouse20();
        $H->searchHouse21();
        $H->searchHouse22();
        $H->searchHouse23();
        $H->searchHouse24();
        $H->searchHouse25();
        $H->searchHouse26();
        $H->searchHouse27();
        $H->searchHouse28();
    }
    //----------------Parcel-------------------------//
//    public function searchParcel(\Step\Vpn\Search $P)
//    {
//        $P->searchParcel();
//        $P->checkParcelObjectPropertiesSearch();
//    }

}