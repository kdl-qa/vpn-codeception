<?php

namespace Page;


class AgencyEmployees
{
    public static $listFirstAgent = '.advert:nth-child(1)';
    public static $agentName = '.advert:nth-child(1) .annTitle span';
    public static $agentEmail = '.advert:nth-child(1) .annContent';


    public static $agentDeleteBtn = '.advert:nth-child(1) .annAction:last-child';
    public static $agentChangeStatusBtn = '.advert:nth-child(1) .annAction:first-child';
    public static $agentStatus = '.advert:nth-child(1) .status';
    public static $noAgentsBlock = '.afterSidebar';


}