<?php

namespace App\Service\Post;
use App\Post;

class BusinessLogicService 
{

    public function list() 
    {
        $posts = Post::all();
        return $posts;        
    }

    // return $post
    public function create( $formData ) 
    { 
        $formData['image']->store('logos');
       // $post = Post::create( $formData );
       // return $post;
    } 
    
    public function updateInit(  $formData ) 
    {
        $post = Post::find( $formData['id']);
        return $post; 
    }

    public function update($formData) 
    {
        $post = Post::find( $formData['id']);
        unset( $formData['id']);
        $post->update($formData);
    }

}
?>