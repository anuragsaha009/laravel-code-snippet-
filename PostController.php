<?php

namespace App\Http\Controllers;

use App\Service\Post\BusinessLogicService;
use App\Service\Post\ValidationRulesService;
use Illuminate\Http\Request;
use App\Events\PostEvent;
use Validator;

class PostController extends Controller
{
    protected $validationRulesObj;
    protected $businessLogicServiceObj;

    public function __construct()
    {
        $this->validationRulesObj = new ValidationRulesService();
        $this->businessLogicServiceObj = new BusinessLogicService();
    }

    function list() {
        $posts = $this->businessLogicServiceObj->list();
        return view('post.list', ['posts' => $posts]);
    }

    public function createInit()
    {
        return view('post.create');
    }

    public function create(Request $request)
    {
        $formData = $request->all();


        $validation = $this->validationRulesObj->createRules();
        $validator = Validator::make($formData, $validation['rules'], $validation['messages']);

        if ($validator->fails()) {
            return redirect(route('createInit_GET'))->withErrors($validator)->withInput();
        } else {
            $formData['image'] =  $request->image;
            $image_name = $request->image->store('posts','public');
            dd($image_name);
            $response = $this->businessLogicServiceObj->create($formData);
            event(new PostEvent($response));
        }
    }

    public function updateInit($id) {

        $formData['id'] = $id;
        $validation = $this->validationRulesObj->existsRules();
        $validator = Validator::make($formData, $validation['rules'], $validation['messages']);
        if ($validator->fails()) {
            return redirect(route('listPost_GET'))->withErrors($validator)->withInput();
        } else {
            $post = $this->businessLogicServiceObj->updateInit($formData);
            return view('post.edit', ['post' => $post]);
        } 

    }

    public function update(Request $request, $id) {

        $formData = $request->all();
        $formData['id'] = $id;

        $validation = $this->validationRulesObj->updateRules();        
        $validator = Validator::make($formData, $validation['rules'], $validation['messages']);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        } else {
            $response = $this->businessLogicServiceObj->update($formData);
        } 
    }
}
