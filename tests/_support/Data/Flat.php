<?php
/**
 * Created by PhpStorm.
 * User: kdl
 * Date: 16.09.15
 * Time: 15:07
 */

namespace Data;


class Flat
{
    const category = 'Квартиры и комнаты';
    const categoryType1 = 'Квартира';
    const categoryType2 = 'Комната';
    const region = 'Черкасская область';
    const city = 'Черкассы';
    const district = '700-летия';
    const street = 'Крещатик улица';
    const houseNumber = '200';
    const generalArea = '55';
    const generalAreaUnit = 'Кв. метры';
    const wallMaterial = 'Силикатный кирпич';
    const roomCount = '3';
    const livingArea = '43';
    const kitchenArea = '9';
    const floorNumber = '3';
    const floors = '10';
    const buildYear = '1982';
    const wc = 'Раздельный';
    const balcony = '1';
    const heating = 'Централизованное';
    const waterHeating = 'Бойлер';
    const descriptionFlatSell = 'Продается квартира в центре города. Квартира вложений не требует. Хорошая транспортная розвязка.';
    const priceFlatSell = '45121';
    const currencyUA = 'грн.';
    const currencyUS = '$';
    const periodDay = 'За день';
    const periodMonth = 'За месяц';
    const date = '20';
    const month = 'Октября';
    const year = '2015';
    const market = 'Вторичный';
    const repair = 'Дизайнерский';
    const beds = '3';
    const ownerName = 'Иван Иванов';
    const ownerContacts = 'wrong@mail.com; +380671234567';

    static $currentFlatNumber;

    static function uniqueFlatNumber()
    {
        if (self::$currentFlatNumber) {
            return self::$currentFlatNumber;
        }
        $constFileName = codecept_data_dir('flat_number.txt');
        $number = trim(file_get_contents($constFileName));
        $number++;
        self::$currentFlatNumber = $number;
        file_put_contents(codecept_data_dir('flat_number.txt'), $number);
        return $number;
    }

}