<?php

namespace App\Http\Controllers\Front;

use Auth;
use App\{
    Http\Controllers\Controller, Http\Requests\SearchRequest, Models\User, PaymentInfo, Payments, Repositories\PostRepository, Models\Tag, Models\Category, Repositories\UserRepository
};
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
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
     * The PostRepository instance.
     *
     * @var \App\Repositories\UserRepository
     */
    protected $userRepository;


    /**
     * Create a new PostController instance.
     *
     * @param  \App\Repositories\PostRepository $postRepository
     * @param  \App\Repositories\UserRepository $userRepository
     * @return void
     */
    public function __construct(PostRepository $postRepository, UserRepository $userRepository)
    {
        $this->postRepository = $postRepository;
        $this->userRepository = $userRepository;
        $this->nbrPages = config('app.nbrPages.front.posts');
    }


    /**
     * Display a listing of the posts.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {




        DB::table('paid_session_notifications')->where('id', '=',28)->update(['session_status' => 5]);

        $posts = $this->postRepository->getActiveOrderByDate($this->nbrPages);
        $users = DB::table('users')->where('role', '=', 'expert')->limit(4)->get();
        $allPsyCount = $this->userRepository->findAllActivePsy();
        $countUser = count($allPsyCount);

        if (Auth::user()) {
            $currentUser = Auth::user();

            if ($currentUser->role == 'expert') {
                DB::table('users')
                    ->where('id', '=', Auth::user()->id)
                    ->update(['expert_status' => 0]);
                $usersWantToChat = array();
                $sessionRequests = DB::table('paid_session_notifications')
                    ->where('expert_id', '=', $currentUser->id)
                    ->where('is_seen', '=', 0)
                    ->get();
                foreach ($sessionRequests as $sessionInfo) {
                    array_push($usersWantToChat, DB::table('users')->where('id', '=', $sessionInfo->user_id)->get()[0]);
                }
            }

            $avgArray = array();
            $revievArray = array();
            foreach ($users as $u) {
                $rating = DB::table('paid_session_ratings')->where('id', '=', $u->id)->avg('rate');
                $reviev = DB::table('paid_session_ratings')->where('expert_id', '=', $u->id)->count('rate');

                array_push($avgArray, $rating);
                array_push($revievArray, $reviev);
            }

            return view('front.frontpage', compact('posts', 'users', 'countUser', 'currentUser', 'usersWantToChat', 'sessionRequests', 'avgArray', 'revievArray'));
        }
        $avgArray = array();
        $revievArray = array();
        foreach ($users as $u) {
            $rating = DB::table('paid_session_ratings')->where('expert_id', '=', $u->id)->avg('rate');

            $reviev = DB::table('paid_session_ratings')->where('expert_id', '=', $u->id)->count('rate');

            if ($reviev != 0) {
                array_push($revievArray, $reviev);
            } else {
                array_push($revievArray, 0);
            }
            if ($rating != 0) {
                array_push($avgArray, $rating);
            } else {
                array_push($avgArray, 0);
            }
        }

        return view('front.frontpage', compact('posts', 'users', 'countUser', 'avgArray', 'revievArray'));

    }

    /**
     * Display a listing of the posts.
     *
     * @return \Illuminate\Http\Response
     */
    public function myPsychics()
    {
        $user = Auth::user();
        if (!$user) throw new AuthenticationException();

        $users = DB::table('users_favorite_experts')
            ->join('users', 'users_favorite_experts.expert_id', '=', 'users.id')
            ->where('users_favorite_experts.user_id', '=', Auth::id())
            ->where('users.role', '=', 'expert')
            ->get();
        return view('front.myPsychics', compact('users'));
    }


    /**
     * Display a listing of the posts.
     *
     * @return \Illuminate\Http\Response
     */
    public function myClients()
    {
        $user = Auth::user();
        if (!$user) throw new AuthenticationException();
        $users = DB::table('users_favorite_experts')
            ->join('users', 'users_favorite_experts.user_id', '=', 'users.id')
            ->where('users_favorite_experts.expert_id', '=', Auth::id())
            ->where('users.role', '=', 'client')
            ->get();
        return view('front.myClients', compact('users'));
    }


    /**
     * Display a listing of the posts.
     *
     * @return \Illuminate\Http\Response
     */
    public function payments(Request $request)
    {

        $user = Auth::user();
        if (!$user) throw new AuthenticationException();

        if ($user->role == 'expert') {
            $payments = DB::table('payments')->where('expert_id', '=', $user->id)->get();
            $fromUser = array();
            foreach ($payments as $payment) {
                $user = DB::table('users')->where('id', '=', $payment->user_id)->get()[0];
                array_push($fromUser, $user->screen_name);
            }
        } else if ($user->role == 'client') {
            $payments = DB::table('payments')->where('user_id', '=', $user->id)->get();
        }

        $haveTransactions = "not";
        if (!empty($payments) && !empty($payments[0]))
            $haveTransactions = "yes";

        if (!empty($request->all())) {
            $data = $request->all();

            if (!empty($data['dateFrom']) && !empty($data['dateTo'])) {

                $array = array();
                $from = $data['dateFrom'];
                $to = $data['dateTo'];
                if (strtotime($from) > strtotime($to)) {
                    $buf = $from;
                    $from = $to;
                    $to = $buf;
                }

                foreach ($payments as $payment) {
                    $date = explode(' ', $payment->created_at);
                    if (strtotime($date[0]) >= strtotime($from) && strtotime($date[0]) <= strtotime($to)) {
                        array_push($array, $payment);
                    }

                }
                $payments = $array;
            }
        }
        if (\Illuminate\Support\Facades\Auth::user()->role == 'client')
            return view('front.payments', compact('user', 'payments', 'haveTransactions'));
        if (\Illuminate\Support\Facades\Auth::user()->role == 'expert')
            return view('front.payments', compact('user', 'payments', 'haveTransactions', 'fromUser'));
    }

    /**
     * Display a listing of the posts.
     *
     * @return \Illuminate\Http\Response
     */
    public function settings()
    {
        $user = Auth::user();
        if (!$user) throw new AuthenticationException();


        return view('front.user-setting-pages.settings', compact('user'));
    }


    public function readingHistory($slug = 'all')
    {
        $user = Auth::user();
        if (!$user) throw new AuthenticationException();


        if ($slug == 'all') {

            if(Auth::user()->role == 'expert') {
                $histories = DB::table('histories')
                        ->join('users', 'histories.user_id', '=', 'users.id')
                        ->where('histories.expert_id', '=', Auth::id())
                    ->get();

            }else{
                $histories = DB::table('histories')
                        ->join('users', 'histories.expert_id', '=', 'users.id')
                        ->where('histories.user_id', '=', Auth::id())
                    ->get();
            }

            return view('front.readingHistory', compact('histories'));


        } else if ($slug == 'chat') {
            $type = 0;
        } else if ($slug == 'paid') {
            $type = 1;
            $status = -2;
            if(Auth::user()->role == 'expert') {

                $histories = DB::table('histories')
                        ->join('users', 'histories.user_id', '=', 'users.id')
                        ->where('histories.expert_id', '=', Auth::id())
                        ->where('histories.type', '=', $type)
                    ->get();

                $ratesArray = array();
                foreach ($histories as $h){
                    $rate = DB::table('paid_session_ratings')->where('session_notification_id','=',$h->conversation_id)->get();
                    if(!empty($rate[0])) {
                        array_push($ratesArray, $rate[0]->rate);
                    }else{
                        array_push($ratesArray, 0);
                    }
                }
            }else{
                $histories = DB::table('histories')
                            ->join('users', 'histories.expert_id', '=', 'users.id')
                            ->where('histories.user_id', '=', Auth::id())
                            ->where('histories.type', '=', $type)
                        ->get();
            }


            return view('front.readingHistory', compact('histories','ratesArray'));
        }



        $histories = DB::table('histories')
                ->join('users', 'histories.user_id', '=', 'users.id')
                ->where('histories.user_id', '=', Auth::id())
                ->orWhere('histories.expert_id', '=', Auth::id())
                ->where('histories.type', '=', $type)
            ->get();

        return view('front.readingHistory', compact('histories'));
    }


    /**
     * Display a listing of the posts for the specified category.
     *
     * @param  \App\Models\Category $category
     * @return \Illuminate\Http\Response
     */
    public function category(Category $category)
    {
        $posts = $this->postRepository->getActiveOrderByDateForCategory($this->nbrPages, $category->slug);
        $info = __('Posts for category: ') . '<strong>' . $category->title . '</strong>';

        return view('front.index', compact('posts', 'info'));
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

        return view('front.post', array_merge($this->postRepository->getPostBySlug($slug), compact('user')));
    }

    /**
     * Get posts for specified tag
     *
     * @param  \App\Models\Tag $tag
     * @return \Illuminate\Http\Response
     */
    public function tag(Tag $tag)
    {
        $posts = $this->postRepository->getActiveOrderByDateForTag($this->nbrPages, $tag->id);
        $info = __('Posts found with tag ') . '<strong>' . $tag->tag . '</strong>';

        return view('front.index', compact('posts', 'info'));
    }

    /**
     * Get posts with search
     *
     * @param  \App\Http\Requests\SearchRequest $request
     * @return \Illuminate\Http\Response
     */
    public function search(SearchRequest $request)
    {
        $search = $request->search;
        $posts = $this->postRepository->search($this->nbrPages, $search)->appends(compact('search'));
        $info = __('Posts found with search: ') . '<strong>' . $search . '</strong>';

        return view('front.index', compact('posts', 'info'));
    }

    public function frontpage()
    {
        return view('front.frontpage');
    }


    public function psychicsList(Request $request)
    {

        $currentUser = Auth::user();
        if (!empty($request->searchedExpert)) {
            $experts = DB::table('users')->select('users.expert_status', 'users.last_name', 'users.id', 'users.fee_chat', 'users.brief_intro', 'users.spec_in', 'users.first_name', 'users.screen_name', 'users.avatar', 'users.id', 'users.is_active_now', 'users.user_title', DB::raw('avg(paid_session_ratings.rate) AS rate'))
                ->leftJoin('paid_session_ratings', 'paid_session_ratings.expert_id', '=', 'users.id')
                ->where('users.role', '=', 'expert')
                ->where('users.screen_name', 'like', '%' . $request->searchedExpert . '%')
                ->groupBy('users.expert_status', 'users.last_name', 'users.id', 'users.fee_chat', 'users.brief_intro', 'users.spec_in', 'users.first_name', 'users.screen_name', 'users.avatar', 'users.id', 'users.is_active_now', 'users.user_title')
                ->get();
            $activeExperts = DB::table('users')
                ->where('role', '=', 'expert')
                ->where('is_active_now', '=', 'active')
                ->count();
            return view('front.components.all-experts', compact('experts', 'rate', 'currentUser', 'activeExperts'));
        }


        if (!empty($request->sortby)) {
            if ($request->sortby == 'popularity') {

                $experts = DB::table('users')->select('users.expert_status', 'users.last_name', 'users.id', 'users.fee_chat', 'users.brief_intro', 'users.spec_in', 'users.first_name', 'users.screen_name', 'users.avatar', 'users.id', 'users.is_active_now', 'users.user_title', DB::raw('avg(paid_session_ratings.rate) AS rate'))
                    ->leftJoin('paid_session_ratings', 'paid_session_ratings.expert_id', '=', 'users.id')
                    ->where('users.role', '=', 'expert')
                    ->orderBy('paid_session_ratings.rate', 'DESC')
                    ->groupBy('users.expert_status', 'users.last_name', 'users.id', 'users.fee_chat', 'users.brief_intro', 'users.spec_in', 'users.first_name', 'users.screen_name', 'users.avatar', 'users.id', 'users.is_active_now', 'users.user_title')
                    ->get();
            } else if ($request->sortby == 'new') {
                $experts = DB::table('users')->select('users.expert_status', 'users.last_name', 'users.id', 'users.fee_chat', 'users.brief_intro', 'users.spec_in', 'users.first_name', 'users.screen_name', 'users.avatar', 'users.id', 'users.is_active_now', 'users.user_title', DB::raw('avg(paid_session_ratings.rate) AS rate'))
                    ->leftJoin('paid_session_ratings', 'paid_session_ratings.expert_id', '=', 'users.id')
                    ->where('users.role', '=', 'expert')
                    ->groupBy('users.expert_status', 'users.last_name', 'users.id', 'users.fee_chat', 'users.brief_intro', 'users.spec_in', 'users.first_name', 'users.screen_name', 'users.avatar', 'users.id', 'users.is_active_now', 'users.user_title')
                    ->orderBy('users.created_at', 'DESC')
                    ->get();
            } else if ($request->sortby == 'lprice') {
                $experts = DB::table('users')->select('users.expert_status', 'users.last_name', 'users.id', 'users.fee_chat', 'users.brief_intro', 'users.spec_in', 'users.first_name', 'users.screen_name', 'users.avatar', 'users.id', 'users.is_active_now', 'users.user_title', DB::raw('avg(paid_session_ratings.rate) AS rate'))
                    ->leftJoin('paid_session_ratings', 'paid_session_ratings.expert_id', '=', 'users.id')
                    ->where('users.role', '=', 'expert')
                    ->groupBy('users.expert_status', 'users.last_name', 'users.id', 'users.fee_chat', 'users.brief_intro', 'users.spec_in', 'users.first_name', 'users.screen_name', 'users.avatar', 'users.id', 'users.is_active_now', 'users.user_title')
                    ->orderBy('users.fee_chat', 'ASC')
                    ->get();
            } else if ($request->sortby == 'hprice') {
                $experts = DB::table('users')->select('users.expert_status', 'users.last_name', 'users.id', 'users.fee_chat', 'users.brief_intro', 'users.spec_in', 'users.first_name', 'users.screen_name', 'users.avatar', 'users.id', 'users.is_active_now', 'users.user_title', DB::raw('avg(paid_session_ratings.rate) AS rate'))
                    ->leftJoin('paid_session_ratings', 'paid_session_ratings.expert_id', '=', 'users.id')
                    ->where('users.role', '=', 'expert')
                    ->groupBy('users.expert_status', 'users.last_name', 'users.id', 'users.fee_chat', 'users.brief_intro', 'users.spec_in', 'users.first_name', 'users.screen_name', 'users.avatar', 'users.id', 'users.is_active_now', 'users.user_title')
                    ->orderBy('users.fee_chat', 'DESC')
                    ->get();
            }
        } else {
            $experts = DB::table('users')->select('users.expert_status', 'users.last_name', 'users.id', 'users.fee_chat', 'users.brief_intro', 'users.spec_in', 'users.first_name', 'users.screen_name', 'users.avatar', 'users.id', 'users.is_active_now', 'users.user_title', DB::raw('avg(paid_session_ratings.rate) AS rate'))
                ->leftJoin('paid_session_ratings', 'paid_session_ratings.expert_id', '=', 'users.id')
                ->where('users.role', '=', 'expert')
                ->groupBy('users.expert_status', 'users.last_name', 'users.id', 'users.fee_chat', 'users.brief_intro', 'users.spec_in', 'users.first_name', 'users.screen_name', 'users.avatar', 'users.id', 'users.is_active_now', 'users.user_title')
                ->get();
        }
        $activeExperts = DB::table('users')
            ->where('role', '=', 'expert')
            ->where('is_active_now', '=', 'active')
            ->count();


        return view('front.components.all-experts', compact('experts', 'rate', 'currentUser', 'activeExperts'));
    }


}

