<?php

namespace App\Http\Controllers\Api;

use App\ {
    Http\Controllers\Controller,
    Http\Requests\SearchRequest,
    Repositories\PostRepository,
    Models\Tag,
    Models\Category
};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class FrontPostController extends Controller
{
    /**
     * The PostRepository instance.
     *
     * @var \App\Repositories\PostRepository
     */
    protected $postRepository;

    /**
     * The pagination number.
     *
     * @var int
     */
    protected $nbrPages;

    /**
     * Create a new PostController instance.
     *
     * @param  \App\Repositories\PostRepository $postRepository
     * @return void
    */
    public function __construct(PostRepository $postRepository)
    {
        $this->postRepository = $postRepository;
        $this->nbrPages = config('app.nbrPages.front.posts');
    }

    /**
     * Display a listing of the posts.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = $this->postRepository->getActiveOrderByDate($this->nbrPages);
		return response()->json(['status' => true,'data' => $posts]);
        
    }

    /**
     * Display a listing of the posts for the specified category.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function category(Category $category)
    {
        $posts = $this->postRepository->getActiveOrderByDateForCategory($this->nbrPages, $category->slug);
        $info = __('Posts for category: ') . '<strong>' . $category->title . '</strong>';
		$ret['posts']=$posts;
		$ret['info']=$info;
		return response()->json(['status' => true,'data' => $ret]);
       
    }

    /**
     * Display the specified post by slug.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  string $slug
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $slug)
    {
        $user = $request->user();
		$ret=array_merge($this->postRepository->getPostBySlug($slug));
		return response()->json(['status' => true,'data' => $ret]);
        
    }

    /**
     * Get posts for specified tag
     *
     * @param  \App\Models\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function tag(Tag $tag)
    {
        $posts = $this->postRepository->getActiveOrderByDateForTag($this->nbrPages, $tag->id);
        $info = __('Posts found with tag ') . '<strong>' . $tag->tag . '</strong>';
		$ret['posts']=$posts;
		$ret['info']=$info;
		return response()->json(['status' => true,'data' => $ret]);
    }

    /**
     * Get posts with search
     *
     * @param  \App\Http\Requests\SearchRequest $request
     * @return \Illuminate\Http\Response
     */
    public function search(SearchRequest $request)
    {
		return 'dsgfdg';
        $search = $request->search;
        $posts = $this->postRepository->search($this->nbrPages, $search)->appends(compact('search'));
        $info = __('Posts found with search: ') . '<strong>' . $search . '</strong>';
		$ret['posts']=$posts;
		$ret['info']=$info;
		return response()->json(['status' => true,'data' => $ret]);
        
    }
	public function SearchItem(Request $request)
    {
		
         $search = Input::get('name');;
        $posts = $this->postRepository->search($this->nbrPages, $search);
        
		
		return response()->json(['status' => true,'data' => $posts]); 
        
    }
	
	public function allcategory(){
		$ret=$this->postRepository->AllCategory();
		return response()->json(['status' => true,'data' => $ret]);
	}
	
	public function alltag(){
		$ret=$this->postRepository->AllTag();
		return response()->json(['status' => true,'data' => $ret]);
	}
	public function getcategory($id){
		$ret=$this->postRepository->GetCategory($id);
		return response()->json(['status' => true,'data' => $ret]);
	}
	public function gettag($id){
		$ret=$this->postRepository->GetTag($id);
		return response()->json(['status' => true,'data' => $ret]);
	}
	
}
