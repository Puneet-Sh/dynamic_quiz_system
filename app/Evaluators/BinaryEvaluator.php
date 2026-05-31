<?php

namespace App\Evaluators;

use App\Contracts\QuestionEvaluatorInterface;
use App\Models\Question;

class BinaryEvaluator implements QuestionEvaluatorInterface
{
    public function evaluate(
        Question $question,
        mixed $answer
    ): int {

        return
            (string)$answer ===
            (string)$question->meta['correct_answer']
            ? $question->marks
            : 0;
    }
}

