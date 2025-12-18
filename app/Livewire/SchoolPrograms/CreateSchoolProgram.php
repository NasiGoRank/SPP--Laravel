<?php

namespace App\Livewire\SchoolPrograms;

use App\Livewire\Forms\StoreSchoolProgramForm;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class CreateSchoolProgram extends Component
{
    public StoreSchoolProgramForm $form;

    public function save(): void
    {
        $this->form->store();

        $this->dispatch('close-modal');
        $this->dispatch('success', message: 'Data program berhasil ditambahkan!');
        $this->dispatch('school-program-created')->to(SchoolProgramTable::class);
    }

    public function render(): View
    {
        return view('livewire.school-programs.create-school-program');
    }
}
