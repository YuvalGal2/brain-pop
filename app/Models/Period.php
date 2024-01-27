<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Period extends Model {
    public function teacher() {
        return $this->belongsTo(Teacher::class);
    }

    public function students() {
        return $this->belongsToMany(Student::class);
    }
}
