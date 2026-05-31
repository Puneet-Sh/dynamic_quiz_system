<?php

namespace App\Evaluators;

use App\Contracts\QuestionEvaluatorInterface;
use App\Models\Question;

class MultipleChoiceEvaluator
implements QuestionEvaluatorInterface
{
    public function evaluate(
        Question $question,
        mixed $answer
    ): int {

        $correctIds =
            $question
                ->options()
                ->where(
                    'is_correct',
                    true
                )
                ->pluck('id')
                ->toArray();

        $userIds =
            $answer ?? [];

        sort($correctIds);
        sort($userIds);

        return
            $correctIds ==
            $userIds
            ? $question->marks
            : 0;
    }
}

