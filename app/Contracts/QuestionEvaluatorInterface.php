<?php

namespace App\Contracts;

use App\Models\Question;

interface QuestionEvaluatorInterface
{
    public function evaluate(
        Question $question,
        mixed $answer
    ): int;
}

