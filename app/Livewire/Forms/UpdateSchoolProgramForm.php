<?php

namespace App\Livewire\Forms;

use App\Models\SchoolProgram;
use Livewire\Attributes\Validate;
use Livewire\Form;

class UpdateSchoolProgramForm extends Form
{
    public ?SchoolProgram $schoolProgram;

    #[Validate('required|min:3|max:255')]
    public $name = '';

    #[Validate('required|numeric|min:0')]
    public $fee = '';

    public function setSchoolProgram(SchoolProgram $schoolProgram)
    {
        $this->schoolProgram = $schoolProgram;
        $this->name = $schoolProgram->name;
        $this->fee = $schoolProgram->fee;
    }

    public function update()
    {
        $this->validate();

        $this->schoolProgram->update([
            'name' => $this->name,
            'fee' => $this->fee,
        ]);
    }
}
