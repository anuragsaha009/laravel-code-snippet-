<?php

namespace App\Services\RoleManagementService;

use App\Models\Role;
use App\Models\Privilege;
use App\Services\HelperService;

class BusinessLogicService
{    
    
    public function __construct()
    {
        $this->HelperServiceObject = new HelperService();
    }

    public function list()
    {
        $rolesList = Role::get();
        // return response
        return response()->json($this->HelperServiceObject->constructResponseArray(200, 'success', 'fetch successful', '', $rolesList));
    }

    public function create($formData)
    {
        // create role
        $newRole = new Role;
        $newRole->role_name = $formData['role_name'];
        $newRole->save();
        if(isset($formData['view_operator']) && $formData['view_operator'] == 'true') {
            $privilege = Privilege::where('privilege', 'showOperators')->first();
            $newRole->Privileges()->attach($privilege->id);
        }
        if(isset($formData['manage_operator']) && $formData['manage_operator'] == 'true') {
            $privilege = Privilege::where('privilege', 'createOperator')->first();
            $newRole->Privileges()->attach($privilege->id);
            $privilege = Privilege::where('privilege', 'updateOperator')->first();
            $newRole->Privileges()->attach($privilege->id);
            $privilege = Privilege::where('privilege', 'deleteOperator')->first();
            $newRole->Privileges()->attach($privilege->id);
        }
        if(isset($formData['view_role']) && $formData['view_role'] == 'true') {
            $privilege = Privilege::where('privilege', 'listRoles')->first();
            $newRole->Privileges()->attach($privilege->id);
        }
        if(isset($formData['manage_role']) && $formData['manage_role'] == 'true') {
            $privilege = Privilege::where('privilege', 'createRole')->first();
            $newRole->Privileges()->attach($privilege->id);
            $privilege = Privilege::where('privilege', 'updateRole')->first();
            $newRole->Privileges()->attach($privilege->id);
        }
        // return response
        return response()->json($this->HelperServiceObject->constructResponseArray(200, 'success', 'role.role_creation_successfull', 'flash'));
    }

    public function show($id)
    {
        // Get roles and privileges
        $role = Role::find($id);
        $roleDetails['role'] = $role->toArray();
        $roleDetails['privilege'] = $role->Privileges()->get()->toArray();
        $roleDetails['privilege'] = array_column($roleDetails['privilege'], 'privilege');
        // return response
        return response()->json($this->HelperServiceObject->constructResponseArray(200, 'success', 'fetch successful', '', $roleDetails));
    }

    public function update($formData)
    {
        $role = Role::find($formData['id']);
        $role->role_name = $formData['role_name'];
        $role->save();
        $role->Privileges()->detach();
        if(isset($formData['view_operator']) && $formData['view_operator'] == 'true') {
            $privilege = Privilege::where('privilege', 'showOperators')->first();
            $role->Privileges()->attach($privilege->id);
        }
        if(isset($formData['manage_operator']) && $formData['manage_operator'] == 'true') {
            $privilege = Privilege::where('privilege', 'createOperator')->first();
            $role->Privileges()->attach($privilege->id);
            $privilege = Privilege::where('privilege', 'updateOperator')->first();
            $role->Privileges()->attach($privilege->id);
            $privilege = Privilege::where('privilege', 'deleteOperator')->first();
            $role->Privileges()->attach($privilege->id);
        }
        if(isset($formData['view_role']) && $formData['view_role'] == 'true') {
            $privilege = Privilege::where('privilege', 'listRoles')->first();
            $role->Privileges()->attach($privilege->id);
        }
        if(isset($formData['manage_role']) && $formData['manage_role'] == 'true') {
            $privilege = Privilege::where('privilege', 'createRole')->first();
            $role->Privileges()->attach($privilege->id);
            $privilege = Privilege::where('privilege', 'updateRole')->first();
            $role->Privileges()->attach($privilege->id);
        }
        // return response
        return response()->json($this->HelperServiceObject->constructResponseArray(200, 'success', 'role.role_updation_successfull', ''));
    }

    public function duplicateOperatorRoleCheck($formData) {
        //$role = Role::where('role_name',$formData['role_name'])->first();
        $responseArray = $this->HelperServiceObject->constructResponseArray(200, 'success', $formData['role_name'], 'flash');
        return response()->json($responseArray);          
    }
}
