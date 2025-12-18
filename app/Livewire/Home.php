<?php

namespace App\Livewire;

use App\Models\SchoolMajor;
use App\Models\SchoolProgram;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\Attributes\Title;

#[Title('Home')]
#[Layout('components.layouts.authentication.app')]
class Home extends Component
{
    public function render()
    {
        return view('livewire.home', [
            'majors' => SchoolMajor::all(),
            'programs' => SchoolProgram::all(),
        ]);
    }
}
