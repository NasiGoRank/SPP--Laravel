<?php

namespace App\Livewire\Students;

use App\Livewire\Forms\UpdateStudentForm;
use App\Models\Student;
use Illuminate\Contracts\View\View;
use App\Models\SchoolClass;
use App\Models\SchoolMajor;
use App\Models\SchoolProgram;
use Livewire\Attributes\On;
use Livewire\Component;

class EditStudent extends Component
{
    public UpdateStudentForm $form;

    // Hapus properti public $schoolClasses dan $schoolMajors karena data dikirim via render()

    /**
     * Render the view.
     */
    public function render(): View
    {
        return view('livewire.students.edit-student', [
            // Samakan nama dengan yang ada di file blade (camelCase)
            'schoolClasses' => SchoolClass::all(),
            'schoolMajors' => SchoolMajor::all(),
            'schoolPrograms' => SchoolProgram::all(),
        ]);
    }

    /**
     * Set the specified model instance for the component.
     */
    #[On('student-edit')]
    public function setValue(Student $student): void
    {
        $this->form->student = $student;
        $this->form->fill($student);
        $this->form->phone_number = $student->phone_number;
    }

    /**
     * Update the form data and handle the related events.
     */
    public function edit(): void
    {
        $this->form->update();

        $this->dispatch('close-modal');
        $this->dispatch('success', message: 'Data berhasil diubah!');
        $this->dispatch('student-updated')->to(StudentTable::class);
    }
}
