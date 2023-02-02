<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * @method static paginate(int $int)
 */
class Task extends Model
{
    use HasFactory;

    public static function create(array $data): bool
    {
        return DB::table('task')->insert($data);
    }

    public static function getStatus(int $status): string
    {
        switch ($status){
            case 0:
                return "New";
                break;
            case 1:
                return "In Progress";
                break;
            case 2:
                return "Finished";
                break;
            default:
                return "New";
        }
    }
}
