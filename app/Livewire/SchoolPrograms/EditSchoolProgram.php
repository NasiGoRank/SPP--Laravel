<?php

namespace App\Livewire\SchoolPrograms;

use App\Livewire\Forms\UpdateSchoolProgramForm;
use App\Models\SchoolProgram;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\On;
use Livewire\Component;

class EditSchoolProgram extends Component
{
    public UpdateSchoolProgramForm $form;

    #[On('school-program-edit')]
    public function setValue(SchoolProgram $schoolProgram): void
    {
        $this->form->setSchoolProgram($schoolProgram);
    }

    public function edit(): void
    {
        $this->form->update();

        $this->dispatch('close-modal');
        $this->dispatch('success', message: 'Data program berhasil diubah!');
        $this->dispatch('school-program-updated')->to(SchoolProgramTable::class);
    }

    public function render(): View
    {
        return view('livewire.school-programs.edit-school-program');
    }
}
