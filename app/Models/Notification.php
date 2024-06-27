<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function scopeOwned($query): void
    {
        $query->where([
            ['to_id', auth()->user()->data->id],
            ['to_model', auth()->user()->role == 'student' ? \App\Models\Student::class : (auth()->user()->role == 'lecturer' ? \App\Models\Lecturer::class : \App\Models\Staff::class)]
        ]);
    }

    public function fromIdentify(): Attribute
    {
        return new Attribute(
            get: function () {
                if ($this->from_model == \App\Models\Lecturer::class)
                    return $this->lecturer;
                if ($this->from_model == \App\Models\Student::class)
                    return $this->student;
                if ($this->from_model == \App\Models\Staff::class)
                    return $this->staff;
            }
        );
    }

    public function lecturer()
    {
        return $this->belongsTo(Lecturer::class, 'from_id', 'id');
    }

    public function student()
    {
        return $this->belongsTo(Student::class, 'from_id', 'id');
    }

    public function staff()
    {
        return $this->belongsTo(Staff::class, 'from_id', 'id');
    }
}
