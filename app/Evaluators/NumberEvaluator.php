<?php

namespace App\Evaluators;

use App\Contracts\QuestionEvaluatorInterface;
use App\Models\Question;

class NumberEvaluator implements QuestionEvaluatorInterface
{
    public function evaluate(
        Question $question,
        mixed $answer
    ): int {

        return
            $answer ==
            $question->meta['correct_answer']
            ? $question->marks
            : 0;
    }
}