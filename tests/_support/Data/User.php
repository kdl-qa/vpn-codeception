<?php
/**
 * Created by PhpStorm.
 * User: kdl
 * Date: 17.09.15
 * Time: 15:58
 */

namespace Data;


class User
{

    //----------------------------------  Data to login agency ------------------------ //

    static $agencyPass = 'L7KZXX';
    static $agencyEmail = 'support@uhome.ck.ua';
    static $agencyUhomeName = 'UHome';

    //----------------------------------  Data to login CUSTOM agency ------------------------ //

    static $agencyEmail2 = "berlinisimus.92@gmail.com";
    static $agencyPass2 = "123456";

    static $agencyEmail3 = "rblkkk@ukr.net";
    static $agencyPass3 = "123456";
    static $agencyName3 = "Test";


    //----------------------------------  Data to login user ------------------------ //


    static $userEmail = 'rblkkk@mail.ru';
    static $userPass = '123456';

    //----------------------------------  Data to register agency ------------------------ //

    static $agencyName = 'partners-and-co';
    static $agencyName1 = 'Domm';
    static $currentSubdomain;
    static $agencyFirstName = 'alex';
    static $agencyLastName = 'berlin';
    static $agencyRegPass = '123456';
    static $agencyDescription = 'Lorem ipsum dolor';
    static $agencyOfficeName0 = 'Main';
    static $agencyOfficeName1 = 'Second office';
    static $agencyOfficeNumbers0 = '1';
    static $agencyOfficeNumbers1 = '2';
    static $agencyAddressName0 = 'Котовского';
    static $agencyOfficePhoneNumber0_0 = '+380974812456';
    static $agencyOfficePhoneNumber0_1 = '+380974812457';
    static $agencySocialFb = 'test.com/fb';
    static $agencySocialVk = 'test.com/vk';

    //----------------------------------  Data to edit agency ------------------------ //
    static $editAgencyName = 'edit-partners-and-co';
    static $editCurrentSubdomain;
    static $editAgencyfirstName = 'edit-alex';
    static $editAgencylastName = 'edit-berlin';
    static $editAgencyDescription = 'Edit Lorem ipsum dolor';
    static $editAgencyOfficeName0 = 'Edit Main';
    static $editAgencyOfficeName1 = 'Edit Second office';
    static $editAgencyOfficeNumbers0 = '3';
    static $editAgencyOfficeNumbers1 = '4';
    static $editAgencyAddressName0 = 'Кирова';
    static $editAgencyOfficePhoneNumber0_0 = '+380504812456';
    static $editAgencyOfficePhoneNumber0_1 = '+380504812457';
    static $editAgencySocialFb = 'edit.test.com/fb';
    static $editAgencySocialVk = 'edit.test.com/vk';

    //----------------------------------  Data to register private person ------------------------ //

    static $userFirstName = 'alex_edit';
    static $userLastName = 'berlin_edit';
    static $userRegEmail = 'p2sh@mailzi.ru';



    static $currentEmail;
    static $currentAgencyEmail;
    static $currentAgentEmail;


    //----------------------------------  Data to edit user profile ------------------------ //
    static $userApiEmail = 'rblkkk@mail.ru';
    static $userPhoneNumber1 = '+380931213123';
    static $userPhoneNumber2 = '+380931213124';
    static $userFirstNameEdit = 'alex';
    static $userLastNameEdit = 'berlin';
    static $userEmailEdit = 'rblkkk1@mail.ru';


    //----------------------------------  Data to edit agency profile ------------------------ //

    static $agencyNameEdit = 'best';
    static $agencyfirstNameEdit = 'alexey';
    static $agencylastNameEdit = 'berlins';
    static $agencyEmailEdit = 'mb2s2a@mail.ru';
    static $agencyCurrentSubdomain = 'agency-bestss';
    static $agencyOfficeName0Edit = 'Head';
    static $agencyOfficePhoneNumberEdit0_0 = '+380974812422';
    static $agencyOfficePhoneNumberEdit0_1 = '+380974812433';
    static $agencyAddressName0Edit = 'Крупской';
    static $agencyCabinet0Edit = '2';
    static $agencySocialEmpty = "";
    static $agencySocialTw = 'twitter/page';
    static $agencyAboutNew = 'Lorem';

    static $scheduleMondayFrom = '09:00';
    static $scheduleMondayTo = '18:00';
    static $scheduleTuesdayFrom = '09:00';
    static $scheduleTuesdayTo = '18:00';
    static $scheduleSaturdayFrom = '10:00';
    static $scheduleSaturdayTo = '13:00';


    // ---------------------------------------- Data to register agent by agency ----------------------------------
    static $agentFirstName = 'Alexey';
    static $agentLastName = 'Berlin';
    static $agentPhone0 = '+380931213125';
    static $agentPhone1 = '+380931213127';
    static $agentPass = '123456';
    static $agentEmail = 'rblkkk@yandex.ru';
    static $agentName = 'Domm Agent';

    // ---------------------------------------- Data to register agent by agency ----------------------------------
    static $editAgentFirstName = 'Edit-Alexey';
    static $editAgentLastName = 'EditBerlin';
    static $editAgentPhone0 = '+380501213125';
    static $editAgentPhone1 = '+380501213127';




    // ---------------------------------------- Data to edit agent profile ----------------------------------

    static $agentFirstNameEdit = 'AgentName';
    static $agentLastNameEdit = 'AgentSurname';
    static $agentEmailEdit = 'n2z6s@mail.ru';

    static $agentActiveStatus = 'Активен';
    static $agentNotActiveStatus = 'Не активен';


    // ---------------------------------------- Data to login Administrator ----------------------------------



    static $adminEmail = 'admin@neru.com.ua';
    static $adminPass = 'YO$3M8Kg;@U9yfF';
    static $agentP = '+380931213127';

    // ---------------------------------  Announcement Data ---------------------------------------------------- //

    static $groupName = 'Test Group';
    static $editGroupName = 'Edit Test Group';
    static $subjectTitle ='Test subject';
    static $textGroup ='Use this link to see announcement list';


    // ---------------------------------  Additional Data ---------------------------------------------------- //
    static $NoAgentsLabel = 'Не добавлен ни один агент';


    static $subdomain = 'agency';
    static $domain = '.uhome.co';

    static $serviceTitle1 = 'Тестовая услуга с небольшим заголовком №1';
    static $serviceTitle2 = 'The test title of the service with the huge header. Lorem ipsum dolor sit amet, vehicula lorem nibh. Hendrerit elit velit ut, magna tellus velit, quisque et sit libero dolor.';
    static $serviceDescription1 = 'Lorem ipsum dolor sit amet, vehicula lorem nibh. Aliquam nam purus etiam accumsan odio. Hendrerit elit velit ut, magna tellus velit, quisque et sit libero dolor.';
    static $serviceDescription2 = 'Lorem ipsum dolor sit amet, vehicula lorem nibh. Aliquam nam purus etiam accumsan odio. Hendrerit elit velit ut, magna tellus velit, quisque et sit libero dolor. Nec dui vestibulum vehicula. Wisi sagittis nunc, in wisi nisl pede duis nulla, sed lectus sit senectus semper, eleifend vitae maecenas magnis pulvinar mi in. Sodales aliquet orci risus wisi nunc dapibus, adipiscing purus felis nibh ut est laoreet, convallis augue, quos integer. Dui pede sem, rutrum placerat justo cras ut risus nisl, aenean penatibus, risus eget. Rutrum lorem. Enim condimentum pede est sit ac. Ac pariatur dui egestas, lectus quis, rhoncus nulla nam ut euismod tincidunt tortor. Quam vestibulum quos amet vel quam imperdiet, sagittis gravida mollit pellentesque morbi, leo cum urna, nullam volutpat tincidunt nulla sodales congue, sed lacinia purus asperiores nulla at.';
    static $certificateTitle1 = 'Тестовый сертификат агентства недвижимости №1';


    // ------------------------------  Groups -------------------------------//

    static $interestingText = 'Интересных клиенту: ';
    static $notInterestingText = 'Не интересных клиенту: ';
    static $allAdvertsText = 'Всего объявлений: ';


    // ---------------------------------  Additional functions --------------------------------------------------- //


    static function uniqueUserEmail()
    {
        if (self::$currentEmail) {
            return self::$currentEmail;
        }
        $email = trim(file_get_contents(codecept_data_dir('userEmail.txt')));
        $emailPrefix = substr($email,0,1);
        $emailPrefix++;

        $domain = substr($email,1,17);
        $resultEmail = $emailPrefix.$domain;
        self::$currentEmail = $resultEmail;
        file_put_contents(codecept_data_dir('userEmail.txt'), $resultEmail);
        return $resultEmail;
    }

    static function uniqueApiUserEmail()
    {
        if (self::$currentEmail) {
            return self::$currentEmail;
        }
        $email = trim(file_get_contents(codecept_data_dir('apiUserEmail.txt')));
        $emailPrefix = substr($email,0,1);
        $emailPrefix++;
        $domain = substr($email,1,17);
        $resultEmail = $emailPrefix.$domain;
        self::$currentEmail = $resultEmail;
        file_put_contents(codecept_data_dir('apiUserEmail.txt'), $resultEmail);
        return $resultEmail;
    }


    static function uniqueAgentEmail()
    {
        if (self::$currentEmail) {
            return self::$currentEmail;
        }
        $email = trim(file_get_contents(codecept_data_dir('agentEmail.txt')));
        $emailPrefix = substr($email,0,1);
        $emailPrefix++;
        $domain = substr($email,1,17);
        $resultEmail = $emailPrefix.$domain;
        self::$currentEmail = $resultEmail;
        file_put_contents(codecept_data_dir('agentEmail.txt'), $resultEmail);
        return $resultEmail;
    }

    static function uniqueAgencyEmail()
    {
        if (self::$currentEmail) {
            return self::$currentEmail;
        }
        $email = trim(file_get_contents(codecept_data_dir('agencyEmail.txt')));
        $emailPrefix = substr($email,0,1);
        $emailPrefix++;
        $domain = substr($email,1,17);
        $resultEmail = $emailPrefix.$domain;
        self::$currentEmail = $resultEmail;
        file_put_contents(codecept_data_dir('agencyEmail.txt'), $resultEmail);
        return $resultEmail;
    }

    static function uniqueApiAgentEmail()
    {
        if (self::$currentAgentEmail) {
            return self::$currentAgentEmail;
        }
        $email = trim(file_get_contents(codecept_data_dir('apiAgentEmail.txt')));
        $emailPrefix = substr($email,0,1);
        $emailPrefix++;
        $domain = substr($email,1,17);
        $resultEmail = $emailPrefix.$domain;
        self::$currentAgentEmail = $resultEmail;
        file_put_contents(codecept_data_dir('apiAgentEmail.txt'), $resultEmail);
        return $resultEmail;
    }

    static function uniqueApiAgencyEmail()
    {
        if (self::$currentAgencyEmail) {
            return self::$currentAgencyEmail;
        }
        $email = trim(file_get_contents(codecept_data_dir('apiAgencyEmail.txt')));
        $emailPrefix = substr($email,0,1);
        $emailPrefix++;
        $domain = substr($email,1,17);
        $resultEmail = $emailPrefix.$domain;
        self::$currentAgencyEmail = $resultEmail;
        file_put_contents(codecept_data_dir('apiAgencyEmail.txt'), $resultEmail);
        return $resultEmail;
    }


    static function uniqueSubdomain()
    {
        if (self::$currentSubdomain) {
            return self::$currentSubdomain;
        }
        $subdomain = trim(file_get_contents(codecept_data_dir('subdomains.txt')));
        $resultSubdomain= str_shuffle($subdomain);

        self::$currentSubdomain = $resultSubdomain;
        file_put_contents(codecept_data_dir('subdomains.txt'), $resultSubdomain);
        return $resultSubdomain;
    }



    static function grabRestorePassLink($html){
        preg_match('~<a(.*?)href="([^"]+)"(.*?)>~',$html, $matches);
        return $matches[2];

    }

    static function grabPassFromMail($html){
        $pass_string =  strip_tags($html);
        $pass_string = strstr($pass_string,"Ваш пароль:");
        $pass_string = substr($pass_string,21,8);
        return $pass_string;

    }

    static function getUserPassword(){
        $pass = file_get_contents(codecept_data_dir('user_password_response.php'));
        return $pass;

    }

    static function getUserEmail(){
        $email = file_get_contents(codecept_data_dir('userEmail.txt'));
//        $email = json_decode($email)->email;
        return $email;
    }

    static function getApiUserEmail(){
        $email = file_get_contents(codecept_data_dir('apiUserEmail.txt'));
//        $email = json_decode($email)->email;
        return $email;
    }

    static function getAgencyDescription(){
        $description = file_get_contents(codecept_data_dir('agency_data.json'));
        $description = json_decode($description)->description;
        return $description;
    }

    static function getAgencyEmail(){
        $email = file_get_contents(codecept_data_dir('agency_data.json'));
        $email = json_decode($email)->email;
        return $email;
    }

    static function getApiAgencyEmail(){
        $email = file_get_contents(codecept_data_dir('apiAgencyEmail.txt'));
//        $email = json_decode($email)->email;
        return $email;
    }

    static function getAgencyLogo(){
        $imageId = file_get_contents(codecept_data_dir('logo_id.json'));
        //$imageId = json_decode($imageId)->id;
        return $imageId;
    }
    static function getEditAgencyLogo(){
        $imageId = file_get_contents(codecept_data_dir('edit_logo_id.json'));
        //$imageId = json_decode($imageId)->id;
        return $imageId;
    }

    static function getAgencyAvatar(){
        $imageId = file_get_contents(codecept_data_dir('avatar_id.json'));
        //$imageId = json_decode($imageId)->id;
        return $imageId;
    }
    static function getEditAgencyAvatar(){
        $imageId = file_get_contents(codecept_data_dir('edit_avatar_id.json'));
        //$imageId = json_decode($imageId)->id;
        return $imageId;
    }

    static function getAgencyToken(){
        $token = file_get_contents(codecept_data_dir('agency_token.json'));
        return $token;
    }

    static function getAgencySubdomain(){
        $subdomain = file_get_contents(codecept_data_dir('agency_data.json'));
        $subdomain = json_decode($subdomain)->subdomain;
        return $subdomain;
    }

    static function getCurrentSubdomain(){
        $subdomain = file_get_contents(codecept_data_dir('subdomains.txt'));
        return $subdomain;
    }

    static function getCurrentUserEmail(){
        $email = file_get_contents(codecept_data_dir('userEmail.txt'));
        return $email;
    }

    static function getCurrentAgentEmail(){
        $email = file_get_contents(codecept_data_dir('agentEmail.txt'));
        return $email;
    }

    static function getApiAgentEmail(){
        $email = file_get_contents(codecept_data_dir('apiAgentEmail.txt'));
//        $email = json_decode($email)->email;
        return $email;
    }

    static function getCurrentAgencyEmail(){
        $email = file_get_contents(codecept_data_dir('agencyEmail.txt'));
        return $email;
    }

    public static function getUserId($id)
    {
        switch($id){
            case 1:
                $user_id = file_get_contents(codecept_data_dir('user_data.json'));
                $user_id = json_decode($user_id)->id;
                return $user_id;
                break;
            case 2:
                $agent_id = file_get_contents(codecept_data_dir('agent_data.json'));
                $agent_id = json_decode($agent_id)->id;
                return $agent_id;
                break;
            case 3:
                $agency_id = file_get_contents(codecept_data_dir('agency_data.json'));
                $agency_id = json_decode($agency_id)->id;
                return $agency_id;
                break;
            case 4:
                $admin_id = file_get_contents(codecept_data_dir('admin_data.json'));
                $admin_id = json_decode($admin_id)->id;
                return $admin_id;
                break;
            default:
                break;
        }
    }

    static function getAgentToken(){
        $token = file_get_contents(codecept_data_dir('agent_token.json'));
        return $token;
    }

    static function getAdminToken(){
        $token = file_get_contents(codecept_data_dir('admin_token.json'));
        return $token;
    }

    static function getAgentEmail(){
        $email = file_get_contents(codecept_data_dir('agent_data.json'));
        $email = json_decode($email)->email;
        return $email;
    }

    static function getUserToken(){
        $token = file_get_contents(codecept_data_dir('user_token.json'));
        return $token;
    }

    static function getAdminEmail(){
        $email = file_get_contents(codecept_data_dir('admin_data.json'));
        $email = json_decode($email)->email;
    }

    static function getGroupId(){
        $groupId = file_get_contents(codecept_data_dir('groupId.json'));
        return $groupId;
    }

    static function getFlatId(){
        $flatId = file_get_contents(codecept_data_dir() . 'advertFlatId.json');
        return $flatId;
    }

    static function getHouseId(){
        $houseId = file_get_contents(codecept_data_dir('advertHouseId.json'));
        return $houseId;
    }

    static function getParcelId(){
        $parcelId = file_get_contents(codecept_data_dir('advertParcelId.json'));
        return $parcelId;
    }

    static function getCommercialId(){
        $commercialId = file_get_contents(codecept_data_dir('advertCommercialId.json'));
        return $commercialId;
    }
    static function getGarageId(){
        $garageId = file_get_contents(codecept_data_dir('advertGarageId.json'));
        return $garageId;
    }

    static function getCityId(){
        $cityId = file_get_contents(codecept_data_dir('cityId.json'));
        return $cityId;
    }

    static function getDistrictId(){
        $districtId = file_get_contents(codecept_data_dir('districtId.json'));
        return $districtId;
    }

    static function getStreetId(){
        $streetId = file_get_contents(codecept_data_dir('streetId.json'));
        return $streetId;
    }

    static function getCategoryTypeId(){
        $categoryTypeId = file_get_contents(codecept_data_dir('categoryTypeId.json'));
        return $categoryTypeId;
    }




}