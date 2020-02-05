<?php
namespace App\Services;

use App\Services\SymphonyHelperService;

class NoticeManagementApiService
{
    /**
     * Function to listing notices
     */

    function list() {
        $hostName = "notices";
        $formData = array();
        $responseData = SymphonyHelperService::httpRequest('GET', $hostName, $formData, 1);
        return $responseData;

    }

    /**
     * Function to create draft notice
     * @param array $formData
     * @return JSON
     */

    public function draft($formData)
    {
        $hostName = "notices/draft";
        $responseData = SymphonyHelperService::httpRequest('POST', $hostName, $formData, 1);
        return $responseData;

    }

    /**
     * Function to creating notice
     */

    public function create($formData)
    {
        $hostName = "notices/create";
        $responseData = SymphonyHelperService::httpRequest('POST', $hostName, $formData, 1);
        return $responseData;

    }

    /**
     * Function to show details notice
     * @param Integer $id
     * @return JSON
     */

    public function show($id)
    {
        $hostName = "notices/" . $id . "/update";
        $formData = array();
        $responseData = SymphonyHelperService::httpRequest('GET', $hostName, $formData, 1);
        return $responseData;
    }

    /**
     * Function to update notice
     * @param array $formData
     * @return JSON
     */

    public function update($formData)
    {
        $hostName = "notices/" . $formData['id'] . "/update";
        $responseData = SymphonyHelperService::httpRequest('POST', $hostName, $formData, 1);
        return $responseData;
    }

    /**
     * Function to copy notice
     * @param Integer $id
     * @return JSON
     */

    public function copy($id)
    {
        $hostName = "notices/" . $id . "/copy";
        $formData = array();
        $responseData = SymphonyHelperService::httpRequest('GET', $hostName, $formData, 1);
        return $responseData;
    }

    /**
     * Function to show details notice
     * @param Integer $id
     * @return JSON
     */

    public function preview($id)
    {
        $hostName = "notices/" . $id . "/preview";
        $formData = array();
        $responseData = SymphonyHelperService::httpRequest('GET', $hostName, $formData, 1);
        return $responseData;
    }

    /**
     * Function to delete notice
     * @param Integer $id
     * @return JSON
     */

    public function delete($id)
    {
        $formData = array();
        $formData['id'] = $id;

        $hostName = "notices/delete";
        $responseData = SymphonyHelperService::httpRequest('DELETE', $hostName, $formData, 1);
        return $responseData;
    }

    /**
     * Function to details notice
     * @param Integer $id
     * @return JSON
     */

    public function details($id)
    {
        $formData = array();
        $formData['id'] = $id;
        $hostName = "notices/" . $id . "/details";
        $responseData = SymphonyHelperService::httpRequest('GET', $hostName, $formData, 1);
        return $responseData;
    }

    /**
     * Function to delete notice
     * @param $hostName
     * @return JSON
     */

    public function datacenterDetails()
    {
        $hostName = "notices/datacenter-details";
        $formData = array();
        $responseData = SymphonyHelperService::httpRequest('GET', $hostName, $formData, 1);
        return $responseData;
    }
}
