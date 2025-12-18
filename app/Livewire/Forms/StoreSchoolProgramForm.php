<?php

namespace App\Livewire\Forms;

use App\Models\SchoolProgram;
use Livewire\Attributes\Validate;
use Livewire\Form;

class StoreSchoolProgramForm extends Form
{
    #[Validate('required|min:3|max:255')]
    public $name = '';

    #[Validate('required|numeric|min:0')]
    public $fee = '';

    public function store()
    {
        $this->validate();

        SchoolProgram::create([
            'name' => $this->name,
            'fee' => $this->fee,
        ]);

        $this->reset();
    }
}
