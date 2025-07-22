<?php

declare(strict_types=1);

namespace App\Livewire\Home;

use App\Livewire\Concerns\HasLoadMore;
use App\Models\Question;
use App\Queries\Feeds\RecentQuestionsFeed;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\View\View;
use Livewire\Attributes\On;
use Livewire\Component;

class Feed extends Component
{
    use HasLoadMore;

    /**
     * @var string|null
     * The hashtag name that the queried questions should relate to.
     */
    public ?string $hashtag = null;

    /**
     * @throws AuthorizationException
     */
    #[On('question.ignore')]
    public function ignore(string $questionId): void
    {
        $question = Question::findOrFail($questionId);
        $this->authorize('ignore',$question);

        $question->update(['is_ignored'=>true]);
        $this->dispatch('question.ignored');
    }

    #[On('question.create')]
    public function refresh(): void
    {
    }

    public function render(): View
    {
        $questions = new RecentQuestionsFeed($this->hashtag)
            ->builder()
            ->simplePaginate($this->perPage);

        return view('livewire.feed',[
            'questions'=>$questions
        ]);
    }
}
