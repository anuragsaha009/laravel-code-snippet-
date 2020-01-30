<?php

namespace App\Http\Controllers;
use App\Services\NoticeManagementApiService;

use Illuminate\Http\Request;

class NoticeManagementController extends Controller
{
    
    public $noticeManagementApiServiceObject;

    public function __construct()
    {
        $this->noticeManagementApiServiceObject = new NoticeManagementApiService();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function list()
    {
        $notices = array();
        $apiResponse = $this->noticeManagementApiServiceObject->list();
        $notices = $apiResponse['response']['content'];
        return view('notice.list',['notices' => $notices]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createInit()
    { 
        $apiResponse = $this->noticeManagementApiServiceObject->datacenterDetails();
        $datacenterDetails = $apiResponse['response']['content']['datacenter'];
        return view('notice.create',['datacenterDetails' => $datacenterDetails]);
    }

    /**
     * Store a newly draft e.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param Array $formData
     * @return \Illuminate\Http\Response
     */

    public function draft(Request $request) {
        
        $formData = $request->all(); 
        
        // Calling API Service Managment 
        $apiResponse = $this->noticeManagementApiServiceObject->draft($formData);
        $redirect_url = $apiResponse['http_code'] == 200 ? 'notices/' : 'back';
        return $this->returnOutput($request, $apiResponse['response'], $apiResponse['http_code'], $apiResponse['type'], $redirect_url, 'success');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param Array $inputData
     * @param Array $formData
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        // Form Request 
        $inputData = $request->all(); 
        $formData = array();

        $floor = array();
        if( $inputData['input_floor'] != '') {
            $floor = explode(',', $inputData['input_floor']);
        }

        $datacenter = array();
        if( $inputData['input_datacenter'] != '') {
            $datacenter = explode(',', $inputData['input_datacenter']);
        }

        $target_audience = array();
        if( $inputData['input_target_audience'] != '') {
            $target_audience = explode(',', $inputData['input_target_audience']);
        }
        // Generating data for sending API

        $formData['title'] = $inputData['input_notice_title'];
        $formData['start_date'] = $inputData['input_start_date'];
        $formData['end_date'] = $inputData['input_end_date'];
        $formData['notice_details'] = $inputData['input_notice_details']; 
        $formData['is_public'] =  $inputData['is_public'];
        $formData['email_subject'] =  $inputData['email_subject'] ?? null ;
        $formData['target_audience'] =  $target_audience;
        $formData['datacenter'] =  $datacenter;
        $formData['floor'] =  $floor;

        // Calling API Service Managment 
        $apiResponse = $this->noticeManagementApiServiceObject->create($formData);
        $redirect_url = $apiResponse['http_code'] == 200 ? 'notices/' : 'back';
        
        // return view 
        return $this->returnOutput($request, $apiResponse['response'], $apiResponse['http_code'], $apiResponse['type'], $redirect_url, 'success');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $notices = array();
        
        // To Get Datacenter details
        $apiResponseDatacenter = $this->noticeManagementApiServiceObject->datacenterDetails();
        $datacenterDetails = $apiResponseDatacenter['response']['content']['datacenter'];

        // To Get Noitice Details 

        $apiResponse = $this->noticeManagementApiServiceObject->show($id);
        $notice = $apiResponse['response']['content']['notice'];
        $targetAudiences = $apiResponse['response']['content']['audiences'];
        $datacenters = $apiResponse['response']['content']['datacenters'];
        $floors = $apiResponse['response']['content']['floors'];
        
        // return view 
        return view('notice.edit',['notice' => $notice, 'targetAudiences'=> $targetAudiences, 'datacenters'=> $datacenters,'floors' => $floors,'datacenterDetails'=> $datacenterDetails ]);
    }

   
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    { 
        // $formData = $request->all();
        // $formData['id'] = $id;
        //dd($formData);
        // Form Request 
        $inputData = $request->all(); 
        $formData = array();

        $floor = array();
        if( $inputData['input_floor'] != '') {
            $floor = explode(',', $inputData['input_floor']);
        }

        $datacenter = array();
        if( $inputData['input_datacenter'] != '') {
            $datacenter = explode(',', $inputData['input_datacenter']);
        }

        $target_audience = array();
        if( $inputData['input_target_audience'] != '') {
            $target_audience = explode(',', $inputData['input_target_audience']);
        }
        // Generating data for sending API

        $formData['title'] = $inputData['input_notice_title'];
        $formData['start_date'] = $inputData['input_start_date'];
        $formData['end_date'] = $inputData['input_end_date'];
        $formData['notice_details'] = $inputData['input_notice_details']; 
        $formData['is_public'] =  $inputData['is_public'];
        $formData['email_subject'] =  $inputData['email_subject'] ?? null ;
        $formData['target_audience'] =  $target_audience;
        $formData['datacenter'] =  $datacenter;
        $formData['floor'] =  $floor;
        $formData['id'] = $id;

        dd($formData);
       
        // Calling API Service Managment 
        $apiResponse = $this->noticeManagementApiServiceObject->update($formData);          
        $redirect_url = $apiResponse['http_code'] == 200 ? 'notices' : 'back';

         // return view 
        return $this->returnOutput($request, $apiResponse['response'], $apiResponse['http_code'], $apiResponse['type'], $redirect_url, 'success');
    }


     /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function previewInit(Request $request, $id)
    {
        $notices = array();
        $apiResponse = $this->noticeManagementApiServiceObject->preview($id);
        $notice = $apiResponse['response']['content']['notice'];
        return view('notice.preview', ['notice' => $notice]);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
    */

    public function preview(Request $request, $id)
    {
        //
    }

    /**
     * Copy the specified notice in storage.
     * @param  int  $id
     * @return \Illuminate\Http\Response
    */

    public function copyInit($id) {

        // To Get Datacenter details
        $apiResponseDatacenter = $this->noticeManagementApiServiceObject->datacenterDetails();
        $datacenterDetails = $apiResponseDatacenter['response']['content']['datacenter'];

        // To Get Notice Details
        $apiResponse = $this->noticeManagementApiServiceObject->copy($id);
        $notice = $apiResponse['response']['content']['notice'];
        $targetAudiences = $apiResponse['response']['content']['audiences'];
        $datacenters = $apiResponse['response']['content']['datacenters'];
        $floors = $apiResponse['response']['content']['floors'];

        return view('notice.copy',['notice' => $notice, 'targetAudiences'=> $targetAudiences, 'datacenters'=> $datacenters,'floors' => $floors,'datacenterDetails' => $datacenterDetails ]);
    }


     /**
     * Copy the specified notice in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
    */

    public function copy(Request $request, $id)
    {
        
    }

     /**
     * Get the specified details in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function details($id) {

        $notice = array();

        // Calling API Service Managment 
        $apiResponse = $this->noticeManagementApiServiceObject->details($id);
        

        $notice = $apiResponse['response']['content']['notice'];
        $activityLog = $apiResponse['response']['content']['activityLog'];

        return view('notice.details',['notice' => $notice, 'activityLog' => $activityLog]);
    }


    /**
     * Remove the specified resource from storage.
     *  @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request, $id)
    {
        $apiResponse = $this->noticeManagementApiServiceObject->delete($id);
        $redirect_url = $apiResponse['http_code'] == 200 ? 'notices' : 'back';

        // return view 
        return $this->returnOutput($request, $apiResponse['response'], $apiResponse['http_code'], $apiResponse['type'], $redirect_url, 'success');
    }


}
