<?php

use Livewire\Component;

use App\Models\User;

use Livewire\WithPaginatinon;

new class extends Component {


public function with(): array{
    return [
        'users' => User::paginate(10),
        'headers' => [
            ['key' => 'id','label'=>'ID'],
            ['key' => 'name','label'=>'Name'],
            ['key' => 'email','label'=>'Email'],
        ]
];
}



}; ?>
<div>
   <x-header title="Users" subtitle="Halaman pengguna aplikasi" separator>
    <x-slot:middle class="!justify-end">
        <x-input icon="o-bolt" placeholder="Search..." />
    </x-slot:middle>
    <x-slot:actions>
        {{-- <x-button icon="o-funnel" /> --}}
        {{-- <x-button icon="o-plus" class="btn-primary" @click="$wire.showModal()" /> --}}
    </x-slot:actions>
</x-header>
    <x-table :headers="$headers" :rows="$users" with-pagination striped @row-click="alert($event.detail.name)" />
</div>
