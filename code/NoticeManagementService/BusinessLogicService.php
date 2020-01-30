<?php

namespace App\Services\NoticeManagementService;

use App\Jobs\NoticationMail;
use App\Models\Datacenter;
use App\Models\Notice;
use App\Models\NoticeActivityLog;
use App\Models\TargetAudience;
use App\Services\HelperService;
use Carbon\Carbon;
use Queue;


class BusinessLogicService
{

    public function __construct()
    {
        $this->helperServiceObject = new HelperService();
    }

    /**
     * Return a JSON response to get all notices.
     * @return JSON
     */

    function list() {
        // Get all notices
        $noticesList = Notice::get();

        // return response
        return response()->json($this->helperServiceObject->constructResponseArray(200, 'success', 'notice.fetch_successful', '', $noticesList));
    }

    /**
     * Return a JSON response to draft notice.
     * @param Array  $formData
     * @return JSON
     */

    public function draft($formData)
    {
        //Decrypting the Authentication Token
        $jwtDecoded = $this->helperServiceObject->tokenDecryption($formData['token']);

        // Create notice
        $newNotice = new Notice;
        $newNotice->title = $formData['title'];
        $newNotice->start_date = Carbon::parse($formData['start_date'])->format('Y-m-d h:i:s');
        $newNotice->end_date = isset($formData['end_date']) ? Carbon::parse($formData['end_date'])->format('Y-m-d h:i:s') : null;
        $newNotice->notice_details = $formData['notice_details'];
        $newNotice->operator_id = $jwtDecoded->id;
        $newNotice->datacenter_id = 1;
        $newNotice->status = 1; // Draft
        $newNotice->save();

        // Assign datacenter floor
        if (count($formData['floor']) > 0) {
            $newNotice->floors()->attach($formData['floor']);
        }
        // Assign Target Audiences
        if (count($formData['target_audience']) > 0) {
            foreach ($formData['target_audience'] as $targetAudience) {

                $targetAudienceObj = new TargetAudience;
                $targetAudienceObj->notice_id = $newNotice->id;
                $targetAudienceObj->target_audience_id = $targetAudience;
                $targetAudienceObj->save();
            }
        }

        // Create activity log
        $activityLog = new NoticeActivityLog();
        $activityLog->notice_id = $newNotice->id;
        $activityLog->operator_id = $jwtDecoded->id;
        $activityLog->activity = "Notice ID #" . $newNotice->id . " was created.";
        $activityLog->save();

        // return response
        return response()->json($this->helperServiceObject->constructResponseArray(200, 'success', 'notice.notice_draft_successfull', 'flash', $newNotice));
    }

    /**
     * Return a JSON response to create notice.
     * @param Array  $formData
     * @return JSON
     */

    public function create($formData)
    {  
        //Decrypting the Authentication Token
        $jwtDecoded = $this->helperServiceObject->tokenDecryption($formData['token']);

        // Create notice
        $newNotice = new Notice;
        $newNotice->title = $formData['title'];
        $newNotice->start_date = Carbon::parse($formData['start_date'])->format('Y-m-d h:i:s');
        $newNotice->end_date = isset($formData['end_date']) ? Carbon::parse($formData['end_date'])->format('Y-m-d h:i:s') : null;
        $newNotice->notice_details = $formData['notice_details'];
        $newNotice->operator_id = $jwtDecoded->id;
        $newNotice->datacenter_id = 1;
        $newNotice->is_public = $formData['is_public'];
        $newNotice->email_subject = $formData['email_subject'] ?? null;
        $newNotice->status = 2; // complated
        $newNotice->save();

        // Assign datacenter floor
        if (count($formData['floor']) > 0) {
            $newNotice->floors()->attach($formData['floor']);
        }
        // Assign Target Audiences
        if (count($formData['target_audience']) > 0) {
            foreach ($formData['target_audience'] as $targetAudience) {

                $targetAudienceObj = new TargetAudience;
                $targetAudienceObj->notice_id = $newNotice->id;
                $targetAudienceObj->target_audience_id = $targetAudience;
                $targetAudienceObj->save();
            }
        }

        // Create activity log
        $activityLog = new NoticeActivityLog();
        $activityLog->notice_id = $newNotice->id;
        $activityLog->operator_id = $jwtDecoded->id;
        $activityLog->activity = "Notice ID #" . $newNotice->id . " was created.";
        $activityLog->save();
       
        // Sending Mail :
        Queue::push(new NoticationMail($newNotice));

        // return response
        return response()->json($this->helperServiceObject->constructResponseArray(200, 'success', 'notice.notice_creation_successfull', 'flash', $newNotice));
    }

    /**
     * Return a JSON response to show notice.
     * @param Integer  $id
     * @return JSON
     */

    public function show($id)
    {
        // Get notice
        $notice = Notice::find($id);

        // Get datacenters & floors.
        $datacenters = array();
        $datacenterFloors = array();
        $target = array();

        if (count($notice->floors) > 0) {
            foreach ($notice->floors as $notice_floor) {
                $datacenterFloors[] = $notice_floor->id;
                $datacenters[] = $notice_floor->datacenter_id;
            }
        }

        if (count($notice->targetAudiences) > 0) {
            foreach ($notice->targetAudiences as $singleTarget) {
                $target[] = $singleTarget->target_audience_id;
            }
        }

        $noticeDetails['notice'] = $notice->toArray();
        $noticeDetails['datacenters'] = array_unique($datacenters);
        $noticeDetails['floors'] = $datacenterFloors;
        $noticeDetails['audiences'] = $target;

        // return response
        return response()->json($this->helperServiceObject->constructResponseArray(200, 'success', 'notice.fetch_successful', '', $noticeDetails));
    }

    /**
     * Return a JSON response to show notice.
     * @param Array  $formData
     * @return JSON
     */

    public function update($formData)
    {
        //Decrypting the Authentication Token
        $jwtDecoded = $this->helperServiceObject->tokenDecryption($formData['token']);

        // Get notice
        $notice = Notice::find($formData['id']);
        // update notice
        $notice->title = $formData['title'];
        $notice->start_date = Carbon::parse($formData['start_date'])->format('Y-m-d h:i:s');
        $notice->end_date = isset($formData['end_date']) ? Carbon::parse($formData['end_date'])->format('Y-m-d h:i:s') : null;
        $notice->notice_details = $formData['notice_details'];
      //  $notice->operator_id = $jwtDecoded->id;
        $notice->datacenter_id = 1;
        $notice->is_public = $formData['is_public'];
        $notice->email_subject = $formData['email_subject'] ?? null;
        $notice->update();

        // Remove previous floors and assign new datacenter floor
        $notice->floors()->detach();
        if (isset($formData['floor'])) {
            $notice->floors()->attach($formData['floor']);
        }

        // Assign Target Audiences
        if (count($formData['target_audience']) > 0) {
            // Remove Target Audiences
            TargetAudience::where(['notice_id' => $formData['id']])->delete();
            foreach ($formData['target_audience'] as $target) {

                $targetAudienceObj = new TargetAudience;
                $targetAudienceObj->notice_id = $formData['id'];
                $targetAudienceObj->target_audience_id = $target;
                $targetAudienceObj->save();
            }
        }

        // Create activity log
        $activityLog = new NoticeActivityLog();
        $activityLog->notice_id = $formData['id'];
        $activityLog->operator_id = $jwtDecoded->id;
        $activityLog->activity = "Notice Details was updated.";
        $activityLog->save();

        // return response
        return response()->json($this->helperServiceObject->constructResponseArray(200, 'success', 'notice.notice_updation_successfull', ''));
    }

    /**
     * Return a JSON response to preview notice.
     * @param Integer  $id
     * @return JSON
     */

    public function preview($id)
    {
        // Get notice
        $notice = Notice::find($id);

        $noticeDetails['notice'] = $notice->toArray();
        // return response
        return response()->json($this->helperServiceObject->constructResponseArray(200, 'success', 'notice.fetch_successful', '', $noticeDetails));

    }

    /**
     * Return a JSON response to completed notice.
     * @param Array  $formData
     * @return JSON
     */

    public function completed($formData)
    {
        // Get notice
        $notice = Notice::find($formData['id']);

        // update for complete notice
        $notice->email_subject = $formData['email_subject'];
        $notice->is_public = $formData['is_public'];
        $notice->status = 2;
        $notice->save();

        // return response
        return response()->json($this->helperServiceObject->constructResponseArray(200, 'success', 'notice.notice_complete_successfull', '', $noticeDetails));
    }

    /**
     * Return a JSON response to delete notice.
     * @param Array  $formData
     * @return JSON
     */

    public function delete($formData)
    {
        // Get notice
        $notice = Notice::find($formData['id']);

        // Delete notice
        $notice->delete();

        // return response
        return response()->json($this->helperServiceObject->constructResponseArray(200, 'success', 'notice.notice_deletion_successfull', '', ''));
    }

    /**
     * Return a JSON response to details notice.
     * @param Array  $formData
     * @return JSON
     */

    public function details($formData)
    {
        // Get notice
        $notice = Notice::find($formData['id']);

        $noticeDetails = array();
        $activityLogArray = array();

        // Get activity log
        if (count($notice->activityLog) > 0) {
            foreach ($notice->activityLog as $log) {

                $singleLog = array();
                $singleLog['log_update_on'] = $log->created_at;
                $singleLog['activity'] = $log->activity;
                $singleLog['created_by'] = $log->operator->first_name . ' ' . $log->operator->first_name;

                $activityLogArray[] = $singleLog;
            }
        }
        $noticeDetails['notice'] = $notice->toArray();
        $noticeDetails['activityLog'] = $activityLogArray;

        // return response
        return response()->json($this->helperServiceObject->constructResponseArray(200, 'success', 'notice.fetch_successful', '', $noticeDetails));
    }

    /**
     * Return a JSON response to copy notice.
     * @param Integer  $id
     * @return JSON
     */

    public function copy($id)
    {
        // Get notice
        $notice = Notice::find($id);

        // Get datacenters & floors.
        $datacenters = array();
        $datacenterFloors = array();
        $target = array();

        if (count($notice->floors) > 0) {
            foreach ($notice->floors as $notice_floor) {
                $datacenterFloors[] = $notice_floor->id;
                $datacenters[] = $notice_floor->datacenter_id;
            }
        }

        if (count($notice->targetAudiences) > 0) {
            foreach ($notice->targetAudiences as $singleTarget) {
                $target[] = $singleTarget->target_audience_id;
            }
        }

        $noticeDetails['notice'] = $notice->toArray();
        $noticeDetails['datacenters'] = array_unique($datacenters);
        $noticeDetails['floors'] = $datacenterFloors;
        $noticeDetails['audiences'] = $target;

        // return response
        return response()->json($this->helperServiceObject->constructResponseArray(200, 'success', 'notice.fetch_successful', '', $noticeDetails));
    }

    public function datacenterDetails()
    {
        // Get datacenters
        $datacenter = Datacenter::all();
        // $datacenterFloors =  $datacenter->floors;
        $datacenter_floors = array();
        $responseArray = array();

        if (count($datacenter) > 0) {

            foreach ($datacenter as $key => $center) {

                $floorArray = array();
                if (count($center->floors) > 0) {
                    foreach ($center->floors as $k2 => $floor) {

                        $singleArray = array();
                        $singleArray['id'] = $floor->id;
                        $singleArray['name'] = $floor->floor_name;
                        $floorArray[] = $singleArray;

                    }
                }
                $datacenter_floors[] = $floorArray;
            }
        }

        $responseArray['datacenter'] = $datacenter->toArray();

        // return response
        return response()->json($this->helperServiceObject->constructResponseArray(200, 'success', 'notice.fetch_datacenter', '', $responseArray));

    }
}
