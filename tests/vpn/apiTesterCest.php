<?php



class apiTesterCest
{


    public function apiAdminCity (VpnTester $I)
    {

        $I->apiAdminLogin();
        $I->apiAgencyLogin1();
//
////        $I->apiAgencyAddAnnouncementsList();
////        $I->apiAgencyEditAnnouncementList();
////        $I->apiAgencyAnnouncementList();
////        $I->apiGetAgencyAnnouncementsList();
        $I->apiAgencyAddAdvertToAnnouncementsList();
//



//        $I->apiAgencyDeleteAnnouncementList();


//        $I->apiDeleteFlatAdvert();
//        $I->apiDeleteHouseAdvert();
//        $I->apiDeleteParcelAdvert();
//        $I->apiDeleteCommercialAdvert();
    }


}