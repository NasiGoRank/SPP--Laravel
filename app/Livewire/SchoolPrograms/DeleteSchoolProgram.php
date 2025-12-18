<?php

namespace App\Livewire\SchoolPrograms;

use App\Models\SchoolProgram;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\On;
use Livewire\Component;

class DeleteSchoolProgram extends Component
{
    public SchoolProgram $schoolProgram;

    #[On('school-program-delete')]
    public function setValue(SchoolProgram $schoolProgram): void
    {
        $this->schoolProgram = $schoolProgram;
    }

    public function destroy(): void
    {
        $this->schoolProgram->delete();

        $this->dispatch('close-modal');
        $this->dispatch('success', message: 'Data program berhasil dihapus!');
        $this->dispatch('school-program-deleted')->to(SchoolProgramTable::class);
    }

    public function render(): View
    {
        return view('livewire.school-programs.delete-school-program');
    }
}
