<?php

namespace App\Http\Controllers\Api;

use App\ {
    Http\Requests\PostRequest,
    Http\Controllers\Controller,
    Models\Category,
    Models\Post,
    Repositories\PostRepository,
	location,
	image,
	post_meta
	
};
use Illuminate\Http\Request;
use JWTAuth;
use Auth;

use Illuminate\Support\Facades\Input;
use Tymon\JWTAuthExceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
class AddsController extends Controller
{
    //use Indexable;

    /**
     * Create a new PostController instance.
     *
     * @param  \App\Repositories\PostRepository $repository
     */
    public function __construct(PostRepository $repository)
    {
		$this->middleware('jwt.auth', ['except' => ['authenticate']]);
        $this->repository = $repository;
		//$this->user = JWTAuth::parseToken()->authenticate();
        $this->table = 'posts';
    }

    /**
     * Update "new" field for post.
     *
     * @param  \App\Models\Post $post
     * @return \Illuminate\Http\Response
     */
    public function updateSeen(Post $post)
    {
        $post->ingoing->delete ();

        return response ()->json ();
    }
	public function index()
    {
        

        return 'i m working';
    }

    /**
     * Update "active" field for post.
     *
     * @param  \App\Models\Post $post
     * @param  bool $status
     * @return \Illuminate\Http\Response
     */
    public function updateActive(Post $post, $status = false)
    {
        $post->active = $status;
        $post->save();

        return response ()->json ();
    }

    /**
     * Show the form for creating a new post.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
		$ret['status']=true;
        $ret['categories']= Category::all();
		
		
        return $ret;
    }

    /**
     * Store a newly created post in storage.
     *
     * @param  \App\Http\Requests\PostRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {	
		$post = new Post;
		$location = new Location;
		$image = new Image;
		$post->title="Input::get('title')";
		$post->slug="Input::get('title')";
		$post->body="Input::get('body')";
		$post->image='https://fallbacks.carbonads.com/nosvn/fallbacks/dabf8eec0afae2a669e68d8dc1092605.jpg';
		$post->user_id=(Auth::user())->id;
		$post->body="Input::get('body')";
		$post->active=true;
		$post_id=$post->save();
		
		$location->location = "Input::get('city')";
		$location->zip = "Input::get('zip')";
		$location->subarea = "Input::get('subarea')";
		$location->street = "Input::get('street')";
		$location->post_id=$post->id; 
		$location->save();
		
		$metakey=array('addtype','priceamount','pricetype','forsaleby','moreinfo','youtubevideo','moreinfo','website',				'showwebsite','phone');
		foreach ($metakey as $key)
		{
			$post_meta= New post_meta;
			$post_meta->meta_key=$key;
			$post_meta->meta_value="Input::get($key)";
			$post_meta->post_id=$post->id;
			$post_meta->save();
		}
		
		
		
  
    }

    /**
     * Display the post.
     *
     * @param  \App\Models\Post $post
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
		$ret['status']=true;
        $ret['post']= $this->repository->getPostById($id);
        return $ret;
    }

    /**
     * Show the form for editing the post.
     *
     * @param  \App\Models\Post $post
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
        if(!($this->repository->CanEdit($id)))
		{
			$ret['status']=false;
			$ret['data'] ="Permission Denied";
			return $ret;
		}
		$ret['status']=true;
        $ret['post']= $this->repository->getPostById($id);
        return $ret;
    }

    /**
     * Update the post in storage.
     *
     * @param  \App\Http\Requests\PostRequest  $request
     * @param  \App\Models\Post $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post,$id)
    {
       
	   print_r($id);
	   
	   
	   
	   
	    if(!($this->repository->CanEdit($id)))
		{
			$ret['status']=false;
			$ret['data'] ="Permission Denied";
			return $ret;
		}
		$ret['status']=true;
        
		//return $request;
        $ck=$this->repository->update($post, $request);
	
        return $ck.'The post has been successfully updated'; 
    }

    /**
     * Remove the post from storage.
     *
     * @param Post $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $this->authorize('manage', $post);

        $post->delete ();

        return response ()->json ();
    }
	
	public function showpage()
    {
        return view('showaddform');

       
    }
}
