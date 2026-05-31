<?php

namespace App\Evaluators;

use App\Contracts\QuestionEvaluatorInterface;
use App\Models\Question;

class TextEvaluator implements QuestionEvaluatorInterface
{
    public function evaluate(
        Question $question,
        mixed $answer
    ): int {

        return
            strtolower(trim($answer))
            ==
            strtolower(
                trim(
                    $question->meta['correct_answer']
                )
            )
            ? $question->marks
            : 0;
    }
}

