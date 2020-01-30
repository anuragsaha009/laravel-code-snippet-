<?php

namespace App\Http\Controllers;

use App\Services\HelperService;
use App\Services\NoticeManagementService\BusinessLogicService;
use App\Services\NoticeManagementService\ValidationRulesService;
use Illuminate\http\Request;
use Validator;

class NoticeManagementController extends Controller
{
    protected $businessLogicServiceObject;
    protected $validationRulesServiceObject;

    public function __construct()
    {
        $this->validationRulesServiceObject = new ValidationRulesService();
        $this->businessLogicServiceObject = new BusinessLogicService();
        $this->HelperServiceObject = new HelperService();
    }

    /**
     * Function to fetch notice list.
     * @return \Illuminate\Http\Response
     */
    function list() {
        return $this->businessLogicServiceObject->list();
    }


    /**
     * Function to Draft notice.
     * @param  \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
    */

    public function draft(Request $request)
    {

        // get validation rules
        $validation = $this->validationRulesServiceObject->draftRules();

        //validate the request
        $validator = Validator::make($request->all(), $validation['rules'], $validation['messages']);


        if ($validator->fails()) {
            return response()->json($this->HelperServiceObject->constructResponseArray(400, 'failed', $validator->errors()->all(), 'validation_error'));
        } else {

            $formData = $request->all();
            $formData['token'] = $request->header('token');
            return $this->businessLogicServiceObject->draft($formData);
        }
    }


    /**
     * Function to create new notice.
     * @param  \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {

        // get validation rules
        $validation = $this->validationRulesServiceObject->createRules();

        //validate the request
        $validator = Validator::make($request->all(), $validation['rules'], $validation['messages']);


        if ($validator->fails()) {
            return response()->json($this->HelperServiceObject->constructResponseArray(400, 'failed', $validator->errors()->all(), 'validation_error'));
        } else {

            $formData = $request->all();
            $formData['token'] = $request->header('token');            
            return $this->businessLogicServiceObject->create($formData);
            
        }
    }

    /**
     * Function to get notice details.
     * @param Integer $id
     * @return \Illuminate\Http\Response
     */

    public function show($id)
    {
        return $this->businessLogicServiceObject->show($id);
    }

    /**
     * Function to update existing notice.
     *
     * @param  \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $formData = $request->all();

        // get validation rules
        $validation = $this->validationRulesServiceObject->updateRules();
        //validate
        $validator = Validator::make($formData, $validation['rules'], $validation['messages']);
        if ($validator->fails()) {
            return response()->json($this->HelperServiceObject->constructResponseArray(400, 'failed', $validator->errors()->all(), 'validation_error'));
        } else {
            $formData['token'] = $request->header('token');
            return $this->businessLogicServiceObject->update($formData);
        }
    }

    /**
     * Function to get notice details.
     * @param Integer $id
     * @return \Illuminate\Http\Response
     */

    public function copy($id)
    {
        return $this->businessLogicServiceObject->copy($id);
    }

    /**
     * Function to get notice preview details.
     * @param Integer $id
     * @return \Illuminate\Http\Response
     */

    public function preview($id)
    {
        $formData['id'] = $id;

        // get validation rules
        $validation = $this->validationRulesServiceObject->existsRules($formData);
        //validate
        $validator = Validator::make($formData, $validation['rules'], $validation['messages']);
        if ($validator->fails()) {
            return response()->json($this->HelperServiceObject->constructResponseArray(400, 'failed', $validator->errors()->all(), 'validation_error'));
        } else {
            return $this->businessLogicServiceObject->preview($id);
        }
    }



    /**
     * Function to complete notice .
     * @param  \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */

    public function completed(Request $request)
    {
        $formData = $request->all();
        return $this->businessLogicServiceObject->completed($formData);
    }

    /**
     * Function to delete notice .
     * @param  \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */

    public function delete(Request $request)
    {
        $formData = $request->all();

        // get validation rules
        $validation = $this->validationRulesServiceObject->deleteRules($formData);
        //validate
        $validator = Validator::make($formData, $validation['rules'], $validation['messages']);
        if ($validator->fails()) {
            return response()->json($this->HelperServiceObject->constructResponseArray(400, 'failed', $validator->errors()->all(), 'validation_error'));
        } else {
            return $this->businessLogicServiceObject->delete($formData);
        }
    }

    /**
     * Function to get notice preview details.
     * @param Integer $id
     * @return \Illuminate\Http\Response
     */

    public function details($id)
    {   
        $formData['id'] = $id;        
        $validation = $this->validationRulesServiceObject->existsRules();
        //validate
        $validator = Validator::make($formData, $validation['rules'], $validation['messages']);
        if ($validator->fails()) {
            return response()->json($this->HelperServiceObject->constructResponseArray(400, 'failed', $validator->errors()->all(), 'validation_error'));
        } else {
            return $this->businessLogicServiceObject->details($formData);
        }
    }

    public function datacenterDetails(){
        return $this->businessLogicServiceObject->datacenterDetails();
    }

}
