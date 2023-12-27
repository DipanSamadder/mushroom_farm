<?php



namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Menu;
use App\Models\Post;

class HomeController extends Controller

{

    /**

     * Display the user's profile form.

     */

    public function index(){

        $header_menu = Menu::where('type', 'header_menu')->where('status', 0)->orderBy('order', 'asc')->get();
        $page = Post::where('id', 99)->first();
        return view('frontend.index', compact('page', 'header_menu'));

    }



     function admin_dashboard(){

        $page['title'] = 'Dashboard';

        return view('backend.index', compact('page'));

    }

}

