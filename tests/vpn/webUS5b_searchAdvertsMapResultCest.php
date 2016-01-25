<?php
use \VpnTester;

class webUS5b_searchAdvertsMapResultCest
{
    protected function agencyLogin(VpnTester $I)
    {
        $I->loginAgency();
    }
    protected function apiLogin(VpnTester $I)
    {
        $I->apiAdminLogin();
        $I->apiAgencyLogin();
    }
    protected function addApiFlatAdvert(VpnTester $I)
    {
        $I->realtyFlatAddForSearch();
        $I->apiAdvertFlatAddForSearch();
        $I->apiAdminEditFlatAdvertSearch();
    }
    protected function addApiHouseAdvert(VpnTester $I)
    {
        $I->realtyHouseAddSearch();
        $I->apiAdvertHouseAddSearch();
        $I->apiAdminEditHouseAdvertSearch();
    }
    protected function addApiParcelAdvert(VpnTester $I)
    {
        $I->realtyParcelAddSearch();
        $I->apiAdvertParcelAddSearch();
        $I->apiAdminEditParcelAdvertSearch();
    }
    protected function addApiCommercialAdvert(VpnTester $I)
    {
        $I->realtyCommercialAddSearch();
        $I->apiAdvertCommercialAddSearch();
        $I->apiAdminEditCommercialAdvertSearch();
    }
    /**
     *@before apiLogin
     *@before addApiFlatAdvert
     *@before addApiHouseAdvert
     *@before addApiParcelAdvert
     *@before addApiCommercialAdvert
     *@before agencyLogin
     */

//    /**
//     *@before agencyLogin
//     */

    public function mapSearchFlatAndCheckProperties(\Step\Vpn\Search $I)

    {
        $I->mapSearchFlat();
        $I->checkFlatObjectPropertiesSearch();
//
        $I->mapSearchFlat1();
        $I->mapSearchFlat2();
        $I->mapSearchFlat3();
        $I->mapSearchFlat4();
        $I->mapSearchFlat5();
        $I->mapSearchFlat6();
        $I->mapSearchFlat7();
        $I->mapSearchFlat8();
        $I->mapSearchFlat9();
        $I->mapSearchFlat10();
        $I->mapSearchFlat11();
        $I->mapSearchFlat12();
        $I->mapSearchFlat13();
        $I->mapSearchFlat14();
        $I->mapSearchFlat15();
        $I->mapSearchFlat16();
        $I->mapSearchFlat17();
        $I->mapSearchFlat18();
        $I->mapSearchFlat19();
        $I->mapSearchFlat20();
        $I->mapSearchFlat21();
        $I->mapSearchFlat22();
        $I->mapSearchFlat23();
        $I->mapSearchFlat24();
        $I->mapSearchFlat25();
        $I->mapSearchFlat26();
        $I->mapSearchFlat27();
        $I->mapSearchFlat28();
        $I->mapSearchFlat29();
//       $I->pauseExecution();


    }



    //--------------------House---------------------//
    /**
     *@before agencyLogin
     */
    public function mapSearchHouseAndCheckProperties(\Step\Vpn\Search $I)
    {
        $I->mapSearchHouse();
        $I->checkHouseObjectPropertiesSearch();

//
        $I->mapSearchHouse1();
        $I->mapSearchHouse2();
        $I->mapSearchHouse3();
        $I->mapSearchHouse4();
        $I->mapSearchHouse5();
        $I->mapSearchHouse6();
        $I->mapSearchHouse7();
        $I->mapSearchHouse8();
        $I->mapSearchHouse9();
        $I->mapSearchHouse10();
        $I->mapSearchHouse11();
        $I->mapSearchHouse12();
        $I->mapSearchHouse13();
        $I->mapSearchHouse14();
        $I->mapSearchHouse15();
        $I->mapSearchHouse16();
        $I->mapSearchHouse17();
        $I->mapSearchHouse18();
        $I->mapSearchHouse19();
        $I->mapSearchHouse20();
        $I->mapSearchHouse21();
        $I->mapSearchHouse22();
        $I->mapSearchHouse23();
        $I->mapSearchHouse24();
        $I->mapSearchHouse25();
        $I->mapSearchHouse26();
        $I->mapSearchHouse27();
        $I->mapSearchHouse28();

//        $I->pauseExecution();


    }
    //----------------Parcel-------------------------//
    /**
     *@before agencyLogin
     */
    public function mapSearchParcelAndCheckProperties(\Step\Vpn\Search $I)
    {
        $I->mapSearchParcel();
        $I->checkParcelObjectPropertiesSearch();

        $I->mapSearchParcel1();
        $I->mapSearchParcel2();
        $I->mapSearchParcel3();
        $I->mapSearchParcel4();
        $I->mapSearchParcel5();
        $I->mapSearchParcel6();
        $I->mapSearchParcel7();
        $I->mapSearchParcel8();
        $I->mapSearchParcel9();
        $I->mapSearchParcel10();
        $I->mapSearchParcel11();
        $I->mapSearchParcel12();
        $I->mapSearchParcel13();

//        $I->pauseExecution();

    }
    /**
     *@before agencyLogin
     */
    public function searchCommercialAndCheckProperties(\Step\Vpn\Search $I)
    {
        $I->mapSearchCommercial();
        $I->checkCommercialObjectPropertiesSearch();

        $I->mapSearchCommercial1();
        $I->mapSearchCommercial2();
        $I->mapSearchCommercial3();
        $I->mapSearchCommercial4();
        $I->mapSearchCommercial5();
        $I->mapSearchCommercial6();
        $I->mapSearchCommercial7();
        $I->mapSearchCommercial8();
        $I->mapSearchCommercial9();
        $I->mapSearchCommercial10();
        $I->mapSearchCommercial11();
        $I->mapSearchCommercial12();
        $I->mapSearchCommercial13();
        $I->mapSearchCommercial14();
        $I->mapSearchCommercial15();
        $I->mapSearchCommercial16();
        $I->mapSearchCommercial17();
        $I->mapSearchCommercial18();
        $I->mapSearchCommercial19();
        $I->mapSearchCommercial20();
        $I->mapSearchCommercial21();
        $I->mapSearchCommercial22();
//        $I->pauseExecution();
    }

    /**
     *@before apiLogin
     */
    public function apiDeleteAdverts(VpnTester $I)
    {
        $I->apiDeleteFlatAdvert();
        $I->apiDeleteHouseAdvert();
        $I->apiDeleteParcelAdvert();
        $I->apiDeleteCommercialAdvert();

    }
}
