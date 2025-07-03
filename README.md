# Filament Trivia Game

Welcome to **Trivia** by Hussam!  
This project is built with Laravel and Filament PHP.

## Features

- Filament PHP Dashboard for managing Quizzes and Reviewing Attempts
- Frontend to see available Quizzes (Blade)
- Attempting a Quiz (Livewire component)
- Reviewing score right after submitting (Blade)

## Requirements

- Docker

## Setup

> Run with Herd or follow instructions

1. **Clone the repository**
   ```sh
   git clone https://github.com/hussamitani/trivia.git
   cd your-repo
   cp .env.example .env
   ```
2. Install composer packages
   ```sh
   composer install --ignore-platform-reqs
   ```
3. Generate certificates using [mkcert](https://github.com/FiloSottile/mkcert) :
   If it's the first install of mkcert, run
   ```sh
   cd traefik
   mkcert -install
   ```
4. Generate local SSL keys
   ```sh
   cd traefik
   mkcert -cert-file certs/local-cert.pem -key-file certs/local-key.pem "trivia.docker.localhost"
   ```
5. Start Docker Container
   ```sh
   ./vendor/bin/sail up -d
   ```
6. Run migrations and seeder
   ```sh
   ./vendor/bin/sail artisan migrate:fresh --seed
   ```
7. Add domain to your hosts file (If you are on windows, do this manually)
   ```sh
   sudo echo '127.0.0.1 \t trivia.docker.localhost' >> /etc/hosts
   ```
8. Visit https://trivia.docker.localhost/login and login with the following credentials
   > test@example.com
   >
   > password
9. Try out the Quizzes.  
   Go to https://trivia.docker.localhost/quizzes and play any of the quizzes.

## Score calculation
I implemented the `final_score` calculation into the [CalculateAttemptPointsListener](app/Listeners/CalculateAttemptPointsListener.php).
The `getPointsForCorrectChoices` method calculates the points you made. The `getNegativePointsForWronglySelectedChoices` subtracts points for wrong choices, the `getMissedPointsForNotSelectedChoices` subtracts points for correct options you missed to select. You can play around with this class to manipulate scores. You don't have to submit attempts again. You can go to the Filament Dashboard and click **'Calculate'** to recalculate the final score.

The Listener does not implement the ShouldQueue interface. If you like, you can undo the comment. You need to run the queue worker for it to work with `./vendor/bin/sail artisan queue:work`.
```php
public function handle(QuizAttemptSubmitted $event): void
{
    $quiz = $event->attempt->quiz;
    $choices = $event->attempt->choices;

    $points = 0;
    foreach ($quiz->questions as $question) {
        $temp = 0;
        $questionChoice = $choices->where('question_id', $question->id)->first();
        $selectedOptions = $questionChoice->selected_options;
        $temp += $this->getPointsForCorrectChoices($question, $selectedOptions);
        $temp -= $this->getMissedPointsForNotSelectedChoices($question, $selectedOptions);
        $temp -= $this->getNegativePointsForWronglySelectedChoices($question, $selectedOptions);

        $points += max(0, $temp);
    }

    $event->attempt->update([
        'final_score' => max(0, $points),
    ]);
}

public function getPointsForCorrectChoices(mixed $question, array $selectedOptions): mixed
{
    return $question->options
        ->where('is_correct', true)
        ->whereIn('id', $selectedOptions)
        ->pluck('points')
        ->sum();
}

public function getMissedPointsForNotSelectedChoices(mixed $question, array $selectedOptions): mixed
{
    return $question->options
        ->where('is_correct', true)
        ->whereNotIn('id', $selectedOptions)
        ->pluck('points')
        ->sum();
}

private function getNegativePointsForWronglySelectedChoices(mixed $question, array $selectedOptions)
{
    return $question->options
        ->where('is_correct', false)
        ->whereIn('id', $selectedOptions)
        ->count();
}
```
If you fell like storing the score in the database is not necessary, you can implement an Attribute cast in the Attempt model.
But be aware that you quickly run into the N+1 problem when you fetch a list of attempts.

Good luck and have fun :)

Feel free to clone this repository and use for commercial/non-commercial use

For questions please contact me at bonn.software@gmail.com
