<?php
use \VpnTester;

class webUS7_realtyHistoryCest
{
    protected function apiLogin(VpnTester $I)
    {
        $I->apiAgencyLogin();
        $I->apiAdminLogin();

    }
    protected function addFlat (VpnTester $I)
    {
//        $I->getAllLists();
        $I->realtyFlatAddForSearch();
        $I->wait(1);
        $I->apiAdvertFlatAddForSearch();
        $I->apiAdminEditFlatAdvertChangeStatus($I);

    }

    protected function addHouse (VpnTester $I)
    {
        $I->realtyHouseAddSearch();
        $I->wait(1);
        $I->apiAdvertHouseAddSearch();
        $I->apiAdminEditHouseAdvertChangeStatus($I);

    }
    protected function addParcel (VpnTester $I)
    {
        $I->realtyParcelAddSearch();
        $I->wait(1);
        $I->apiAdvertParcelAddSearch();
        $I->apiAdminEditParcelAdvertChangeStatus($I);
    }

    protected function addCommercial (VpnTester $I)
    {
        $I->realtyCommercialAddSearch();
        $I->wait(1);
        $I->apiAdvertCommercialAddSearch();
        $I->apiAdminEditCommercialAdvertChangeStatus($I);
    }

    protected function addGarage (VpnTester $I)
    {
        $I->realtyGarageAddForSearch();
        $I->wait(1);
        $I->apiAdvertGarageAddForSearch();
        $I->apiAdminEditGarageAdvertChangeStatus($I);
    }

    protected function loginAgency(VpnTester $I)
    {
        $I->loginAgency1();
    }

    /**
     *@before apiLogin
     * @before addFlat
     *@before loginAgency
     */

    public function flatHistory (\Step\Vpn\Advert $I)
    {
        $I->flatHistoryUrl();
        $I->realtyHistory();
    }
    /**
     *@before apiLogin
     * @before addHouse
     *@before loginAgency
     */

    public function houseHistory (\Step\Vpn\Advert $I)
    {
        $I->houseHistoryUrl();
        $I->realtyHistory();
    }
    /**
     *@before apiLogin
     * @before addParcel
     *@before loginAgency
     */
    public function parcelHistory (\Step\Vpn\Advert $I)
    {
        $I->parcelHistoryUrl();
        $I->realtyHistory();
    }

    /**
     *@before apiLogin
     * @before addCommercial
     *@before loginAgency
     */
    public function commercialHistory (\Step\Vpn\Advert $I)
    {
        $I->commercialHistoryUrl();
        $I->realtyHistory();
    }

    /**
     *@before apiLogin
     * @before addGarage
     *@before loginAgency
     */
    public function garageHistory (\Step\Vpn\Advert $I)
    {
        $I->garageHistoryUrl();
        $I->realtyHistory();
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
        $I->apiDeleteGarageAdvert();


    }


}
