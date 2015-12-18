<?php
use \VpnTester;
use Data\User as User;

class apiTesttCest
{
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
     **/
    public function flatSearch(VpnTester $I)
    {
        $I->apiFlatSearch();
    }
    /**
     *@before apiLogin
     *@before addApiHouseAdvert
     */
    public function houseSearch(VpnTester $I)
    {
        $I->apiHouseSearch();
    }
    /**
         *@before apiLogin
         *@before addApiParcelAdvert
         */
    public function parcelSearch(VpnTester $I)
    {
        $I->apiParcelSearch();
    }
    /**
         *@before apiLogin
         *@before addApiCommercialAdvert
         */
    public function commercialSearch(VpnTester $I)
    {
        $I->apiCommercialSearch();
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