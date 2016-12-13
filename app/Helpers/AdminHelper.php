<?php

namespace App\Helper;

use App\Model\USCity;
use App\Model\User;
use App\Model\Coupon;
use App\Model\Business;
use App\Model\Complaint;
use App\Model\Rating;
use App\Model\MailHelper;
use App\Model\CouponView;
use App\Model\BusinessCategory;
use App\Model\BusinessSubCategory;
use App\Model\BusinessV;
use App\Model\NominatedBusiness;
use App\Model\Zipcode;
use App\Model\Promo;
use App\Model\Page;
use App\Model\Contract;
use App\Model\Franchisee;
use App\Model\Email;
use App\Model\Industry;

use App\MySession;

use Auth;
use DB;

class AdminHelper{
	public static function getCategories(){
		$categories = array();
		$groups = BusinessCategory::where('isDeleted', 0)->groupBy('ctGroup')->get();
		foreach ($groups as $group){
			$g = new \stdClass;
			$g->name = $group->ctGroup;
			$g->categories = array();
			$subGroups = BusinessCategory::where('ctGroup', $group->ctGroup)->where('isDeleted', 0)->get();
			foreach($subGroups as $subGroup){
				$s = new \stdClass;
				$s->name = $subGroup->category;
				$s->value = $subGroup->id;
				$s->subCategories = array();
				$subcats = BusinessSubCategory::where('parentCategoryId', $subGroup->id)->where('isDeleted', 0)->get();
				foreach ($subcats as $subcat) {
					$c = new \stdClass;
					$c->name = $subcat->subCategory;
					$c->value = $subcat->id;
					$s->subCategories[] = $c;
				}
				$g->categories[] = $s;
			}
			$categories[] = $g;
		}
		return $categories;
	}

    public static function getCatSiblings($subCatId){
        $subcat = BusinessSubCategory::find($subCatId);
        $result = array();
        $results['cats'] = array();
        $results['subcats'] = array();
        if ($subcat == NULL){
            return $results;
        }
        $subcats = BusinessSubCategory::where('parentCategoryId', $subcat->parentCategoryId)->get();
        $cat = BusinessCategory::find($subcat->parentCategoryId);
        $cats = BusinessCategory::where('ctGroup', $cat->ctGroup)->get();
        foreach ($cats as $c) {
            $ca = new \stdClass;
            $ca->name = $c->category;
            $ca->id = $c->id;
            $results['cats'][] = $ca;
        }
        foreach ($subcats as $sc){
            $s = new \stdClass;
            $s->name = $sc->subCategory;
            $s->id = $sc->id;
            $results['subcats'][] = $s;
        }
        return $results;
    }

	public static function uploadImage($file, $uppath, $name = ''){
		$valid_exts = array('jpeg', 'jpg', 'png', 'gif'); // valid extensions
        $max_size = 2000 * 1024; // max file size (200kb)
        $path = public_path() . '/Images/' . $uppath . '/'; // upload directory
        $fileName = NULL;
        $file = \Input::file('image');
        // get uploaded file extension
        //$ext = $file['extension'];
        $ext = $file->guessClientExtension();
        // get size
        $size = $file->getClientSize();
        // looking for format and size validity
        if ($name == '')
            $name = $file->getClientOriginalName();
        else 
            $name = $name . '.' . $file->getClientOriginalExtension();
        $status = '';
        $success='true';
        if (in_array($ext, $valid_exts) AND $size < $max_size)
        {
            // move uploaded file from temp to uploads directory
            if ($file->move($path,$name))
            {
                $status = 'Image successfully uploaded!';
                $fileName = $name;
            }
            else {
                $status = 'Upload Fail: Unknown error occurred!';
                $success = 'false';
            }
        }
        else {

            $status = 'Upload Fail: Unsupported file format or It is too large to upload!';
            $success = 'false';
        }

        return array(
        	'location' => $path . $name,
            'name' => $name,
        	'status' => $status,
            'success' => $success,
        	);
	}

    public static function GUID()
    {
        if (function_exists('com_create_guid') === true)
        {
            return trim(com_create_guid(), '{}');
        }

        return sprintf('%04X%04X-%04X-%04X-%04X-%04X%04X%04X', mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(16384, 20479), mt_rand(32768, 49151), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535));
    }

    public static function savePage($id, $name, $content, $keyword, $description, $active=1){
        $page = Page::find($id);
        if ($page == NULL)
            return;
        $page->pageContent = $content;
        $page->pageName = $name;
        $page->metaKeywords = $keyword;
        $page->metaDescription = $description;
        $page->isActive = $active;
        $page->save();
    }

    public static function deletePage($id){
        $page = Page::find($id);
        if ($page == NULL)
            return;
        $page->isDeleted = 1;
        $page->save();
    }

    public static function saveContract($title, $content, $active, $enterprise, $corporation){
        $contract = Contract::find(1);
        if ($contract == NULL)
            return;
        $contract->title = $title;
        $contract->content = $content;
        $contract->isActive = $active;
        $contract->enterprise = $enterprise;
        $contract->corporation = $corporation;
        $contract->save();
    }

    public static function deleteUser($id){
        $result = array();
        $user = User::find($id);
        if ($user == NULL){
            $result['success'] = 'false';
            $result['message'] = 'No such user';
        } else{
            if ($user->promoId > 0 && $user->isDeleted == 0){
                $promo = Promo::find($user->promoId);
                $promo->totalSignedUp = $promo->totalSignedUp - 1;
                if ($user->isActivated)
                    $promo->totalActivated = $promo->totalActivated - 1;
                $promo->save();
            }
            $user->isDeleted = 1;
            $user->timestamps = false;
            $user->save();
            $zipcode = Zipcode::where('zipcode', $user->zipcode)->first();
            if ($zipcode != NULL){
                if ($user->isActivated){
                    $zipcode->totalActivatedUsers = $zipcode->totalActivatedUsers - 1;
                }
                $zipcode->totalUsers = $zipcode->totalUsers - 1;
                $zipcode->save();
            }
            $result['success'] = 'true';
            $result['message'] = 'Deleted a user';
        }
        return $result;
    }

    public static function updateUser($id, $firstName, $lastName, $zipcode){
        $result = array();
        $user = User::find($id);
        if ($user == NULL){
            $result['success'] = 'false';
            $result['message'] = 'No such user';
        } else{
            $user->firstName = $firstName;
            $user->lastName = $lastName;
            $user->zipcode = $zipcode;
            $user->timestamps = false;
            $user->save();
            $result['success'] = 'true';
            $result['message'] = 'Updated user detail.';
        }
        return $result;
    }

    public static function toggleFranchiseeActive($id){
        $result = array();
        $franchisee = Franchisee::find($id);
        if ($franchisee == NULL){
            $result['success'] = 'false';
            $result['message'] = 'No such franchisee';
        } else{
            $franchisee->isActive = $franchisee->isActive == 0 ? 1 : 0;
            $franchisee->save();
            $result['success'] = 'true';
            $result['message'] = 'Franchisee status has been toggled.';
            $result['status'] = $franchisee->isActive == 1 ? 'True' : 'False';
        }
        return $result;
    }

    public static function deleteFranchisee($id){
        $result = array();
        $franchisee = Franchisee::find($id);
        if ($franchisee == NULL){
            $result['success'] = 'false';
            $result['message'] = 'No such franchisee';
        } else{
            $franchisee->isDeleted = 1;
            $franchisee->save();
            $result['success'] = 'true';
            $result['message'] = 'A franchisee has been deleted';
        }
        return $result;
    }

    public static function saveFranchisee($id, $params){
        $franchisee = Franchisee::find($id);
        $result = array();
        if ($franchisee == NULL){
            if ($id == 0){
                $f = Franchisee::where('code', $params['code'])->where('isDeleted', 0)->first();
                if ($f != NULL){
                    $result['success'] = 'false';
                    $result['message'] = 'That franchisee code already exists.';
                    return $result;
                }
                $franchisee = new Franchisee;
                $franchisee->code = $params['code'];
            } else{
                $result['success'] = 'false';
                $result['message'] = 'No such franchisee';
                return $result;
            }
        } 

        $params['emails'] = strtolower($params['emails']);

        $franchisee->name = $params['name'];
        $franchisee->city = $params['city'];
        $franchisee->state = $params['state'];
        $franchisee->contactFirstName = $params['firstName'];
        $franchisee->contactLastName = $params['lastName'];
        $franchisee->contactEmail = $params['emails'];
        $franchisee->isActive = $params['status'];
        $franchisee->isLaunched = $params['launchStatus'];
        $franchisee->franchiseZipcode = $params['zipcode'];
        $franchisee->legalName = $params['legalName'];
        $franchisee->streetAddress = $params['streetAddress'];
        $franchisee->showOnContract = $params['showOnContract'];
        $franchisee->phone = $params['phone'];
        $franchisee->lmGroup = $params['lmGroup'];
        $franchisee->lmUser = $params['lmUsername'];
        $franchisee->lmPassword = $params['lmPassword'];
        $franchisee->save();
        
        $result['success'] = 'true';
        $result['message'] = 'Franchisee has been saved.';
        
        $emails = explode("\n", $params['emails']);
        $zipcodes = explode("\n", $params['zipcodes']);
        $zipcodeIds = array();
        foreach ($zipcodes as $zipcode){
            if ($zipcode == '')
                continue;
            $z = Zipcode::where('zipcode', $zipcode)->first();
            if ($z != NULL){
                $zipcodeIds[] = $z->id;
            } else {
                $result['message'] .= '<br/>' . 'Wrong Zipcode : ' . $zipcode;
            }
        }
        $franchisee->zipcodes()->sync($zipcodeIds);

        foreach ($franchisee->users as $u) {
            $index = array_search($u->email, $emails);
            if($index !== FALSE){
                if ($u->role == 0){
                    $u->role = 1;
                    $u->timestamps = false;
                    $u->save();
                }
                unset($emails[$index]);
            } else{
                $u->franchiseId = 0;
                $u->timestamps = false;
                if ($u->role == 1)
                    $u->role = 0;
                $u->save();
            }
        }

        $uid = 0;
        $result['emails'] = $emails;
        foreach ($emails as $e){
            if ($e == '')
                continue;
            $u = User::where('loginName', 'like', $e)->orWhere('email', 'like', $e)->first();
            if ($u == NULL){
                $result['message'] .= '<br/>' . 'Wrong email : ' . $e;
            } else{
                $u->franchiseId = $franchisee->id;
                $u->timestamps = false;
                $result['user'] = $u;
                if ($u->role == 0){
                    $u->role = 1;
                }
                $u->save();
                $uid = $u->id;
            }
        }
        if ($uid != 0){
            $franchisee->userId = $uid;
        }
        $franchisee->save();
        return $result;

    }

    public static function toggleNominationApproval($id){
        $result = array();
        $nb = NominatedBusiness::find($id);
        if ($nb == NULL){
            $result['success'] = 'false';
            $result['message'] = 'Nomination has been deleted';
        } else{
            $nb->isApproved = $nb->isApproved == 1 ? 0 : 1;
            $nb->save();
            $result['success'] = 'true';
            $result['message'] = 'Nomination approval status has been toggled';
        }
        return $result;
    }

    public static function deleteNomination($id){
        $result = array();
        $nb = NominatedBusiness::find($id);
        if ($nb == NULL){
            $result['success'] = 'false';
            $result['message'] = 'Nomination has been deleted';
        } else{
            $nb->isApproved = $nb->isDeleted = 1;
            $nb->save();
            $result['success'] = 'true';
            $result['message'] = 'Nomination approval has been deleted.';
        }
        return $result;
    }

    public static function saveEmail($id, $title, $content){
        $result = array();
        $email = Email::find($id);
        if ($email == NULL){
            $result['success'] = 'false';
            $result['message'] = "No such email";
        } else{
            if ($id < 8){
                $email->title = $title;
            }
            $email->content = $content;
            $email->save();
            $result['success'] = 'true';
            $result['message'] = "Email has been saved";
        }
        return $result;
    }

    public static function saveIndustry($id, $industry, $percentage){
        $ind = NULL;
        if ($id == 0){
            $ind = new Industry;
        } else{
            $ind = Industry::find($id);
        }
        if ($ind == NULL)
            return false;
        $ind->industry = $industry;
        $ind->percentage = $percentage;
        $ind->save();
        return true;
    }

    public static function deleteIndustry($id){
        $ind = Industry::find($id);
        if ($ind == NULL){
            return false;
        }
        $ind->delete();
        return true;
    }


    public static function saveGroup($id, $name){
        $cat = BusinessCategory::find($id);
        if ($id == 0){
            $cat = new BusinessCategory;
            $cat->ctGroup = $name;
            $cat->category = 'None';
            $cat->isDeleted = 0;
            $cat->save();
        } else{
            if ($cat == NULL){
                return array(
                    'success' => 'false',
                    'message' => 'No such group',
                    );
            }
            DB::table('businesscategory')
                ->where('ctGroup', $cat->ctGroup)
                ->update(array('ctGroup' => $name));

        }
        return array(
            'success' => 'true',
        );
    }

    public static function saveCategory($parent, $id, $name){
        $cat = BusinessCategory::find($id);
        if ($id == 0){
            $group = BusinessCategory::find($parent);
            $cat = new BusinessCategory;
            $cat->isDeleted = 0;
            $cat->ctGroup = $group->ctGroup;
        }
        if ($cat == NULL){
            return array(
                'success' => 'false',
                'message' => 'No such category',
                );
        }
        $cat->category = $name;
        $cat->save();
        return array(
            'success' => 'true',
        );
    }

    public static function saveSubCategory($parent, $id, $name){
        $cat = BusinessSubCategory::find($id);
        if ($id == 0){
            $cat = new BusinessSubCategory;
            $cat->parentCategoryId = $parent;
            $cat->isDeleted = 0;
        }
        if ($cat == NULL){
            return array(
                'success' => 'false',
                'message' => 'No such sub-category',
                );
        }
        $cat->subCategory = $name;
        $cat->save();
        return array(
            'success' => 'true',
            );
    }

    public static function deleteCategory($type, $id){
        $result = 0;
        if ($type == 1){
            $cat = BusinessCategory::find($id);
            if ($cat == NULL){
                return array(
                    'success' => 'false',
                    'message' => 'No such group',
                    );
            }
            DB::table('businesscategory')
                ->where('ctGroup', $cat->ctGroup)
                ->update(array('isDeleted' => 1));

        } else if ($type == 2){
            $cat = BusinessCategory::find($id);
            if ($cat == NULL){
                return array(
                    'success' => 'false',
                    'message' => 'No such category',
                    );
            }
            $cat->isDeleted = 1;
            $cat->save();
        } else if ($type == 3){
            $cat = BusinessSubCategory::find($id);
            if ($cat == NULL){
                return array(
                    'success' => 'false',
                    'message' => 'No such category',
                    );
            }
            $cat->isDeleted = 1;
            $cat->save();
            return array(
                'success' => 'true',
                'parent' => $cat->parentCategoryId,
            );
        }
        return array(
            'success' => 'true',
            'parent' => $id,
            );
    }


}
?>