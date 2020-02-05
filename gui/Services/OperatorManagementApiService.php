<?php

namespace App\Services;
use App\Services\SymphonyHelperService;

class OperatorManagementApiService
{

    /**
     * Function to login operator
     * @param type $request
     * @return type
     */
    public function login($formData)
    {
        $hostName = "operator/login";
        
        $responseData = SymphonyHelperService::httpRequest('POST', $hostName, $formData, 0);
       

        return $responseData;
    }

    /**
     * Function to listing operator
     */

    function list() {
        $hostName = "operators";
        $responseData = SymphonyHelperService::httpRequest('POST', $hostName, $formData = array(), 1);
        return $responseData;
    }

    /**
     * Function to create operator
     * @param type $request
     * @return type
     */

    public function create($formData)
    {
        $hostName = "operator/create";
        $responseData = SymphonyHelperService::httpRequest('POST', $hostName, $formData, 1);
        return $responseData;
    }

    /**
     * Function to edit operator
     */

    public function edit($id)
    {
        $formData = array();
        $formData['id'] = $id;

        $hostName = "operators";
        $responseData = SymphonyHelperService::httpRequest('POST', $hostName, $formData, 1);
        return $responseData;
    }

    /**
     * Function to update operator
     * @param type $request
     * @return type
     */

    public function update($formData)
    {
        $hostName = "operator/update";
        $responseData = SymphonyHelperService::httpRequest('POST', $hostName, $formData, 1);
        return $responseData;
    }

    /**
     * Function to delete operator
     * @param type $request
     * @return type
     */

    public function delete($id)
    {
        $formData = array();
        $formData['id'] = $id;

        $hostName = "operator/delete";
        $responseData = SymphonyHelperService::httpRequest('DELETE', $hostName, $formData, 1);
        return $responseData;
    }

    /**
     * Function for checking duplicate email address for operator
     * @param type $request
     * @return type
     */

    public function duplicateMailCheck($formData)
    {

        $hostName = "duplicate-mail";
        $responseData = SymphonyHelperService::httpRequest('POST', $hostName, $formData, 1);
        return $responseData;
    }

    /**
     * Function for operator email verification init view
     * @param type $request
     * @return type
     */

    public function accountVerificationInit($verificationToken)
    {

        $hostName = "operator/verification/" . $verificationToken;
        $formData = array();
        $formData['verification_token'] = $verificationToken;
        $responseData = SymphonyHelperService::httpRequest('GET', $hostName, $formData, 0);
        return $responseData;

    }

    /**
     * Function for operator email verification
     * @param type $request
     * @return type
     */

    public function accountVerification($formData)
    {

        $hostName = "operator/verification-confirmation/" . $formData['verificationToken'];
        $responseData = SymphonyHelperService::httpRequest('POST', $hostName, $formData, 0);
        return $responseData;

    }

    /**
     * Function for operator forgot password
     * @param type $request
     * @return type
     */

    public function resetPasswordInitialize($formData)
    {
        $hostName = "operator/reset-password-initialize";
        $responseData = SymphonyHelperService::httpRequest('GET', $hostName, $formData, 0);
        return $responseData;
    }

    public function resetPassword($formData) {
        $hostName = "operator/reset-password/" . $formData['resetToken'];
        $responseData = SymphonyHelperService::httpRequest('GET', $hostName, $formData, 0);
        return $responseData; 
    }

    public function resetPasswordConfirmation($formData) {
        $hostName = "operator/reset-password-confirmation/" . $formData['resetToken'];
        $responseData = SymphonyHelperService::httpRequest('POST', $hostName, $formData, 0);
        return $responseData; 
    }


}
