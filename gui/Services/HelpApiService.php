<?php

namespace App\Services;
use App\Services\SymphonyHelperService;

class HelpApiService
{
    /**
     * Function to listing operator
     */

    function inquiryList() {
        $hostName = "inquiry";
        $responseData = SymphonyHelperService::httpRequest('GET', $hostName, $formData = array(), 1);
        return $responseData;
    }

    function faqList($faqId) {
        $hostName = "faq/".$faqId;
        $responseData = SymphonyHelperService::httpRequest('GET', $hostName, $formData = array(), 1);
        
        return $responseData;
    }
}
