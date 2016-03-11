<?php
namespace Step\Vpn;


use Data\Commercial;
use Data\Flat;
use Data\Garage;
use Data\House;
use Data\Parcel;
use Data\User;
use Page\AdvPage;
use Page\AnnouncementListPage;
use Page\SearchPage;
use \Facebook\WebDriver\WebDriverKeys;

class AnnouncementList extends \VpnTester
{
    public function createAnnouncementList()
    {
        $I = $this;
        $I->amOnPage(AnnouncementListPage::$groupListUrl);
        $I->waitForElement(AnnouncementListPage::$createGroupButton);
        $I->click(AnnouncementListPage::$createGroupButton);
        $I->waitForElement(AnnouncementListPage::$submitButton);
        $I->fillField(AnnouncementListPage::$groupNameField, User::$groupName);
        $I->click(AnnouncementListPage::$clientNameField);
        $I->fillField(AnnouncementListPage::$clientNameType, User::$userEmail);
        $I->click(AnnouncementListPage::$clientName0);
        $I->click(AnnouncementListPage::$submitButton);
        $I->waitForElement(AnnouncementListPage::$advGroupList);
    }

    public function addAdvertToGroupFromAdvPage()
    {
        $I = $this;
        $I->click(AdvPage::$advInfoAddGroup);
        $I->waitForElement(AnnouncementListPage::$selectGroupField);
        $I->click(AnnouncementListPage::$selectGroupField);
        $I->fillField(AnnouncementListPage::$selectGroupType, User::$groupName);
        $I->click(AnnouncementListPage::$selectGroup0);
        $I->click(AnnouncementListPage::$submitButton);
    }
    public function addAdvertToGroupFromListResultSearch()
    {
        $I = $this;
        $I->click(SearchPage::$addToGroup);
        $I->waitForElement(AnnouncementListPage::$selectGroupField);
        $I->click(AnnouncementListPage::$selectGroupField);
        $I->fillField(AnnouncementListPage::$selectGroupType, User::$groupName);
        $I->click(AnnouncementListPage::$selectGroup0);
        $I->click(AnnouncementListPage::$submitButton);
    }

    public function sendGroupToUser()
    {
        $I = $this;
        $I->amOnPage(AnnouncementListPage::$groupListUrl);
        $I->wait(2);
        $I->click(AnnouncementListPage::$showMore);
//        $I->see(User::$allAdvertsText.'5', AnnouncementListPage::$groupInfLine);
        $I->see(User::$interestingText.'0', AnnouncementListPage::$groupInfLine);
        $I->see(User::$notInterestingText.'0', AnnouncementListPage::$groupInfLine);
        $I->click(AnnouncementListPage::$sendUrlLink);
        $I->waitForElement(AnnouncementListPage::$modalPopup);
        $I->seeInField(AnnouncementListPage::$emailField, User::$userEmail);
        $I->fillField(AnnouncementListPage::$themeField, 'TEST');
        $I->click(AnnouncementListPage::$submitButton);


    }
    public function editGroupSaveInterest()
    {
        $I = $this;
        $I->amOnPage(AnnouncementListPage::$groupListUrl);
        $I->wait(2);
        $I->click(AnnouncementListPage::$showMore);
        $I->see(User::$interestingText.'1', AnnouncementListPage::$groupInfLine);
        $I->see(User::$notInterestingText.'1', AnnouncementListPage::$groupInfLine);
        $I->click(AnnouncementListPage::$editGroupLink);
        $I->click(AnnouncementListPage::$generalInfo);
        $I->waitForElement(AnnouncementListPage::$groupNameField);
        $I->doubleClick(AnnouncementListPage::$groupNameField);
        $I->pressKey(AnnouncementListPage::$groupNameField, WebDriverKeys::DELETE);
        $I->wait(1);
        $I->fillField(AnnouncementListPage::$groupNameField, User::$editGroupName);
        $I->click(AnnouncementListPage::$clientNameField);
        $I->fillField(AnnouncementListPage::$clientNameType, 'asd');
        $I->click(AnnouncementListPage::$clientName0);
//        $I->pauseExecution();
        $I->click(AnnouncementListPage::$submitButton);
        $I->waitForElement(AnnouncementListPage::$modalPopup);
        $I->click(AnnouncementListPage::$goodButton);
        $I->wait(3);
        $I->see(User::$editGroupName,AnnouncementListPage::$groupTitle);
        $I->click(AnnouncementListPage::$showMore);
        $I->see(User::$interestingText.'1', AnnouncementListPage::$groupInfLine);
        $I->see(User::$notInterestingText.'1', AnnouncementListPage::$groupInfLine);




    }
    public function editGroupResetInterest()
    {
        $I = $this;
        $I->amOnPage(AnnouncementListPage::$groupListUrl);
        $I->wait(2);
        $I->click(AnnouncementListPage::$showMore);
        $I->see(User::$interestingText.'1', AnnouncementListPage::$groupInfLine);
        $I->see(User::$notInterestingText.'1', AnnouncementListPage::$groupInfLine);
        $I->click(AnnouncementListPage::$editGroupLink);
        $I->click(AnnouncementListPage::$generalInfo);
        $I->waitForElement(AnnouncementListPage::$groupNameField);
        $I->doubleClick(AnnouncementListPage::$groupNameField);
        $I->pressKey(AnnouncementListPage::$groupNameField, WebDriverKeys::DELETE);
        $I->wait(2);
        $I->fillField(AnnouncementListPage::$groupNameField, User::$editGroupName);
        $I->click(AnnouncementListPage::$clientNameField);
        $I->fillField(AnnouncementListPage::$clientNameType, 'asd');
        $I->click(AnnouncementListPage::$clientName0);
        $I->click(AnnouncementListPage::$clearInter);
//        $I->pauseExecution();
        $I->click(AnnouncementListPage::$submitButton);
        $I->waitForElement(AnnouncementListPage::$modalPopup);
        $I->click(AnnouncementListPage::$goodButton);
        $I->wait(3);
        $I->see(User::$editGroupName,AnnouncementListPage::$groupTitle);
        $I->click(AnnouncementListPage::$showMore);
        $a = file_get_contents(codecept_data_dir('advCount1.txt'));
        $b = file_get_contents(codecept_data_dir('advCount2.txt'));
        $count = array ($a,$b);
        $c = array_sum($count);
        $I->see(User::$allAdvertsText.$c ,AnnouncementListPage::$groupInfLine);
        $I->see(User::$interestingText.'0', AnnouncementListPage::$groupInfLine);
        $I->see(User::$notInterestingText.'0', AnnouncementListPage::$groupInfLine);




    }

    public function deleteGroup()
    {
        $I = $this;
        $I->amOnPage(AnnouncementListPage::$groupListUrl);
        $I->wait(2);
        $I->click(AnnouncementListPage::$showMore);
        $I->click(AnnouncementListPage::$deleteGroupLink);
        $I->waitForElement(AnnouncementListPage::$modalPopup);
        $I->click(AnnouncementListPage::$yesButton);
        $I->wait(2);
        $I->dontSeeElement(AnnouncementListPage::$showMore);
        $I->seeElement(AnnouncementListPage::$noGroupDisplayed);
    }
    public function deleteAdvert()
    {
        $I = $this;
        $I->amOnPage(AnnouncementListPage::$groupListUrl);
        $I->wait(2);
        $I->click(AnnouncementListPage::$showMore);
        $I->click(AnnouncementListPage::$editGroupLink);
        $I->wait(2);
        $I->click(AnnouncementListPage::$deleteAdv1);
        $I->waitForElement(AnnouncementListPage::$modalPopup);
        $I->click(AnnouncementListPage::$goodButton);
        $I->wait(1);
        $I->click(AnnouncementListPage::$deleteAdv1);
        $I->waitForElement(AnnouncementListPage::$modalPopup);
        $I->click(AnnouncementListPage::$goodButton);
        $I->wait(1);
        $I->click(AnnouncementListPage::$deleteAdv1);
        $I->waitForElement(AnnouncementListPage::$modalPopup);
        $I->click(AnnouncementListPage::$goodButton);
        $I->wait(1);
        $I->click(AnnouncementListPage::$deleteAdv1);
        $I->waitForElement(AnnouncementListPage::$modalPopup);
        $I->click(AnnouncementListPage::$goodButton);
        $I->wait(1);
        $I->click(AnnouncementListPage::$deleteAdv1);
        $I->waitForElement(AnnouncementListPage::$modalPopup);
        $I->click(AnnouncementListPage::$goodButton);
        $I->wait(1);
//        $I->dontSeeElement(AnnouncementListPage::$deleteAdv1);
        $I->amOnPage(AnnouncementListPage::$groupListUrl);
        $I->wait(2);
        $I->click(AnnouncementListPage::$showMore);


    }
    public function checkAgencyAdvCount()
    {
        $I = $this;
        $I->amOnPage(AnnouncementListPage::$groupListUrl);
        $I->wait(2);
        $I->click(AnnouncementListPage::$showMore);

        $I->see(User::$allAdvertsText.'0',AnnouncementListPage::$groupInfLine);
    }
    public function checkAgentAdvCount()
    {
        $I = $this;
        $I->amOnPage(AnnouncementListPage::$groupListUrl);
        $I->wait(2);
        $I->click(AnnouncementListPage::$showMore);
        $a = file_get_contents(codecept_data_dir('advCount1.txt'));
        $b = file_get_contents(codecept_data_dir('advCount2.txt'));
        $count = array ($a,$b);
        $c = array_sum($count) - 5;
        $I->see(User::$allAdvertsText.$c,AnnouncementListPage::$groupInfLine);
    }

    public function viewAgencyGroupAndCheckProperties()
    {
        $I = $this;
        $I->amOnPage(AnnouncementListPage::$userGroupListUrl);
        $I->wait(2);
        $I->click(AnnouncementListPage::$showMore);
        $I->see(User::$groupName, AnnouncementListPage::$groupTitle);
        $I->see(User::$allAdvertsText.'5', AnnouncementListPage::$groupInfLine);
        $I->see(User::$interestingUserText.'0', AnnouncementListPage::$groupInfLine);
        $I->see(User::$notInterestingUserText.'0', AnnouncementListPage::$groupInfLine);
        $I->see(User::$agencyBossName. ' ('.User::$agencyEmail.')');
        $I->click(AnnouncementListPage::$groupUrl);
        $I->wait(2);
//        $I->pauseExecution();
        $I->see(User::$agencyUhomeName, AnnouncementListPage::$agencyInfoField);
        $I->see(User::$agencyEmail, AnnouncementListPage::$agencyInfoField);
        $I->seeElement(AnnouncementListPage::$image);
        $I->seeElement(AnnouncementListPage::$basicInfo);

        $I->click(AnnouncementListPage::$showMore1);
        $I->waitForElement(AdvPage::$advInfoGallery);
//        $I->see(Flat::priceFlatSell, AdvPage::$advInfoPrice);
        $I->see(Garage::commission, AdvPage::$advInfoPrice);
        $I->see(Garage::generalArea, AdvPage::$advInfoMainProps);
        $I->see($this->getTransportTypeName(0), AdvPage::$advInfoMainProps);
        $I->see($this->getInspectionPitName(0), AdvPage::$advInfoMainProps);
        $I->seeElement(AdvPage::$advPropsLink);
        $I->see(Garage::descriptionGarageSell,AdvPage::$advInfoDescription);
        $I->seeElement(AdvPage::$advInfoGallery);
        $I->click(AnnouncementListPage::$advPropsTab0);
        $I->see($this->getCategoryName(4), AdvPage::$advPropsTable);
        $I->see($this->getGaragesCategoryTypeName(0), AdvPage::$advPropsTable);
        $I->see($this->getRegionName(21), AdvPage::$advPropsTable);
        $I->see($this->getCityName(6), AdvPage::$advPropsTable);
        $I->see($this->getDistrictName(16), AdvPage::$advPropsTable);
        $I->see($this->getStreetName(201), AdvPage::$advPropsTable);
        $I->see(Garage::generalArea, AdvPage::$advPropsTable);
        $I->see(Garage::roomCount, AdvPage::$advPropsTable);
        $I->see(Garage::floorNumber, AdvPage::$advPropsTable);
        $I->see(Garage::floor, AdvPage::$advPropsTable);
        $I->see(Garage::buildYear, AdvPage::$advPropsTable);
        $I->see($this->getHeatingsName(0), AdvPage::$advPropsTable);
        $I->see($this->getParkingPlaceName(0), AdvPage::$advPropsTable);
        $I->see($this->getTransportTypeName(0), AdvPage::$advPropsTable);
        $I->see($this->getInspectionPitName(0), AdvPage::$advPropsTable);
        $I->see($this->getGarageAdditionalsName(0), AdvPage::$advPropsTable);
        $I->see($this->getCommunicationsName(0), AdvPage::$advPropsTable);
        $I->see($this->getNearObjectsName(0), AdvPage::$advPropsTable);
        $I->click(AnnouncementListPage::$showMore1);

        $I->click(AnnouncementListPage::$showMore2);
        $I->wait(1);
        $I->waitForElement(AdvPage::$advInfoGallery);
//        $I->see(Commercial::availableFrom, AdvPage::$advInfoAvailableFrom);
        $I->see(Commercial::generalArea, AdvPage::$advInfoMainProps);
        $I->see(Commercial::roomCount, AdvPage::$advInfoMainProps);
        $I->see($this->getWallMaterialsName(0), AdvPage::$advInfoMainProps);
        $I->see(Commercial::floors, AdvPage::$advInfoMainProps);
        $I->see(Commercial::floorNumber, AdvPage::$advInfoMainProps);
        $I->seeElement(AdvPage::$advPropsLink);
        $I->seeElement(AdvPage::$advInfoGallery);
//        $I->seeElement(AdvPage::$advInfoSocialButtons);
        $I->click(AnnouncementListPage::$advPropsTab1);
        $I->see(Commercial::category, AdvPage::$advPropsTable);
        $I->see(Commercial::categoryType0, AdvPage::$advPropsTable);
        $I->see(Commercial::region, AdvPage::$advPropsTable);
        $I->see(Commercial::city, AdvPage::$advPropsTable);
        $I->see(Commercial::apiDistrict, AdvPage::$advPropsTable);
        $I->see(Commercial::apiStreetRent, AdvPage::$advPropsTable);
        $I->see(Commercial::generalArea, AdvPage::$advPropsTable);
        $I->see(Commercial::effectiveArea, AdvPage::$advPropsTable);
        $I->see(Commercial::roomCount, AdvPage::$advPropsTable);
        $I->see($this->getWCName(2), AdvPage::$advPropsTable);
        $I->see($this->getHeatingsName(2), AdvPage::$advPropsTable);
        $I->see($this->getWaterHeatingsName(2), AdvPage::$advPropsTable);
        $I->see($this->getRepairsName(0), AdvPage::$advPropsTable);
        $I->see($this->getCommunicationsName(0), AdvPage::$advPropsTable);
        $I->see($this->getCommercialAdditionalsName(0), AdvPage::$advPropsTable);
        $I->dontSee(AdvPage::$advSchemaTab);
        $I->click(AnnouncementListPage::$showMore2);

        $I->click(AnnouncementListPage::$showMore3);
        $I->wait(1);
        $I->waitForElement(AdvPage::$advInfoGallery);
        $I->see(Parcel::generalArea, AdvPage::$advInfoMainProps);
        $I->seeElement(AdvPage::$advPropsLink);
        $I->see(Parcel::descriptionParcelSell,AdvPage::$advInfoDescription);
        $I->seeElement(AdvPage::$advInfoGallery);
//        $I->seeElement(AdvPage::$advInfoSocialButtons);
        $I->click(AnnouncementListPage::$advPropsTab2);
        $I->see(Parcel::category, AdvPage::$advPropsTable);
        $I->see(Parcel::categoryType0, AdvPage::$advPropsTable);
        $I->see(Parcel::region, AdvPage::$advPropsTable);
        $I->see(Parcel::city, AdvPage::$advPropsTable);
        $I->see(Parcel::apiDistrict, AdvPage::$advPropsTable);
        $I->see(Parcel::apiStreet, AdvPage::$advPropsTable);
        $I->see(Parcel::generalArea, AdvPage::$advPropsTable);
        $I->see($this->getCommunicationsName(0), AdvPage::$advPropsTable);
        $I->see($this->getNearObjectsName(0), AdvPage::$advPropsTable);
        $I->see($this->getParcelAdditionalsName(0), AdvPage::$advPropsTable);
        $I->click(AnnouncementListPage::$showMore3);

        $I->click(AnnouncementListPage::$showMore4);
        $I->wait(1);
        $I->waitForElement(AdvPage::$advInfoGallery);
        $I->see(House::generalArea, AdvPage::$advInfoMainProps);
        $I->see(House::roomCount, AdvPage::$advInfoMainProps);
        $I->see(House::wallMaterial, AdvPage::$advInfoMainProps);
        $I->see(House::floors, AdvPage::$advInfoMainProps);
        $I->seeElement(AdvPage::$advPropsLink);
        $I->see(House::descriptionHouseSell,AdvPage::$advInfoDescription);
        $I->seeElement(AdvPage::$advInfoGallery);
        $I->click(AnnouncementListPage::$advPropsTab3);
        $I->see(House::category, AdvPage::$advPropsTable);
        $I->see(House::categoryType0, AdvPage::$advPropsTable);
        $I->see(House::region, AdvPage::$advPropsTable);
        $I->see(House::city, AdvPage::$advPropsTable);
        $I->see(House::districtSearch, AdvPage::$advPropsTable);
        $I->see(House::apiStreet, AdvPage::$advPropsTable);
        $I->see(House::generalArea, AdvPage::$advPropsTable);
        $I->see(House::livingArea, AdvPage::$advPropsTable);
        $I->see(House::kitchenArea, AdvPage::$advPropsTable);
        $I->see(House::roomCount, AdvPage::$advPropsTable);
        $I->see(House::floors, AdvPage::$advPropsTable);
        $I->see(House::buildYear, AdvPage::$advPropsTable);
        $I->see($this->getWCName(0), AdvPage::$advPropsTable);
        $I->see($this->getBalconiesName(1), AdvPage::$advPropsTable);
        $I->see($this->getHeatingsName(1), AdvPage::$advPropsTable);
        $I->see($this->getWaterHeatingsName(1), AdvPage::$advPropsTable);
        $I->see($this->getRepairsName(0), AdvPage::$advPropsTable);
        $I->see($this->getNearObjectsName(0), AdvPage::$advPropsTable);
        $I->see($this->getAppliancesName(0), AdvPage::$advPropsTable);
        $I->see($this->getCommunicationsName(0), AdvPage::$advPropsTable);
        $I->see($this->getHouseAdditionalsName(0), AdvPage::$advPropsTable);
        $I->click(AnnouncementListPage::$showMore4);

        $I->click(AnnouncementListPage::$showMore5);
        $I->wait(1);
        $I->waitForElement(AdvPage::$advInfoGallery);
//        $I->see(Flat::priceFlatSell, AdvPage::$advInfoPrice);
        $I->see(Flat::commission, AdvPage::$advInfoPrice);
        $I->see(Flat::generalArea, AdvPage::$advInfoMainProps);
        $I->see(Flat::roomCount, AdvPage::$advInfoMainProps);
        $I->see(Flat::editWallMaterial, AdvPage::$advInfoMainProps);
        $I->see(Flat::floorNumber, AdvPage::$advInfoMainProps);
        $I->see(Flat::floors, AdvPage::$advInfoMainProps);
        $I->seeElement(AdvPage::$advPropsLink);
        $I->see(Flat::descriptionFlatSell,AdvPage::$advInfoDescription);
        $I->seeElement(AdvPage::$advInfoGallery);
        $I->click(AnnouncementListPage::$advPropsTab4);
        $I->see(Flat::category, AdvPage::$advPropsTable);
        $I->see(Flat::categoryType0, AdvPage::$advPropsTable);
        $I->see(Flat::region, AdvPage::$advPropsTable);
        $I->see(Flat::city, AdvPage::$advPropsTable);
        $I->see(Flat::editDistrict, AdvPage::$advPropsTable);
        $I->see(Flat::apiStreet, AdvPage::$advPropsTable);
        $I->see(Flat::generalArea, AdvPage::$advPropsTable);
        $I->see(Flat::livingArea, AdvPage::$advPropsTable);
        $I->see(Flat::kitchenArea, AdvPage::$advPropsTable);
        $I->see($this->getMarketTypeName(0), AdvPage::$advPropsTable);
        $I->see(Flat::roomCount, AdvPage::$advPropsTable);
        $I->see(Flat::floorNumber, AdvPage::$advPropsTable);
        $I->see(Flat::floors, AdvPage::$advPropsTable);
        $I->see(Flat::buildYear, AdvPage::$advPropsTable);
        $I->see($this->getWCName(1), AdvPage::$advPropsTable);
        $I->see($this->getBalconiesName(1), AdvPage::$advPropsTable);
        $I->see($this->getHeatingsName(1), AdvPage::$advPropsTable);
        $I->see($this->getWaterHeatingsName(1), AdvPage::$advPropsTable);
        $I->see($this->getRepairsName(0), AdvPage::$advPropsTable);
        $I->see($this->getNearObjectsName(0), AdvPage::$advPropsTable);
        $I->see($this->getAppliancesName(0), AdvPage::$advPropsTable);
        $I->see($this->getFlatAdditionalsName(0), AdvPage::$advPropsTable);

        $I->click(AnnouncementListPage::$showMore5);

        $I->click(AnnouncementListPage::$interest1);
        $I->click(AnnouncementListPage::$unInterest2);


    }
    public function viewAgentGroup()
    {
        $I = $this;
        $I->amOnPage(AnnouncementListPage::$userGroupListUrl);
        $I->wait(2);
        $I->click(AnnouncementListPage::$showMore);
        $a = file_get_contents(codecept_data_dir('advCount1.txt'));
        $b = file_get_contents(codecept_data_dir('advCount2.txt'));
        $count = array ($a,$b);
        $c = array_sum($count);
        $I->see(User::$groupName, AnnouncementListPage::$groupTitle);
        $I->see(User::$allAdvertsText.$c ,AnnouncementListPage::$groupInfLine);
        $I->see(User::$interestingUserText.'0', AnnouncementListPage::$groupInfLine);
        $I->see(User::$notInterestingUserText.'0', AnnouncementListPage::$groupInfLine);
        $I->see(User::$agentName. ' ('.User::$agentEmail.')');
        $I->click(AnnouncementListPage::$groupUrl);
        $I->wait(2);
//        $I->pauseExecution();
        $I->see(User::$agentName, AnnouncementListPage::$agencyInfoField);
        $I->see(User::$agentEmail, AnnouncementListPage::$agencyInfoField);
        $I->seeElement(AnnouncementListPage::$image);
        $I->seeElement(AnnouncementListPage::$basicInfo);

        $I->click(AnnouncementListPage::$showMore1);
        $I->seeElement(AnnouncementListPage::$address);
        $I->seeElement(AnnouncementListPage::$mainProp);
        $I->seeElement(AnnouncementListPage::$description);
        $I->seeElement(AnnouncementListPage::$gallery);
        $I->click(AnnouncementListPage::$showMore2);
        $I->click(AnnouncementListPage::$interest1);
        $I->click(AnnouncementListPage::$unInterest2);


    }

}