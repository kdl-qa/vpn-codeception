<?php

namespace Data;


class House
{
    const category = 'Дома и дачи';
    const categoryType0 = 'Дом';
    const categoryType1 = 'Дома и дачи';
    const categoryType2 = 'Дача';
    const region = 'Черкасская область';
    const city = 'Черкассы';
    const district = 'Казбет';
    const street = 'Франко улица';
//    const houseNumber = '129';
    const generalArea = '65';
    const latitude = '49.44968';
    const longitude = '32.04494';
    const generalAreaUnit = 'Кв. метры';
    const wallMaterial = 'Дерево и кирпич';
    const roomCount = '4';
    const livingArea = '50';
    const kitchenArea = '9';
    const landArea = '6';
    const landAreaUnit = 'Сотки';
    const floors = '2';
    const buildYear = '1991';
    const wc = 'Раздельный';
    const heating = 'Централизованное';
    const waterHeating = 'Бойлер';
    const descriptionHouseSell = 'Продается дом в тихом районе города. Дом ремонта и вложений не требует. Рядом хорошая транспортная розвязка.';
    const descriptionHouseRent = 'Сдается в аренду дом. Дом расположен в элитном районе города, ремонта и вложений не требует. Рядом находится парк отдыха, недалеко хорошая транспортная розвязка.';
    const priceHouseSell = '75050';
    const priceHouseRent = '7500';
    const currencyUA = 'грн.';
    const currencyUS = '$';
    const commission = '3';
    const periodDay = 'За день';
    const periodMonth = 'За месяц';
    const date = '20';
    const month = 'Ноября';
    const year = '2015';
    const availableFrom = '20.11.2015';
    const apiAvailableFrom = '2015-11-20';
    const market = 'Вторичный';
    const repair = 'Косметический';
    const beds = '3';
    const ownerName = 'Александр Александров';
    const ownerContacts = 'alalex@mail.com; +380671234567';

/*=======================================Edit House=======================================*/

    const editDescriptionHouseSell = 'Аренда квартиры в центре города. Аренда квартиры без посредников. Квартира вложений не требует. Хорошая транспортная розвязка.';
    const editPriceHouseSell = '65000'; //$
    const editPriceHouseRent = '6000'; //грн

    const editDistrict = 'Водоканал-Невского';
    const editStreet = 'Ильина улица';
    const editLatitude = '49.41815';
    const editLongitude = '32.09172';
//    const editWallMaterial = 'Кирпич';
//    const editWaterHeating = '';
    const editGeneralArea = '125';
    const editRoomCount = '5';
    const editLivingArea = '100';
    const editKitchenArea = '15';
    const editLandArea = '8';
    const editFloors = '2';
    const editBuildYear = '1999';


    const editCommission = '4.5';
    const editDate = '10';
    const editMonth = 'Декабря';
    const editYear = '2015';
    const editAvailableFrom = '10.12.2015';
    const editBeds = '3';

    const editOwnerName = 'Дин Коен';
    const editOwnerContacts = 'dko@mail.com; +380679876543';




    static $currentHouseNumber;

    static function uniqueHouseNumber()
    {
        if (self::$currentHouseNumber) {
            return self::$currentHouseNumber;
        }
        $constFileName = codecept_data_dir('house_number.txt');
        $number = trim(file_get_contents($constFileName));
        $number++;
        self::$currentHouseNumber = $number;
        file_put_contents(codecept_data_dir('house_number.txt'), $number);
        return $number;
    }

}