<?php

namespace App\Repositories;
use DB;
use App\Models\ {
    Post,
    Tag,
    Comment,
	Category
};
use App\Services\Thumb;
use Auth;
class PostRepository
{
    /**
     * The Tag instance.
     *
     * @var \App\Models\Tag
     */
    protected $tag;

    /**
     * The Comment instance.
     *
     * @var \App\Models\Comment
     */
    protected $comment;

    /**
     * The Model instance.
     *
     * @var \Illuminate\Database\Eloquent\Model
     */
    protected $model;


    /**
     * Create a new BlogRepository instance.
     *
     * @param  \App\Models\Post $post
     * @param  \App\Models\Tag $tag
     * @param  \App\Models\Comment $comment
     */
    public function __construct(Post $post, Tag $tag, Comment $comment)
    {
        $this->model = $post;
        $this->tag = $tag;
        $this->comment = $comment;
		
    }

    /**
     * Create a query for Post.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function queryActiveOrderByDate()
    {
        return $this->model
            ->select('id', 'title', 'slug', 'excerpt', 'image')
            ->whereActive(true)
            ->latest();
    }

    /**
     * Get active posts collection paginated.
     *
     * @param  int  $nbrPages
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getActiveOrderByDate($nbrPages)
    {
        return $this->queryActiveOrderByDate()->paginate($nbrPages);
    }

    /**
     * Get all posts collection paginated.
     *
     * @param  int  $nbrPages
     * @param  array  $parameters
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getAll($nbrPages, $parameters)
    {
        return $this->model->with ('ingoing')
            ->orderBy ($parameters['order'], $parameters['direction'])
            ->when ($parameters['active'], function ($query) {
                $query->whereActive (true);
            })->when ($parameters['new'], function ($query) {
                $query->has ('ingoing');
            })->when (auth()->user()->role === 'redac', function ($query) {
                $query->whereHas('user', function ($query) {
                    $query->where('users.id', auth()->id());
                });
            })->paginate ($nbrPages);
    }

    /**
     * Get active posts for specified tag.
     *
     * @param  int  $nbrPages
     * @param  int  $tag_id
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getActiveOrderByDateForTag($nbrPages, $tag_id)
    {
        return $this->queryActiveOrderByDate()
            ->whereHas('tags', function ($q) use ($tag_id) {
                $q->where('tags.id', $tag_id);
            })->paginate($nbrPages);
    }

    /**
     * Get active posts for specified tag.
     *
     * @param  int  $nbrPages
     * @param  string  $category_slug
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getActiveOrderByDateForCategory($nbrPages, $category_slug)
    {
        return $this->queryActiveOrderByDate()
            ->whereHas('categories', function ($q) use ($category_slug) {
                $q->where('categories.slug', $category_slug);
            })->paginate($nbrPages);
    }

    /**
     * Get post by slug.
     *
     * @param  string  $slug
     * @return array
     */
    public function getPostBySlug($slug)
    {
        // Post for slug with user, tags and categories
        $post = $this->model->with([
            'user' => function ($q) {
                $q->select('id', 'name', 'email');
            },
            'tags' => function ($q) {
                $q->select('tags.id', 'tag');
            },
            'categories' => function ($q) {
                $q->select('title', 'slug');
            }
        ])
        ->with(['parentComments' => function ($q) {
            $q->with('user')
                ->latest()
                ->take(config('app.numberParentComments'));
        }])
        ->withCount('validComments')
        ->withCount('parentComments')
        ->whereSlug($slug)
        ->firstOrFail();

        // Previous post
        $post->previous = $this->getPreviousPost($post->id);

        // Next post
        $post->next = $this->getNextPost($post->id);

        return compact('post');
    }

	public function getPostById($id)
    {
        
		 $posts['post'] = DB::table('posts')->where('id',$id)->get(); 
         $posts['category'] = DB::table('posts')->where('posts.id',$id) 
					->leftJoin('category_post', 'posts.id', '=', 'category_post.post_id')
					->leftJoin('categories', 'category_post.category_id', '=', 'categories.id')
					->select('categories.*')
					->get(); 
        $posts['tags'] = DB::table('posts')->where('posts.id',$id) 
					->leftJoin('post_tag', 'posts.id', '=', 'post_tag.post_id')
					->leftJoin('tags', 'post_tag.tag_id', '=', 'tags.id')
					->select('tags.*')
					->get(); 
        

        

        return $posts;
    }

    /**
     * Get previous post
     *
     * @param  integer  $id
     * @return \Illuminate\Database\Eloquent\Collection
     */
    protected function getPreviousPost($id)
    {
        return $this->model->select('title', 'slug')->where('id', '<', $id)->latest('id')->first();
    }

    /**
     * Get next post
     *
     * @param  integer  $id
     * @return \Illuminate\Database\Eloquent\Collection
     */
    protected function getNextPost($id)
    {
        return $this->model->select('title', 'slug')->where('id', '>', $id)->oldest('id')->first();
    }

    /**
     * Get posts with search.
     *
     * @param  int  $n
     * @param  string  $search
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function search($n, $search)
    {
        return $this->queryActiveOrderByDate()
            ->where(function ($q) use ($search) {
                $q->where('excerpt', 'like', "%$search%")
                    ->orWhere('body', 'like', "%$search%")
                    ->orWhere('title', 'like', "%$search%");
            })->paginate($n);
    }

    /**
     * Update post.
     *
     * @param  \App\Models\Post  $post
     * @param  \App\Http\Requests\PostRequest  $request
     * @return void
     */
    public function update($post, $request)
    {
        $request->merge(['active' => $request->has('active')]);
		//var_dump($request->all());die();
        $post->update($request->all());

        $this->saveCategoriesAndTags($post, $request);
    }

    /**
     * Store post.
     *
     * @param  \App\Http\Requests\PostRequest  $request
     * @return void
     */
    public function store($request)
    {
        $request->merge(['user_id' => auth()->id()]);
        $request->merge(['active' => $request->has('active')]);

        $post = Post::create($request->all());

        $this->saveCategoriesAndTags($post, $request);
    }

    /**
     * Save categories and tags.
     *
     * @param  \App\Models\Post  $post
     * @param  \App\Http\Requests\PostRequest  $request
     * @return void
     */
    protected function saveCategoriesAndTags($post, $request)
    {
        $post->categories()->sync($request->categories);

        $tags_id = [];

        if ($request->tags) {
            $tags = explode(',', $request->tags);
            foreach ($tags as $tag) {
                $tag_ref = Tag::firstOrCreate(['tag' => $tag]);
                $tags_id[] = $tag_ref->id;
            }
        }

        $post->tags()->sync($tags_id);
    }
	public function AllCategory(){
		return Category::all()->sortBy("title");
	}
	public function AllTag(){
		return Tag::all()->sortBy("title");
	}
	public function GetCategory($id){
		return Category::findOrFail($id);;
	}
	public function GetTag($id){
		return Tag::findOrFail($id);
	}
	public function CanEdit($id){
		$user=Auth::user();
		$user_id=$user->id;
		return DB::table('posts')->where('id',$id)->where('user_id',$user_id)->first()?true:false;
		
	}
	
}
