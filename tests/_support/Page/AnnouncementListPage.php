<?php
namespace Page;

class AnnouncementListPage
{
    public static $groupListUrl =  '/user/lists-of-adverts';
    public static $createGroupButton = '.button.yellow';
    public static $groupNameField = '#groupName';
    public static $clientNameField = '[ng-model="ctrl.group.user"] span';
    public static $clientNameType = '[ng-model="ctrl.group.user"] input';
    public static $clientName0 = '.cc-client-group-name0';
    public static $submitButton = '.buttonContainer';
    public static $showMore = '.dottedLink';
    public static $groupTitle = '.title';
    public static $groupInfLine = '.newLine';
    public static $groupUrl ='div:nth-child(5)>a';
    public static $sendUrlLink = '[ng-click="ctrl.sendGroup(item)"]';
    public static $editGroupLink = '[ui-sref="editGroup({groupID: item.id})"]';
    public static $deleteGroupLink = '.red';
    public static $modalPopup = '.modal-content';
    public static $yesButton = '[ng-click="ctrl.apply()"]';
    public static $noButton = '[ng-click="ctrl.close()"]';
    public static $emailField = '#email';
    public static $clientField = '#client';
    public static $themeField = '#theme';
    public static $textContentField = '#textContent';




    public static $selectGroupField = '[ng-model="ctrl.advGroup"] span';
    public static $selectGroupType = '[ng-model="ctrl.advGroup"] input';
    public static $selectGroup0 = '.cc-group-name0';
    public static $advGroupList = '.advGroupList';


    //------------------------User---------------//

    public static $userGroupListUrl = '/user/my-lists-of-adverts';

    //-------------Group page-------------------//
    public static $agencyInfoField = '.info';
    public static $showMore1 = '.cc-advert-0 .dottedLink';
    public static $showMore2 = '.cc-advert-1 .dottedLink';
    public static $interest1 = '.cc-interesting-0';
    public static $unInterest1 = '.cc-not-interesting-0';
    public static $interest2 = '.cc-interesting-1';
    public static $unInterest2 = '.cc-not-interesting-1';
    public static $image = '.imageWrapper';
    public static $basicInfo = '.annContent';
    public static $address = '.address';
    public static $mainProp = '.mainCharacters';
    public static $description = '.description';
    public static $gallery = '.description';

    //--------------Edit group page---------------------//
    public static $generalInfo = '.editGroup.ng-scope li:nth-child(2) >a';
    public static $deleteAdv = '.annFooter >a';
    public static $clearInter ='.cc-clear-favorites';
    public static $saveButton = '.blue';







}
