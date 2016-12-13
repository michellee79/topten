<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Model\User;
use App\Model\GalleryImage;
use App\Model\BusinessCategory;

use Auth;

use App\Helper\AdminHelper;
use App\MySession;

class FranchisorGalleryController extends Controller{
	private $user;
	private $location;

	public function __construct(){
		$this->user = Auth::user();
		$this->location = MySession::getZipcode();
	}

	public function imageGallery(Request $request){
		$images = GalleryImage::where('category', '<>', 'N/A');

		$sort = $category = '';
		if (MySession::get('prev_context', '') == $request->path()) {
			$sort = MySession::get('franchise_imagelist_sort');
			if ($sort != NULL && $sort != ''){
				if (substr($sort, 0, 1) == '-'){
					$images = $images->orderBy(substr($sort, 1), 'desc');
				} else{
					$images = $images->orderBy($sort);
				}
			}
			$category = MySession::get('franchise_imagelist_category', '');
			if ($category != ''){
				$images = $images->where('category', $category);
			}
		}
		$images = $images->paginate(20);
		$groups = BusinessCategory::where('isDeleted', 0)->groupBy('ctGroup')->get();
		$data = array(
			'images' => $images,
			'groups' => $groups,
			'sort' => $sort,
			'selcat' => $category,
			);
		return view('franchisor.image_gallery', $data);
	}

	public function setImageFilter($category=''){
		MySession::set('franchise_imagelist_category', $category);
	}


	
}

?>