<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\QuestionController;

Route::get('/', function () {
    return redirect()->route('quizzes.index');
});

Route::resource('quizzes', QuizController::class);

Route::get(
    '/quizzes/{quiz}/questions/create',
    [QuestionController::class, 'create']
)->name('questions.create');

Route::post(
    '/quizzes/{quiz}/questions',
    [QuestionController::class, 'store']
)->name('questions.store');

Route::get(
    '/quizzes/{quiz}/questions',
    [QuestionController::class, 'index']
)->name('questions.index');


Route::get(
    '/quizzes/{quiz}/attempt',
    [QuestionController::class, 'attempt']
)->name('quizzes.attempt');

Route::post(
    '/quizzes/{quiz}/submit',
    [QuestionController::class, 'submit']
)->name('quizzes.submit');

Route::get(
    '/attempts/{attempt}',
    [QuestionController::class, 'result']
)->name('attempts.result');


Route::get(
    '/questions/{question}/edit',
    [QuestionController::class,'edit']
)->name('questions.edit');

Route::put(
    '/questions/{question}',
    [QuestionController::class,'update']
)->name('questions.update');

Route::delete(
    '/questions/{question}',
    [QuestionController::class,'destroy']
)->name('questions.destroy');

