<?php

namespace App\Livewire\Forms;

use App\Models\Student;
use Illuminate\Validation\Rule;
use Livewire\Form;

class UpdateStudentForm extends Form
{
    public ?Student $student;

    // Tambahkan '= null' agar tidak error "uninitialized"
    public ?string $identification_number = null;
    public ?string $name = null;
    public ?string $email = null;
    public ?string $phone_number = null;
    public ?string $gender = null;
    public ?string $school_class_id = null;
    public ?string $school_major_id = null;
    public ?string $school_year_start = null;
    public ?string $school_year_end = null;
    public $school_program_id = '';

    public function update(): void
    {
        $this->validate();

        $this->student->update([
            'name' => $this->name,
            'email' => $this->email,
            'phone_number' => $this->phone_number,
            'identification_number' => $this->identification_number,
            'gender' => $this->gender,
            'school_class_id' => $this->school_class_id,
            'school_major_id' => $this->school_major_id,
            'school_program_id' => $this->school_program_id,
            // Pastikan tahun juga ikut diupdate
            'school_year_start' => $this->school_year_start,
            'school_year_end' => $this->school_year_end,
        ]);
    }

    public function rules(): array
    {
        return [
            'school_class_id' => 'required|exists:school_classes,id',
            'school_major_id' => 'required|exists:school_majors,id',
            'identification_number' => [
                'required',
                'numeric',
                Rule::unique('students')->ignore($this->student),
            ],
            'name' => 'required|string|min:3|max:255',
            'phone_number' => [
                'required',
                'digits_between:8,15',
                Rule::unique('students')->ignore($this->student),
            ],
            'gender' => 'required|in:1,2',
            'school_year_start' => 'required|digits:4',
            'school_year_end' => 'required|digits:4',
        ];
    }

    public function messages(): array
    {
        return [
            'school_class_id.required' => 'Kelas tidak boleh kosong!',
            'school_major_id.required' => 'Jurusan tidak boleh kosong!',
            'identification_number.required' => 'Nomor identitas tidak boleh kosong!',
            'name.required' => 'Nama lengkap tidak boleh kosong!',
            'phone_number.required' => 'Nomor telepon tidak boleh kosong!',
            'gender.required' => 'Jenis kelamin tidak boleh kosong!',
            'school_year_start.required' => 'Tahun masuk tidak boleh kosong!',
            'school_year_end.required' => 'Tahun lulus tidak boleh kosong!',
        ];
    }
}
