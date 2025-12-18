<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder;

class CashTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'amount',
        'date_paid',
        'transaction_note',
        'created_by',
        'proof_image',
    ];

    protected $casts = [
        'date_paid' => 'date',
    ];

    public function scopeSearch(Builder $query, $term)
    {
        $term = "%$term%";

        $query->where(function ($q) use ($term) {
            $q->whereHas('student', function ($studentQuery) use ($term) {
                $studentQuery->where('name', 'like', $term)
                    ->orWhere('identification_number', 'like', $term);
            })
                ->orWhere('transaction_note', 'like', $term);
        });
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // TAMBAHKAN INI: Eager load student dengan relasi
    public function getStudentWithRelationsAttribute()
    {
        return $this->student()->with(['schoolMajor', 'schoolClass'])->first();
    }
}
