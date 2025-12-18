<?php

namespace App\Livewire\SchoolPrograms;

use App\Models\SchoolProgram;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Title('Daftar Program')]
class SchoolProgramTable extends Component
{
    use WithPagination;

    #[On('school-program-created')]
    #[On('school-program-updated')]
    #[On('school-program-deleted')]
    public function render(): View
    {
        return view('livewire.school-programs.school-program-table', [
            'programs' => SchoolProgram::latest()->paginate(10)
        ]);
    }
}
