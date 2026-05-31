<?php

namespace App\Evaluators;

use App\Contracts\QuestionEvaluatorInterface;
use App\Models\Question;

class SingleChoiceEvaluator implements QuestionEvaluatorInterface
{
    public function evaluate(
        Question $question,
        mixed $answer
    ): int {

        $correctOption =
            $question
                ->options()
                ->where(
                    'is_correct',
                    true
                )
                ->first();

        if (!$correctOption) {
            return 0;
        }

        return
            $correctOption->id ==
            $answer
            ? $question->marks
            : 0;
    }
}

