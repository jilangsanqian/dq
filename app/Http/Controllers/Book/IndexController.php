<?php
/**
 * Created by yunniu.
 * User: ranhai
 * Date: 2018-10-17
 * Time: 16:31
 */
namespace App\Http\Controllers\Book;

use App\Http\Controllers\Controller;


class IndexController extends Controller {

	public function index() {


		return view('index');
	}
}