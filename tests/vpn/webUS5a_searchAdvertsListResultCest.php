<?php
use \VpnTester;

class webUS5a_searchAdvertsListResultCest
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
    protected function addApiGarageAdvert(VpnTester $I)
    {
        $I->realtyGarageAddForSearch();
        $I->apiAdvertGarageAddForSearch();
        $I->apiAdminEditGarageAdvertSearch();
    }

    /**
     *@before apiLogin
     *@before addApiFlatAdvert
     *@before addApiHouseAdvert
     *@before addApiParcelAdvert
     *@before addApiCommercialAdvert
     * @before addApiGarageAdvert
     *@before agencyLogin
     */

    public function searchFlatAndCheckProperties(\Step\Vpn\Search $I)
    {

        $I->searchFlat();
        $I->checkFlatObjectPropertiesSearch();

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
    }

    //--------------------House---------------------//
    public function searchHouseAndCheckProperties(\Step\Vpn\Search $H)
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
    public function searchParcelAndCheckProperties(\Step\Vpn\Search $P, VpnTester $I)
    {
        $P->searchParcel();
        $P->checkParcelObjectPropertiesSearch();

        $P->searchParcel1();
        $P->searchParcel2();
        $P->searchParcel3();
        $P->searchParcel4();
        $P->searchParcel5();
        $P->searchParcel6();
        $P->searchParcel7();
        $P->searchParcel8();
        $P->searchParcel9();
        $P->searchParcel10();
        $P->searchParcel11();
        $P->searchParcel12();
        $P->searchParcel13();

//        $I->pauseExecution();

    }

    //----------------------Commercial--------------//
    public function searchCommercialAndCheckProperties(\Step\Vpn\Search $C, VpnTester $I)
    {
        $C->searchCommercial();
        $C->checkCommercialObjectPropertiesSearch();

        $C->searchCommercial1();
        $C->searchCommercial2();
        $C->searchCommercial3();
        $C->searchCommercial4();
        $C->searchCommercial5();
        $C->searchCommercial6();
        $C->searchCommercial7();
        $C->searchCommercial8();
        $C->searchCommercial9();
        $C->searchCommercial10();
        $C->searchCommercial11();
        $C->searchCommercial12();
        $C->searchCommercial13();
        $C->searchCommercial14();
        $C->searchCommercial15();
        $C->searchCommercial16();
        $C->searchCommercial17();
        $C->searchCommercial18();
        $C->searchCommercial19();
        $C->searchCommercial20();
        $C->searchCommercial21();
        $C->searchCommercial22();
//        $I->pauseExecution();


    }
    /**
    *@before agencyLogin
    */
    public function searchGaragesAndCheckProperties(\Step\Vpn\Search $I)
    {

        $I->searchGarage();
        $I->checkGarageObjectPropertiesSearch();

        $I->searchGarage1();
        $I->searchGarage2();
        $I->searchGarage3();
        $I->searchGarage4();
        $I->searchGarage5();
        $I->searchGarage6();
        $I->searchGarage7();
        $I->searchGarage8();
        $I->searchGarage9();
        $I->searchGarage10();
        $I->searchGarage11();
        $I->searchGarage12();
        $I->searchGarage13();
        $I->searchGarage14();
        $I->searchGarage15();
        $I->searchGarage16();
        $I->searchGarage17();
        $I->searchGarage18();
        $I->searchGarage19();
        $I->searchGarage20();
        $I->searchGarage21();
        $I->searchGarage22();
        $I->searchGarage23();
//        $I->pauseExecution();
    }
//
//    //-------------------------Reset filter----------------//
//    public function resetFilter(\Step\Vpn\Search $I)
//    {
//        $I->checkResetFilter();
//    }


    /**
     *@before apiLogin
     */
    public function apiDeleteAdverts(VpnTester $I)
    {
        $I->apiDeleteFlatAdvert();
        $I->apiDeleteHouseAdvert();
        $I->apiDeleteParcelAdvert();
        $I->apiDeleteCommercialAdvert();
        $I->apiDeleteGarageAdvert();

    }
}
