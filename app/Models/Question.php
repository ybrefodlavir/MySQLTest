<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;
    static $Types = ["insert", "update", "delete"];
    static $TypesSpecific = [
        "insert single",
        "insert single specific",
        "insert multiple",
        "insert multiple specific",
        "update all",
        "update specific",
        "delete all",
        "delete specific",
    ];

    static $Insert = "insert";
    static $Update = "update";
    static $Delete = "delete";

    static $InsertSingle = "insert single";
    static $InsertSingleSpecific = "insert single specific";
    static $InsertMultiple = "insert multiple";
    static $InsertMultipleSpecific = "insert multiple specific";

    static $UpdateAll = "update all";
    static $UpdateSpecific = "update specific";

    static $DeleteAll = "delete all";
    static $DeleteSpecific = "delete specific";


    static $Difficulties = ["easy", "medium", "hard"];
    static $Easy = "easy";
    static $Medium = "medium";
    static $Hard = "hard";


    protected $fillable = [
        "question",
        "type",
        "validation_statement",
        "validation_value",
        "difficulty",
        "is_exam",
        "is_active",
    ];
}
