<?php
namespace Page;

class Login
{
    // include url of current page
    public static $URL = '/login';

    public static $email = "//input[@id='email']";
    public static $pass = "//input[@id='password']";
    public static $submit = "//button[@type='submit']";
    public static $restorePass = 'html/body/div[1]/div[3]/form/dl/div/a';
    public static $sigUpLink = 'html/body/div[1]/div[3]/p/a[1]';
    public static $submitLoginBtn = '.yellow';



    public static $menuBtn = '.userTitle';
    public static $logoutBtn = '.userPanel .userLinks li:last-child';
}
