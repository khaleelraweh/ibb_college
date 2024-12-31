<?php

namespace App\Http\Livewire\Frontend\Blogs;

use App\Models\Event;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Support\Facades\Route;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;

class BlogListComponent extends Component
{
    use LivewireAlert;
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $paginationLimit = 4;

    public $slug;

    public $sortingBy = "default";
    public $searchQuery = '';

    // protected $queryString = ['searchQuery'];

    protected $queryString = [
        'searchQuery' => ['except' => ''] // Exclude from URL if empty
    ];


    // Define a property to store the route name
    public $currentRoute;

    public function __construct($id = null)
    {
        parent::__construct($id);
        // Set the current route name once in the constructor
        $this->currentRoute = Route::currentRouteName();
    }


    public function resetFilters()
    {
        $this->sortingBy = "default";
        $this->searchQuery = '';
    }

    public function render()
    {
        $tags = Tag::query()->whereStatus(1)->where('section', 3)->get();

        $sortField = match ($this->sortingBy) {
            'new' => 'created_at',
            'old' => 'created_at',
            default => 'id',
        };
        $sortType = $this->sortingBy === 'old' ? 'asc' : 'desc';

        $postsQuery = match ($this->currentRoute) {
            'frontend.blog_list' => Post::with('photos')->Blog(),
            'frontend.news_list' => Post::with('photos')->News(),
            'frontend.events_list' => Event::with('photos'),
            default => abort(404),
        };

        $posts = $postsQuery
            ->when($this->searchQuery, fn($query) => $query->where('title', 'LIKE', '%' . $this->searchQuery . '%'))
            ->active()
            ->orderBy($sortField, $sortType)
            ->paginate($this->paginationLimit);

        $totalPosts = $postsQuery->count();
        $recentPosts = $postsQuery->orderBy('created_at', 'DESC')->take(3)->get();

        return view('livewire.frontend.blogs.blog-list-component', [
            'posts' => $posts,
            'total_Posts' => $totalPosts,
            'recent_posts' => $recentPosts,
            'tags' => $tags,
        ]);
    }





    public function updatingSortingBy()
    {
        $this->resetPage(); // Reset pagination when sorting changes
    }
}
