<?php


namespace Page;

class AdvertsList
{
    // include url of current page
    public static $URL = '/user/adverts';
    public static $editAdvURL = '/user/adverts/' ;

    public static $firstListAdvert = 'li.advert:first-child';
    public static $firstListAdvertTitle = '.advert:nth-child(1) .annTitle a.ng-binding';

    public static $advInfoTab = 'ul.nav.nav-tabs li:nth-child(1)';
    public static $advInfoTable = 'table.ng-scope';
    public static $advUnpublishLink = 'tr:nth-child(1) td:nth-child(2) a';
    public static $advInfoLink = 'tr:nth-child(2) td:nth-child(2) a';
    public static $editAdvStatus = 'span.status';
    public static $editAdvObjInfoTab = 'ul.nav.nav-tabs li:nth-child(2)';
    public static $editAdvObjTable = 'table.ng-scope';

    public static $editAdvTab = 'ul.nav.nav-tabs li:nth-child(3)';
    public static $editAdvOperationType = '[ng-model="ctrl.advert.operationType"]';
    public static $editAdvDescription = '[ng-model="ctrl.advert.description"]'; /*'#description'*/
    public static $editAdvPrice = '#price';
    public static $editAdvCurrency = '[ng-model="ctrl.advert.currency"]';
    public static $editAdvMarketType = '[ng-model="ctrl.advert.marketType"]';
    public static $editAdvRepair = '[ng-model="ctrl.advert.repair"]';
    public static $editAdvBedsCount = '[ng-model="selected"]';
    public static $editAdvAddImage = '#image';
    public static $editAdvOwnerLink = 'a.dottedLink';
    public static $editAdvOwnerName = '#ownerName';
    public static $editAdvOwnerContacts = '#ownerContacts';
    public static $editAdvSubmit = 'button.blue';

    public static $chooseReason = '.reason span';
    public static $upublishReason0 = '.unpublish-reason0';
    public static $upublishReason1 = '.unpublish-reason1';
    public static $finalPrice = '#finalValue';
    public static $descriptionReason = '#description';
    public static $chooseCurrency = '.currency span';
    public static $currencyUS = '.currency-type0';
    public static $currencyUA = '.currency-type1';
    public static $unpublishSubmit = 'button.blue';




//    public static $editAdv = '';









}
