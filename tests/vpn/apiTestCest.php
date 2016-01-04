<?php
use \VpnTester;

class apiTestCest
{
    protected function uplCertificate(VpnTester $I)
    {
//        $I->uploadCertificates();
    }

    protected function agencyLogin(VpnTester $I)
    {
        $I->apiAgencyLogin();
        $I->apiUserLogin();
    }

//    /**
//     *@before agencyLogin
//     */
    public function apiUsers(VpnTester $I)
    {
        $I->getAppliancesName(0);
        $I->getActualCurrencyName(0);
        $I->getAreaUnitsName(0);
        $I->getBalconiesName(0);
        $I->getCommunicationsName(0);
        $I->getCurrencyName(0);
        $I->getFurnituresName(0);
        $I->getHeatingsName(1);
        $I->getNearObjectsName(0);
        $I->getOperationTypeName(1);
        $I->getRepairsName(1);
        $I->getPeriodName(1);
        $I->getStatusesName(0);
        $I->getUnpublishReasonsName(0);
        $I->getWallMaterialsName(10);
        $I->getWaterHeatingsName(0);
        $I->getWCName(0);




//        $I->getGarageNumbers(1);
        $I->getCategoryName(0);
        $I->getFlatCategoryTypeName(1);
        $I->getHouseCategoryTypeName(0);
        $I->getParcelCategoryTypeName(0);
        $I->getCommercialCategoryTypeName(0);
        $I->getGaragesCategoryTypeName(0);
        $I->getCityName(6);
        $I->getStreetName(328);
        $I->getDistrictName(9);
        $I->getFlatAdditionalsName(0);
        $I->getHouseAdditionalsName(0);
        $I->getParcelAdditionalsName(1);
//        $I->getCommercialAdditionals(0);
//        $I->getCommercialAdditionalsName(0);
//        $I->getGarageAdditionals(1);
//        $I->getGarageAdditionalsName(0);



//        $I->apiAgencySaveFlatSearch();
//        $I->apiAgencySaveFlatSearchPlain();
//        $I->apiAgencyViewSaveSearchList();
//        $I->pauseExecution();
//        $I->apiAgencyViewSaveSearch();
//        $I->pauseExecution();
//        $I->apiAgencyEditSaveSearch();
//        $I->apiAgencyViewSaveSearch();
//        $I->apiAgencyDeleteSaveSearch();
//        $I->apiAgencySaveHouseSearch();
//        $I->apiAgencySaveParcelSearch();
//        $I->apiAgencySaveCommercialSearch();
//        $I->apiGetFlatAdvert1();
//        $I->apiUserVisitAdvert();
//        $I->apiAgencyViewSaveSearch();
    }
}
