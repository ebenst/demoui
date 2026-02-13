<?php

use Livewire\Component;

use App\Models\Posts;
use Livewire\WithPagination;
use App\Livewire\Forms\PostForm;


new class extends Component
{


    use WithPagination;

public PostForm $form;

public bool $displayPostModal = false;
public bool $editMode = false;

public function showModal(){
    $this->form->reset();
    $this->editMode = false;
    $this->displayPostModal = true;
}

public function closeModal(){
    $this->form->reset();
    $this->displayPostModal = false;
}

public function edit($id){
    $post = Posts::find($id);
    $this->form->setPost($post);
    $this->editMode = true;
    $this->displayPostModal = true;
}

public function delete($id){
    Posts::find($id)->delete();
}

public function save(){
    if ($this->editMode){
        $this->form->update();
    }else{
        $this->form->store();
    }

    $this->displayPostModal = false;

    $this->resetPage();
}

public function with(): array{
    return [
        'posts' => Posts::paginate(5),
        'headers' => [
                      ["key"=>"id","label"=>"#",'class' => 'bg-error/20 w-1'],
                    ["key"=>"title","label"=>"Title"],
                    ["key"=>"slug","label"=>"Slug"]
        ]
];
}


    //
    // public function render(){
    //     $headers = [
    //         ["key"=>"id","label"=>"#"],
    //         ["key"=>"title","label"=>"Title"],
    //         ["key"=>"slug","label"=>"Slug"],
    //         ["key"=>id,"label"=>"#"],
    // ];
    // }
};
?>

<div>
    <x-header title="Post" subtitle="This is responsive" separator>
    <x-slot:middle class="!justify-end">
        <x-input icon="o-bolt" placeholder="Search..." />
    </x-slot:middle>
    <x-slot:actions>
        {{-- <x-button icon="o-funnel" /> --}}
        <x-button icon="o-plus" class="btn-primary" @click="$wire.showModal()" />
    </x-slot:actions>
</x-header>
 <x-table :headers="$headers" :rows="$posts" with-pagination striped @row-click="$wire.edit($event.detail.id)">
    @scope('header_title',$header)
    <h2 class="text-xl font-bold text-orange-700">{{ $header['label'] }}</h2>
    @endscope

    @scope('header_slug',$header)
    <h2 class="text-xl font-bold text-orange-700">{{ $header['label'] }}</h2>
    @endscope

     @scope('actions', $posts)
        <x-button icon="o-trash" wire:click.stop="delete({{ $posts->id }})" spinner class="btn-sm btn-error" />
    @endscope
 </x-table>

 <x-modal wire:model="displayPostModal" title="" class="backdrop-blur">
    <x-form wire:submit="save">
    <x-input label="Title" wire:model="form.title" />
    <x-input label="Slug" wire:model="form.slug" />
        <x-textarea label="Content" wire:model="form.content" placeholder="Here ..." hint="Max 1000 chars" rows="5" />

    <x-slot:actions>
        <x-button label="Cancel" @click="$wire.closeModal()"/>
        <x-button label="Save!" class="btn-primary" type="submit" spinner="save" />
    </x-slot:actions>
</x-form>
</x-modal>

</div>
