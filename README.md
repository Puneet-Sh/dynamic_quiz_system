# Dynamic Quiz System

## Overview

Dynamic Quiz System is a Laravel 12 application that supports creation and evaluation of quizzes with multiple question types.

Supported Question Types:

* Binary (True/False)
* Single Choice
* Multiple Choice
* Number Input
* Text Input

Additional Features:

* Question images
* Question video URLs
* Option text
* Option images
* Automatic score calculation
* Quiz result screen

## Requirements

* PHP 8.2+
* Composer
* MySQL
* Laravel 12

## Installation

Clone repository:

git clone <repository-url>

Install dependencies:

composer install

Copy environment file:

cp .env.example .env

Configure database credentials in .env.

Generate application key:

php artisan key:generate

Run migrations:

php artisan migrate

Create storage symlink:

php artisan storage:link

Start server:

php artisan serve

Visit:

http://127.0.0.1:8000

## Project Structure

* Quiz Management
* Question Management
* Quiz Attempt System
* Evaluation Engine
* Result Screen
