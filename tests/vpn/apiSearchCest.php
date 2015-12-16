<?php
use \VpnTester;
use Data\User as User;

class apiTesttCest
{
    protected function apiLogin(VpnTester $I)
    {
        $I->apiAdminLogin();
    }

    /**
     * @before apiLogin
     */

    public function apiAdminCity (VpnTester $city, VpnTester $district, VpnTester $street, VpnTester $categoryType )
    {
        $city->apiAdminAddCity();
        $city->apiAdminEditCity();

        $district->apiAdminAddDistrict();
        $district->apiAdminEditDistrict();
        $district->apiAdminDeleteDistrict();

        $street->apiAdminAddStreet();
        $street->apiAdminEditStreet();
        $street->apiAdminDeleteStreet();

        $city->apiAdminDeleteCity();

        $categoryType->apiAdminAddCategoryType(0);
        $categoryType->apiAdminEditCategoryType();
        $categoryType->apiAdminChangePositionCategoryType();
        $categoryType->apiAdminDeleteCategoryType();
    }


}