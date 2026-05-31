<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\Question;
use App\Models\Option;
use Illuminate\Http\Request;
use App\Models\Attempt;
use App\Models\Answer;
use App\Services\EvaluatorFactory;
use Illuminate\Support\Facades\Storage;


class QuestionController extends Controller
{
    public function index(Quiz $quiz)
    {
        $questions = $quiz
            ->questions()
            ->with('options')
            ->latest()
            ->get();

        return view(
            'questions.index',
            compact('quiz', 'questions')
        );
    }

    public function create(Quiz $quiz)
    {
        return view(
            'questions.create',
            compact('quiz')
        );
    }

    // public function store(
    //     Request $request,
    //     Quiz $quiz
    // ) {

    //     $request->validate([
    //         'type' => 'required',
    //         'question_text' => 'required',
    //         'marks' => 'required|integer|min:1',
    //         'image' => 'nullable|image',
    //         'video_url' => 'nullable|string',
    //     ]);

    //     $imagePath = null;

    //     if (
    //         isset(
    //             $request->file('option_images')[$index]
    //         )
    //     ) {

    //         $imagePath =
    //             $request
    //                 ->file('option_images')[$index]
    //                 ->store(
    //                     'questions',
    //                     'public'
    //                 );
    //     }

    //     // if ($request->hasFile('image')) {
    //     //     $imagePath = $request
    //     //         ->file('image')
    //     //         ->store(
    //     //             'questions',
    //     //             'public'
    //     //         );
    //     // }

    //     $meta = [];

    //     if (
    //         in_array(
    //             $request->type,
    //             ['binary', 'number', 'text']
    //         )
    //     ) {
    //         $meta = [
    //             'correct_answer' =>
    //                 $request->correct_answer
    //         ];
    //     }

    //     $question = Question::create([
    //         'quiz_id' => $quiz->id,
    //         'type' => $request->type,
    //         'question_text' => $request->question_text,
    //         'image_path' => $imagePath,
    //         'video_url' => $request->video_url,
    //         'marks' => $request->marks,
    //         'meta' => $meta,
    //     ]);

    //     if (
    //         in_array(
    //             $request->type,
    //             [
    //                 'single_choice',
    //                 'multiple_choice'
    //             ]
    //         )
    //     ) {

    //         foreach (
    //             $request->options as $index => $optionText
    //         ) {

    //             $isCorrect = false;

    //             if (
    //                 $request->type === 'single_choice'
    //             ) {
    //                 $isCorrect =
    //                     $request->correct_option ==
    //                     $index;
    //             }

    //             if (
    //                 $request->type === 'multiple_choice'
    //             ) {
    //                 $isCorrect =
    //                     in_array(
    //                         $index,
    //                         $request->correct_options ?? []
    //                     );
    //             }

    //             Option::create([
    //                 'question_id' => $question->id,
    //                 'option_text' => $optionText,
    //                 'is_correct' => $isCorrect,
    //             ]);
    //         }
    //     }

    //     return redirect()
    //         ->route(
    //             'questions.index',
    //             $quiz
    //         )
    //         ->with(
    //             'success',
    //             'Question created successfully.'
    //         );
    // }

    public function store(
    Request $request,
    Quiz $quiz
) { 
    // dd($request->all());

    $request->validate([
        'type' => 'required',
        'question_text' => 'required',
        'marks' => 'required|integer|min:1',
        'image' => 'nullable|image',
        'video_url' => 'nullable|string',

        'option_images.*' => 'nullable|image',
    ]);

    /*
    |--------------------------------------------------------------------------
    | Upload Question Image
    |--------------------------------------------------------------------------
    */
    $imagePath = null;

    if ($request->hasFile('image')) {

        $imagePath = $request
            ->file('image')
            ->store(
                'questions',
                'public'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | Meta Data For Binary / Number / Text
    |--------------------------------------------------------------------------
    */
    $meta = [];

    if (
        in_array(
            $request->type,
            ['binary', 'number', 'text']
        )
    ) {

        $meta = [
            'correct_answer' =>
                $request->correct_answer
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Create Question
    |--------------------------------------------------------------------------
    */

    // dd([
    //     'has_image' => $request->hasFile('image'),
    //     'uploaded_image' => $request->file('image'),
    //     'video_url' => $request->video_url,
    //     'image_path' => $imagePath,
    // ]);

    $question = Question::create([
        'quiz_id' => $quiz->id,
        'type' => $request->type,
        'question_text' => $request->question_text,
        'image_path' => $imagePath,
        'video_url' => $request->video_url,
        'marks' => $request->marks,
        'meta' => $meta,
    ]);

    /*
    |--------------------------------------------------------------------------
    | Save Options
    |--------------------------------------------------------------------------
    */
    if (
        in_array(
            $request->type,
            [
                'single_choice',
                'multiple_choice'
            ]
        )
    ) {

        foreach (
            $request->options as $index => $optionText
        ) {

            $optionImagePath = null;

            if (
                isset(
                    $request->file('option_images')[$index]
                )
            ) {

                $optionImagePath =
                    $request
                        ->file('option_images')[$index]
                        ->store(
                            'options',
                            'public'
                        );
            }

            $isCorrect = false;

            if (
                $request->type === 'single_choice'
            ) {

                $isCorrect =
                    $request->correct_option ==
                    $index;
            }

            if (
                $request->type === 'multiple_choice'
            ) {

                $isCorrect =
                    in_array(
                        $index,
                        $request->correct_options ?? []
                    );
            }

            Option::create([
                'question_id' => $question->id,
                'option_text' => $optionText,
                'image_path' => $optionImagePath,
                'is_correct' => $isCorrect,
            ]);
        }
    }

    return redirect()
        ->route(
            'questions.index',
            $quiz
        )
        ->with(
            'success',
            'Question created successfully.'
        );
}

    public function attempt(Quiz $quiz)
    {
        $questions = $quiz
            ->questions()
            ->with('options')
            ->get();

        return view(
            'questions.attempt',
            compact('quiz', 'questions')
        );
    }

    public function submit(
    Request $request,
    Quiz $quiz
) {

    $questions = $quiz
        ->questions()
        ->with('options')
        ->get();

    $totalMarks = 0;
    $score = 0;

    $attempt = Attempt::create([
        'quiz_id' => $quiz->id,
        'score' => 0,
        'total_marks' => 0
    ]);

    foreach ($questions as $question) {

        $totalMarks += $question->marks;

        $answer =
            $request->input(
                'answers.' . $question->id
            );

        Answer::create([
            'attempt_id' => $attempt->id,
            'question_id' => $question->id,
            'answer' => $answer
        ]);

        $evaluator =
            EvaluatorFactory::make(
                $question->type
            );

        $score +=
            $evaluator->evaluate(
                $question,
                $answer
            );
    }

    $attempt->update([
        'score' => $score,
        'total_marks' => $totalMarks
    ]);

    return redirect()->route(
        'attempts.result',
        $attempt
    );
}

public function result(
    Attempt $attempt
)
{
    return view(
        'questions.result',
        compact('attempt')
    );
}



public function destroy(
    Question $question
)
{
    $quiz = $question->quiz;

    // Delete question image
    if ($question->image_path) {

        Storage::disk('public')->delete(
            $question->image_path
        );
    }

    // Delete option images
    foreach ($question->options as $option) {

        if ($option->image_path) {

            Storage::disk('public')->delete(
                $option->image_path
            );
        }
    }

    $question->delete();

    return redirect()
        ->route(
            'questions.index',
            $quiz
        )
        ->with(
            'success',
            'Question deleted successfully.'
        );
}

public function edit(
    Question $question
)
{
    $question->load('options');

    return view(
        'questions.edit',
        compact('question')
    );
}

public function update(
    Request $request,
    Question $question
)
{
    $question->update([
        'question_text' =>
            $request->question_text,

        'marks' =>
            $request->marks,

        'video_url' =>
            $request->video_url,
    ]);

    return redirect()
        ->route(
            'questions.index',
            $question->quiz
        );
}



}