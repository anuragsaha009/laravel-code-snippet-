<?php

namespace App\Services\NoticeManagementService;

class ValidationRulesService
{

    public function draftRules()
    {

        return [
            'rules' => [
                'title' => ['required', 'max:' . Config('SymphonyManagement.fieldSpecification.title.max_length')],
                'target_audience' => ['required'],
                'datacenter' => ['required'],
                'start_date' => ['required', 'date'],
                'end_date' => ['date', 'after:start_date'],
                'notice_details' => ['required'],
            ],
            'messages' => [
                'title.required' => 'validation.title_req',
                'title.max_length' => 'validation.title_max',
                'target_audience.required' => 'validation.target_audience_req',
                'datacenter.required' => 'validation.datacenter',
                'start_date.required' => 'validation.start_date_req',
                'notice_details.required' => 'validation.notice_details_req',
            ],
        ];
    }

    public function createRules()
    {

        return [
            'rules' => [
                'title' => ['required', 'max:' . Config('SymphonyManagement.fieldSpecification.title.max_length')],
                'target_audience' => ['required'],
                'datacenter' => ['required'],
                'start_date' => ['required', 'date'],
                'end_date' => ['date', 'after:start_date'],
                'notice_details' => ['required'],
            ],
            'messages' => [
                'title.required' => 'validation.title_req',
                'title.max_length' => 'validation.title_max',
                'target_audience.required' => 'validation.target_audience_req',
                'datacenter.required' => 'validation.datacenter',
                'start_date.required' => 'validation.start_date_req',
                'notice_details.required' => 'validation.notice_details_req',
            ],
        ];
    }

    public function updateRules()
    {

        return [
            'rules' => [
                'id' => ['bail', 'required', 'exists:notices,id'],
                'title' => ['required', 'max:' . Config('SymphonyManagement.fieldSpecification.title.max_length')],
                'target_audience' => ['required'],
                'datacenter' => ['required'],
                'start_date' => ['required', 'date'],
                'end_date' => ['date', 'after:start_date'],
                'notice_details' => ['required'],
            ],
            'messages' => [
                'id.required' => 'validation.invalid_reqest',
                'id.exists' => 'validation.invalid_reqest',
                'title.required' => 'validation.title_req',
                'title.max' => 'validation.title_max',
                'target_audience.required' => 'validation.target_audience_reg',
                'datacenter.required' => 'validation.datacenter',
                'start_date.required' => 'validation.start_date_req',
                'notice_details.required' => 'validation.notice_details_req',
            ],
        ];
    }

    public function deleteRules()
    {
        return [
            'rules' => [
                'id' => ['bail', 'required', 'exists:notices,id'],
            ],
            'messages' => [
                'id.required' => 'validation.invalid_request',
                'id.exists' => 'validation.invalid_request',
            ],
        ];
    }

    public function existsRules()
    {
        return [
            'rules' => [
                'id' => 'bail|required|exists:notices,id',
            ],
            'messages' => [
                'id.required' => 'validation.invalid_request',
                'id.exists' => 'validation.invalid_request',
            ],
        ];
    }
}
