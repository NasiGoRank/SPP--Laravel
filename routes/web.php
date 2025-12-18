<?php

use App\Livewire\Administrators\AdministratorTable;
use App\Livewire\Authentication\Login;
use App\Livewire\Authentication\Logout;
use App\Livewire\CashTransactions\CashTransactionCurrentWeekTable;
use App\Livewire\CashTransactions\FilterCashTransaction;
use App\Livewire\Dashboard;
use App\Livewire\SchoolClasses\SchoolClassTable;
use App\Livewire\SchoolMajors\SchoolMajorTable;
use App\Livewire\Students\StudentTable;
use App\Livewire\UpdateProfile;
use Illuminate\Support\Facades\Route;
use App\Livewire\SchoolPrograms\SchoolProgramTable;
use App\Livewire\SchoolPrograms\CreateSchoolProgram;
use App\Livewire\SchoolPrograms\EditSchoolProgram;
use App\Livewire\SchoolPrograms\DeleteSchoolProgram;
use App\Livewire\Home;

Route::middleware('guest')->group(function () {
    Route::get('/', Home::class)->name('home');

    Route::get('/login', Login::class)->name('login');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', Logout::class)->name('logout');

    Route::get('/dashboard', Dashboard::class)->name('dashboard');
    Route::get('/kelas', SchoolClassTable::class)->name('school-classes.index');
    Route::get('/jurusan', SchoolMajorTable::class)->name('school-majors.index');
    Route::get('/pengguna', AdministratorTable::class)->name('administrators.index');
    Route::get('/profil', UpdateProfile::class)->name('update-profiles.index');
    Route::get('/pelajar', StudentTable::class)->name('students.index');

    Route::get('/spp', CashTransactionCurrentWeekTable::class)->name('cash-transactions.index');
    Route::get('/spp/filter', FilterCashTransaction::class)->name('cash-transactions.filter');
    Route::get('/school-programs', SchoolProgramTable::class)->name('school-programs.index');
    Route::get('/school-programs/create', CreateSchoolProgram::class)->name('school-programs.create');
    Route::get('/school-programs/{schoolProgram}/edit', EditSchoolProgram::class)->name('school-programs.edit');
    Route::get('/school-programs/{schoolProgram}/delete', DeleteSchoolProgram::class)->name('school-programs.delete');
});
