<?php

namespace App\Services;

use App\Models\Quiz;
use App\Models\Attempt;
use App\Models\Answer;

class QuizEvaluationService
{
    public function evaluate(
        Quiz $quiz,
        Attempt $attempt,
        array $answers
    ): array {

        $score = 0;
        $totalMarks = 0;

        $questions = $quiz
            ->questions()
            ->with('options')
            ->get();

        foreach ($questions as $question) {

            $totalMarks += $question->marks;

            $userAnswer =
                $answers[$question->id] ?? null;

            Answer::create([
                'attempt_id' => $attempt->id,
                'question_id' => $question->id,
                'answer' => $userAnswer,
            ]);

            $evaluator =
                EvaluatorFactory::make(
                    $question->type
                );

            $score +=
                $evaluator->evaluate(
                    $question,
                    $userAnswer
                );
        }

        return [
            'score' => $score,
            'total_marks' => $totalMarks,
        ];
    }
}

