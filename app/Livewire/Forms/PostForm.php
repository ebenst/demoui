<?php

namespace App\Livewire\Forms;

use App\Models\Posts;
use Livewire\Attributes\Validate;
use Livewire\Form;

class PostForm extends Form
{



    public ?Posts $post;

    //
    #[Validate('string','required')]
    public $title;
    #[Validate('string','required')]
    public $slug;
    #[Validate('string','required')]
    public $content;

    public function setPost(Posts $post){
        $this->post = $post;
        $this->title = $post->title;
        $this->slug = $post->slug;
        $this->content = $post->content;

    }

    public function store(){
        $this->validate();

        Posts::create([
            'title' => $this->title,
            'slug' => $this->slug,
            'content' => $this->content,
        ]);


        $this->reset();
    }


    public function update(){
        $this->validate();

        $this->post->update([
            'title' => $this->title,
            'slug' => $this->slug,
            'content' => $this->content,
        ]);


        $this->reset();
    }

}
