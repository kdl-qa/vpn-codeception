<?php

namespace Data;


class House
{
    const category = 'Дома и дачи';
    const categoryType0 = 'Дом';
    const categoryType1 = 'Дома и дачи';
    const categoryType2 = 'Часть дома';
    const region = 'Черкасская область';
    const city = 'Черкассы';
    const district = 'Казбет';
    const street = 'Франко улица';
    const houseNumber = '129';
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
    const floorNumber = '2';
    const buildYear = '1991';
    const wc = 'Раздельный';
    const heating = 'Централизованное';
    const waterHeating = 'Бойлер';
    const descriptionHouseSell = 'Продается дом в тихом районе города. Дом ремонта и вложений не требует. Рядом хорошая транспортная розвязка.';
    const priceHouseSell = '65050';
    const currencyUA = 'грн.';
    const currencyUS = '$';
    const periodDay = 'За день';
    const periodMonth = 'За месяц';
    const date = '20';
    const month = 'Октября';
    const year = '2015';
    const market = 'Вторичный';
    const repair = 'Косметический';
    const beds = '3';
    const ownerName = 'Александр Александров';
    const ownerContacts = 'alalex@mail.com; +380671234567';


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