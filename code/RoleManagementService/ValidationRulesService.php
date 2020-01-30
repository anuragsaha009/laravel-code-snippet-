<?php

namespace App\Services\RoleManagementService;

use Illuminate\Validation\Rule;

class ValidationRulesService
{
    public function createRules()
    {

        return [
            'rules' => [
                'role_name' => 'required|max:' . Config('SymphonyManagement.fieldSpecification.role_name.max_length') . '|unique:roles,role_name',
            ],
            'messages' => [
                'role_name.required' => 'validation.role_req',
                'role_name.max' => 'role.max',
                'role_name.unique' => 'validation.role_already_exists',
            ],
        ];
    }

    public function getDetailsRules()
    {

        return [
            'rules' => [
                'role' => 'required|exists:App\Models\Role,role_name',
            ],
            'messages' => [
                'role.required' => 'validation.role_req',
                'role.exists' => 'validation.role_already_exists',
            ],
        ];
    }

    public function getExistsRules()
    {

        return [
            'rules' => [
                'role_name' => 'required|unique:roles,role_name',
            ],
            'messages' => [
                'role_name.required' => 'validation.role_req',
                'role_name.exists' => 'validation.role_already_exists',
            ],
        ];
    }

    public function updateRules($formData)
    {

        return [
            'rules' => [
                'id' => 'bail|required|exists:roles,id',
                'role_name' => ['required',
                    'max:' . Config('SymphonyManagement.fieldSpecification.role_name.max_length'),
                    Rule::unique("roles", "role_name")->ignore($formData["id"])],
            ],
            'messages' => [
                'id,required' => 'Invalid Reqest',
                'id.exists' => 'Invalid Reqest',
                'role_name.required' => 'validation.role_req',
                'role_name.max' => 'role.max',
                'role_name.unique' => 'validation.role_already_exists',
            ],
        ];
    }
}
