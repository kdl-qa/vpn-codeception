<?php


namespace Data;


class Parcel
{
    const category = 'Земельные участки';
    const categoryType0 = 'Участок под жилую застройку';
    const categoryType1 = 'Земля коммерческого назначения';
    const categoryType2 = 'Земля сельскохозяйственного назначения';
    const categoryType3 = 'Земля рекреационного назначения';
    const categoryType4 = 'Земля природно-заповедного назначения';

    const region = 'Черкасская область';
    const city = 'Черкассы';
    const district = 'Сады';
    const street = 'Ватутина улица';
//    const houseNumber = '129';
//    const generalArea = '65';
    const latitude = '49.41473';
    const longitude = '32.08260';
    const generalArea = '50';
    const generalAreaUnit = 'Сотки';
    const descriptionParcelSell = 'Продается Земельный участок в тихом районе города. Все документы на землю в порядке и соответствуют законодательству страны. Рядом хорошая транспортная розвязка.';
    const priceParcelSell = '21050';
    const priceParcelSearch = '35000';
    const currencyUA = 'грн.';
    const currencyUS = '$';
    const periodDay = 'За день';
    const periodMonth = 'За месяц';
    const commission = '2.5';
    const date = '5';
    const month = 'Декабря';
    const year = '2015';
    const availableFrom = '05.12.2015';
    const apiAvailableFrom = '2015-12-05';
    const market = 'Вторичный';
    const ownerName = 'Ioan Ioan';
    const ownerContacts = 'ioan@freeletter.me; +380671234567';


/*==========================================Edit Parcel=========================================*/

    const apiDistrict = 'Ж/д вокзал';
    const apiStreet = 'Будённого улица';
    const editCity = 'Смела';

    const editDistrict = 'Ж/д вокзал';
    const editStreet = 'Благовестная улица';
    const editGeneralArea = '15';

    const editDescriptionParcelRent = 'Edit. Сдам в аренду Земельный участок в тихом районе города. Все документы на землю в порядке и соответствуют законодательству страны. Рядом хорошая транспортная розвязка.';
    const editDescriptionParcelSell = 'Edit. Продается Земельный участок в тихом районе города. Все документы на землю в порядке и соответствуют законодательству страны.';
    const editPriceParcelRent = '1500';
    const editPriceParcelSell = '15500';
    const editCommission = '5.25';
    const editLatitude = '49.42487';
    const editLongitude = '32.084055';
    const editDate = '19';
    const editMonth = 'Января';
    const editYear = '2016';
    const editAvailableFrom = '19.01.2016';

    const editOwnerName = 'Ioan Ioan';
    const editOwnerContacts = 'ioan@freeletter.me; +380671234567';



/*==========================================Common=========================================*/


    static $currentCadastralNumber;


    static function uniqueCadastralNumber()
    {
//        if (self::$currentCadastralNumber) {
//            return self::$currentCadastralNumber;
//        }
//        $number = trim(file_get_contents(codecept_data_dir('cadastral_number.txt')),":");
//        $number = trim($constFileName, ':');
        $number = substr(str_shuffle("1234567890123456789"), 0, 19);
//        self::$currentCadastralNumber = $number;
        self::$currentCadastralNumber = preg_replace("/^(.{10})(.{2})(.{3})(.{4})$/","$1:$2:$3:$4", $number);
        file_put_contents(codecept_data_dir('cadastral_number.txt'), self::$currentCadastralNumber);
        return $number;
    }

}