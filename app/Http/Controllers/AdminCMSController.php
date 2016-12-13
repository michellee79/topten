<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Model\User;
use App\Model\Business;
use App\Model\NominatedBusiness;
use App\Model\Promo;
use App\Model\Franchisee;
use App\Model\BusinessSelection;
use App\Model\GalleryImage;
use App\Model\BusinessCategory;
use App\Model\BusinessSubCategory;
use App\Model\Page;
use App\Model\Contract;
use App\Model\Email;
use App\Model\Industry;

use Auth;

use App\Helper\FrontHelper;
use App\Helper\AdminHelper;
use App\MySession;

use Excel;

class AdminCMSController extends Controller{

	public function __construct(){
		$this->user = Auth::user();
		$this->location = MySession::getZipcode();
	}

	public function cms(){
		$pages = Page::where('isDeleted', 0)
					->where('isActive', 1)
					->orderBy('pageName')
					->get();
		$data = array(
			'pages' => $pages,
			);
		return view('admin.cms', $data);
	}

	public function cmsEditor($id){
		$page = Page::find($id);
		if ($page == NULL)
			return redirect('/admin_cms');
		$data = array(
			'page' => $page,
			);
		return view('admin.cms_editor', $data);
	}

	public function manageContract(){
		$contract = Contract::find(1);
		$data = array(
			'contract' => $contract
			);
		return view('admin.manage_contract', $data);
	}

	public function cmsEmail(){
		$emails = Email::all();
		$data = array('emails' => $emails);
		return view('admin.cms_email', $data);
	}

	public function cmsEmailEditor($id){
		$email = Email::find($id);
		$data = array('email' => $email);
		return view('admin.cms_email_editor', $data);
	}

	public function saveEmail(Request $request, $id){
		$content = $request->input('content');
		$title = $request->input('title');
		$result = AdminHelper::saveEmail($id, $title, $content);
		return json_encode($result);
	}

	public function cmsROI(){
		$industries = Industry::all();
		$data = array(
			'industries' => $industries,
			);
		return view('admin.industry', $data);
	}

	public function getIndustry($id){
		$industry = Industry::find($id);
		$result = array();
		if ($industry == NULL){
			$result['success'] = 'false';
			$result['message'] = 'No such industry';
		} else{
			$result['success'] = 'true';
			$result['industry'] = $industry;
		}
		return json_encode($result);
	}

	public function saveIndustry(Request $request, $id){
		$industry = $request->input('industry');
		$percentage = $request->input('percentage');
		$f = AdminHelper::saveIndustry($id, $industry, $percentage);
		$result = array();
		if ($f){
			$result['success'] = 'true';
		} else {
			$result['success'] = 'false';
		}
		return json_encode($result);
	}

	public function deleteIndustry($id){
		$f = AdminHelper::deleteIndustry($id);
		$result = array();
		if ($f){
			$result['success'] = 'true';
		} else {
			$result['success'] = 'false';
		}
		return json_encode($result);
	}

	public function cmsCategory(){
		$groups = BusinessCategory::where('isDeleted', 0)->groupBy('ctGroup')->get();
		$data = array(
			'groups' => $groups,
			'cats' => [],
			'subcats' => [],
			);
		return view('admin.category', $data);
	}

	public function getCategory($type, $id){
		$result = array();
		if ($type == 1){
			$groups = BusinessCategory::where('isDeleted', 0)->groupBy('ctGroup')->get();
			$data = array(
				'groups' => $groups,
				);
			$result['html'] = view('components.admin.category_group', $data)->render();
		} else if ($type == 2){
			$g = BusinessCategory::find($id);
			$cats = BusinessCategory::where('ctGroup', $g->ctGroup)->where('isDeleted', 0)->get();
			$data = array(
				'cats' => $cats,
				);
			$result['html'] = view('components.admin.category', $data)->render();
		} else if ($type == 3){
			$subcats = BusinessSubCategory::where('parentCategoryId', $id)->where('isDeleted', 0)->get();
			$data = array(
				'subcats' => $subcats,
				);
			$result['html'] = view('components.admin.subcategory', $data)->render();
		}
		$result['success'] = 'true';
		return json_encode($result);
	}

	public function getCategoryName($type, $id){
		$result = array();
		if ($type == 1){
			$group = BusinessCategory::find($id);
			$result['name'] = $group->ctGroup;
		} else if ($type == 2){
			$g = BusinessCategory::find($id);
			$result['name'] = $g->category;
		} else if ($type == 3){
			$subcats = BusinessSubCategory::find($id);
			$result['name'] = $subcats->subCategory;
		}
		$result['success'] = 'true';
		return json_encode($result);
	}

	public function saveCategory(Request $request, $type, $id){
		$name = $request->input('name');
		if ($type == 1){
			$result = AdminHelper::saveGroup($id, $name);
		} else if ($type == 2){
			$parent = $request->input('parent');
			$result = AdminHelper::saveCategory($parent, $id, $name);
			if ($result['success'] == 'true'){
				return $this->getCategory($type, $parent);
			}
		} else if ($type == 3){
			$parent = $request->input('parent');
			$result = AdminHelper::saveSubCategory($parent, $id, $name);
			if ($result['success'] == 'true'){
				return $this->getCategory($type, $parent);
			}
		}
		if ($result['success'] == 'true'){
			return $this->getCategory($type, $id);
		}
		return json_encode($result);
	}

	public function deleteCategory($type, $id){
		$result = AdminHelper::deleteCategory($type, $id);
		if ($result['success'] == 'true'){
			return $this->getCategory($type, $result['parent']);
		}
		return json_encode($result);
	}



	public function imageList() {
        $imgList = array();
        $files = \File::allfiles(public_path().'/Images/CMS');
        foreach ($files as $file) {
        	$title = str_replace(public_path(), '', $file);
        	$title = str_replace('\\', '/', $title);
            array_push($imgList, array("title"=>$title, "value"=>$title));
        }
        return json_encode($imgList);
    } 

	public function upload(Request $request){
        $file = \Input::file('image');

        $domain = $request->root();

        $result = AdminHelper::uploadImage($file, 'CMS');
        $path = $domain . '/Images/CMS/' . $result['name'];
        $result['location'] = $path;

        return json_encode($result); 
	}


}

?>