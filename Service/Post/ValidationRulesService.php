<?php

namespace App\Service\Post;

class ValidationRulesService {

    public function createRules() {

        return [
            'rules' => [
                'title' => ['required','max:20'],
                'body' => ['required']
            ],
            'messages' => [
                'title.required' => 'The :attribute field is required.',
                'title.max' =>  'The :attribute must be exactly :max.',
                'body.required' => 'The :attribute field is required.',
            ]
        ];
    }

    public function existsRules() {
        return [
            'rules' => [
                'id' => ['exists:posts,id'],
            ],
            'messages' => [
                'id.exists' => 'invalid Request.',
            ]
        ];
    }

    public function updateRules() {

        return [
            'rules' => [
                'id' => ['exists:posts,id'],
                'title' => ['required','max:20'],
                'body' => ['required']
            ],
            'messages' => [
                'id.exists' => 'invalid Request.',
                'title.required' => 'The :attribute field is required.',
                'title.max' =>  'The :attribute must be exactly :max.',
                'body.required' => 'The :attribute field is required.',
            ]
        ];
    }

}
?>