<?php

// framework/src/Calendar/Controller/LeapYearController.php

namespace Calendar\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Calendar\Model\LeapYear;

class LeapYearController
{
    public function
    indexAction(
        Request $request,
        $year)
    {
        $leapyear = new LeapYear();

        if($leapyear->isLeapYear($year))
        {
            ob_start();
            include __DIR__.'/../../pages/leapyear.php';
            //$response = new Response(ob_get_clean().rand());  
            $responseString = ob_get_clean().rand();  
        }
        else
        {
            //$response = new Response('Nope, not a leap year');
            $responseString = 'Nope, not a leap year';
        }

        return $responseString;
    }
}
