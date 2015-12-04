<?php
namespace Page;


class Registration
{

    // ---------------------------------------- Data to register private person ----------------------------------

    public static $register_private_person_url = '/registration-private-person';

    public static $email = "#email";
    public static $name = "#fname";
    public static $pass = ".//*[@id='password']";
    public static $restorePass = 'html/body/div[1]/div[3]/form/dl/div/a';
    public static $submitRegistrationBtn = '.yellow';
    public static $submit_login_btn = 'html/body/div[1]/div[3]/form/dl/div/button';


    // ---------------------------------------- Data to register agent by agency ----------------------------------

    public static $register_agent_url = "/user/agents/registration-agent";
    public static $employees_list_url = "/user/agents";


    public static $agentFirstName = "#fname";
    public static $agentLastName = "#lname";
    public static $agentEmail = "#email";
    public static $agentPhone0 = "#phone0";
    public static $agentPhone1 = "#phone1";
    public static $addPhoneBtn = '.container .linkContainer .ng-scope';
    public static $deletePhoneBtn = '.container .linkContainer .red';
    public static $agentPass= "#pass";

    // ---------------------------------------- Data to register agency ----------------------------------

    public static $register_agency_url = "/registration-agency";
    public static $agencyName = "#aname";
    public static $agencySubdomain = "#ahost";
    public static $agencyLogo = "#image2";
    public static $agencyAvatar = '#image';


    public static $agencyAbout = '#description';
    //public static $addPhoneBtn = 'html/body/div[1]/div[3]/div[2]/div/form/dl/div[1]/dd/div/a[2]';
    public static $agencyPhoneNumber1 = '#phone0_0';
    public static $agencyOfficeName0 = '#officeName0';
    public static $agencyAddressName0 = 'address0';
    public static $agencyCabinet0 = '#cabinet0';
    public static $agencySocialVk = '#vk';
    public static $agencySocialTw = '#twitter';
    public static $deletePhoneBtn2 = ".//*[@id='editAgencyForm']/dl/div[4]/div[2]/dd/div[2]/a[1]";
    public static $deleteOffice1 = ".//*[@id='editAgencyForm']/dl/div[5]/dd[7]/button[1]";
    public static $submit_edit_profileBtn = ".yellow";
    public static $submit_edit_profileModal = ".buttonContainer ";

}