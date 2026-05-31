<?php

namespace App\Services;

use App\Evaluators\BinaryEvaluator;
use App\Evaluators\NumberEvaluator;
use App\Evaluators\TextEvaluator;
use App\Evaluators\SingleChoiceEvaluator;
use App\Evaluators\MultipleChoiceEvaluator;

class EvaluatorFactory
{
    public static function make(
        string $type
    ) {

        return match($type) {

            'binary'
                => new BinaryEvaluator(),

            'number'
                => new NumberEvaluator(),

            'text'
                => new TextEvaluator(),

            'single_choice'
                => new SingleChoiceEvaluator(),

            'multiple_choice'
                => new MultipleChoiceEvaluator(),

            default =>
                throw new \Exception(
                    "Unknown type"
                )
        };
    }
}

