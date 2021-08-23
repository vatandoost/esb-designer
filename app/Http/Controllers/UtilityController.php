<?php

namespace App\Http\Controllers;

use App\Statics\ExpressionFunctions;
use App\Statics\FieldType;
use App\Statics\Operators;

class UtilityController extends Controller
{
    public function condition_builder_setting()
    {
        return [
            'operators' => Operators::labels(),
            'types' => FieldType::labels(),
            'type_operators' => FieldType::operators(),
            "valid_functions" => ExpressionFunctions::list()
        ];
    }
}
