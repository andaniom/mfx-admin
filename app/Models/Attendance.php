<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'check_in', 'check_out', 'user_id',
    ];

    public static function minutesToHourString(int $minutes): string
    {
        $hours = floor($minutes / 60);
        $minutes = $minutes % 60;
        return "$hours hours  $minutes minutes";
    }
}
