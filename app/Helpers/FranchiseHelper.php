<?php

namespace App\Helper;

use App\Model\USCity;
use App\Model\User;
use App\Model\Coupon;
use App\Model\Business;
use App\Model\Complaint;
use App\Model\Rating;
use App\Model\CouponView;
use App\Model\BusinessCategory;
use App\Model\BusinessSubCategory;
use App\Model\BusinessV;
use App\Model\NominatedBusiness;
use App\Model\Zipcode;
use App\Model\Promo;
use App\Model\LogoImage;
use App\Model\Franchisee;
use App\Model\BusinessContract;
use App\Model\SignatureImage;
use App\Model\GalleryImage;
use App\Model\BusinessSelection;

use App\MySession;
use App\Helper\AdminHelper;
use App\Helper\MailHelper;

use Auth;
use DB;

class FranchiseHelper{

	public static function saveBusiness($franchiseId, $catId, $catId2, $bname, $addr, $city, $state, $zipcode, 
				$cfname, $clname, $cemail, $cwebsite, $cphone, $ccphone, $sdate, $active, $image, $trtext, $bltext, $summary, $id){
		
		$franchisee = Franchisee::find($franchiseId);
		if ($franchisee == NULL){
			return array(
				'success' => 'false',
				'message' => 'No such franchisee'
			); // no such franchisee
		}

		if ($id > 0)
			$business = Business::find($id);
		else 
			$business = new Business;

		$business->subCatId = $catId;
		$business->subCatId2 = $catId2;
		$business->name = $bname;
		$business->address = $addr;
		$business->city = $city;
		$business->state = $state;
		$business->zipcode = $zipcode;
		$business->firstName = $cfname;
		$business->lastName = $clname;
		$business->email = $cemail;
		$business->website = $cwebsite;
		$business->phone = $cphone;
		$business->cellPhone = $ccphone;
		if ($sdate != NULL && strlen($sdate) > 0){
			$date = \DateTime::createFromFormat('m/d/Y', $sdate);
			if ($date === false){
				$result['success'] = 'false';
				$result['message'] = "Bad Date Format - Visible On Website " . $active;
				return $result;
			}
			$business->startDate = $date->format('Y-m-d');
		}
		if ($id == 0){
			$business->dateCreated = date('Y-m-d H:i:s');
			$business->logoId = 0;
		}

		if ($zipcode != ''){

			$r = FrontHelper::getCoordinate($zipcode);

			if ($r->status == 'OK'){
				$business->latitude = $r->results[0]->geometry->location->lat;
				$business->longitude = $r->results[0]->geometry->location->lng;
			}
		}


		$business->isActive = $active;
		$business->isDeleted = 0;
		$business->profileTopRight = $trtext;
		$business->profileBottomLeft = $bltext;
		$business->summary = $summary;

		$business->save();

		if ($business->franchisees != NULL)
			$business->franchisees()->detach($franchiseId);
		$business->franchisees()->attach($franchiseId);

		if ($image != NULL){
			$r = AdminHelper::uploadImage($image, 'logos', $business->id . date('YmdHis'));
			if ($r['success'] == 'true'){
				$logo = new LogoImage;
				$logo->url = '/Images/logos/' . $r['name'];
				$logo->added = date('Y-m-d H:i:s');
				$logo->save();
				$business->logoId = $logo->id;
				$business->save();
			}
		} 
		if ($business->logoId == 0){
			$logo = new LogoImage;
			$logo->url = '/Images/BusinessProfile/DefaultBusinessImage.png';
			$logo->added = date('Y-m-d H:i:s');
			$logo->save();
			$business->logoId = $logo->id;
			$business->save();
		}
		return array(
			'success'   => 'true',
			'message'   => 'Saved business successfully',
			'bId'       => $business->id
			);
	}

	public static function removeBusiness($id){
		$business = Business::find($id);
		if ($business == NULL)
			return 0;
		$business->isDeleted = 1;
		$business->save();
		return 1;
	}

	public static function saveContract($values){
		$bid = $values['businessId'];

		$b = Business::find($bid);
		$b->subCatId = $values['subCatId'];
		$b->subCatId2 = $values['subCatId2'];
		$b->save();
		
		$bc = BusinessContract::where('businessId', $bid)->where('isDeleted', 0)->first();
		$result = array();
		if ($bc == NULL){
			$result['success'] = 'false';
			$result['message'] = "Can't find business.";
			return $result;
		}
		
		$bc->name = $values['name'];
		$bc->website = $values['website'];
		
		$date = \DateTime::createFromFormat('m/d/Y', $values['effectiveDate']);
		if ($date === false){
			$result['success'] = 'false';
			$result['message'] = "Bad Date Format - Effective Date";
			return $result;
		}
		$bc->effectiveDate = $date->format('Y-m-d');
		
		$bc->address = $values['address'];
		$bc->city = $values['city'];
		$bc->state = $values['state'];
		$bc->zip = $values['zip'];
		$bc->email = $values['email'];
		$bc->phone = $values['phone'];
		$bc->fax = $values['fax'];
		$bc->authorizedRep = $values['authorizedRep'];
		$bc->repTitle = $values['repTitle'];
		$bc->subCatId = $values['subCatId'];
		$bc->subCatId2 = $values['subCatId2'];
		$bc->additionalInstructions = $values['additionalInstructions'];
		$bc->initialCoupon = $values['initialCoupon'];
		
		$bc->averageTransaction = intval($values['averageTransaction']);
		$bc->averageDeterminedValue = intval($values['averageDeterminedValue']);

		$date = \DateTime::createFromFormat('m/d/Y', $values['visibleOnWebsite']);
		if ($date === false){
			$result['success'] = 'false';
			$result['message'] = "Bad Date Format - Visible On Website " . $values['visibleOnWebsite'];
			return $result;
		}
		$bc->visibleOnWebsite = $date->format('Y-m-d');

		$date = \DateTime::createFromFormat('m/d/Y', $values['paymentDueDate']);
		if ($date === false){
			$result['success'] = 'false';
			$result['message'] = "Payment Due Date Format - Visible On Website";
			return $result;
		}
		$bc->paymentDueDate = $date->format('Y-m-d');

		$bc->paymentType = $values['paymentType'];
		$bc->membershipType = $values['membershipType'];
		$bc->membershipFee = floatval($values['membershipFee']);
		$bc->initialFeeType = $values['initialFeeType'];
		$bc->fee = $values['fee'];
		$bc->other1 = $values['other1'];
		$bc->other2 = $values['other2'];
		$bc->note = $values['note'];
		$bc->totalDueNow = $values['totalDueNow'];
		$bc->onGoingMonthlyFee = $values['onGoingMonthlyFee'];

		$bc->businessMemberSignatureId = FranchiseHelper::saveImageFromBase64($values['businessMemberSignature']);
		$bc->topTenRepSignatureId = FranchiseHelper::saveImageFromBase64($values['topTenRepSignature']);

		$bc->vip = $values['vip'];
		$bc->promo = $values['promo'];

		$bc->lastUpdated = date('Y-m-d H:i:s');
		$bc->isDeleted = 0;

		$bc->save();

		if ($bc->email != ''){
			MailHelper::sendBusinessMembershipEmail($bc);
		}

		$result['success'] = 'true';
		$result['message'] = 'Saved contract.';
		return $result;

	}

	public static function removeRating($id){
		$rating = Rating::find($id);
		$rating->isDeleted = 1;
		$rating->save();
	}

	public static function activateRating($id){
		$rating = Rating::find($id);
		$business = Business::find($rating->businessId);
		foreach ($business->ratings as $r){
			$r->isDisplayed = 0;
			$r->save();
		}
		$rating->isDisplayed = 1;
		$rating->save();
	}

	public static function saveImageFromBase64($base64Image){
	    $data = explode(',', $base64Image);
        if(count($data) > 1)
        {
            $si = new SignatureImage;
            $si->save();

            $path = 'Images/signatures/' . $si->id . '.png';
            $ifp = fopen($path, "wb");
            fwrite($ifp, base64_decode($data[1]));
            fclose($ifp);

            $si->url = "/" . $path;
            $si->added = date('Y-m-d H:i:s');
            $si->save();

            return $si->id;
        }

	    return 0;
	}

	public static function saveBusinessGalleryImage($bid, $image){
		$gi = new GalleryImage;
		$gi->added = date('Y-m-d H:i:s');
		$gi->save();
		$result = AdminHelper::uploadImage($image, 'Gallery', $gi->id);
		if ($result['success'] == 'false'){
			$gi->delete();
			return $result;
		}
		$gi->category = 'N/A';
		$gi->url = 'Images/Gallery/' . $result['name'];
		$gi->save();
		$business = Business::find($bid);
		$business->images()->attach($gi->id);
		$result['success'] = 'true';
		return $result;
	}

	public static function saveCoupon($params){
		$coupon = Coupon::find($params['id']);
		$result = array();
		if ($coupon == NULL){
			if ($params['id'] == 0){
				$coupon = new Coupon;
				$coupon->businessId = $params['bid'];
				$coupon->isActive = 0;
				$coupon->save();
				$business = Business::find($params['bid']);
				$business->coupons()->attach($coupon->id);
			} else{
				$result['success'] = 'false';
				$result['message'] = 'No such coupon';
			}
		} 

		$coupon->title = $params['title'];
		$coupon->description = $params['description'];
		$coupon->discount = $params['discount'];
		$coupon->disclaimer = $params['disclaimer'];
		$coupon->averageValue = $params['averageValue'];
		$coupon->isDeleted = 0;
		$coupon->save();
		$result['success'] = 'true';
		$result['message'] = 'Saved coupon successfully';
		return $result;
	}

	public static function activateCoupon($id){
		$coupon = Coupon::find($id);
		$result = array();
		if ($coupon == NULL){
			$result['success'] = 'false';
			$result['message'] = 'No such coupon';
		} else{
			$business = Business::find($coupon->businessId);
			foreach ($business->coupons as $c){
				$c->isActive = 0;
				$c->save();
			}
			$coupon->isActive = $coupon->isActive == 0 ? 1 : 0;
			$coupon->save();
			$result['success'] = 'true';
			$result['message'] = 'Coupon activated';
		}
		return $result;
	}

	public static function deleteCoupon($id){
		$coupon = Coupon::find($id);
		if ($coupon == NULL){
			$result['success'] = 'false';
			$result['message'] = 'No such coupon';
		}
		$coupon->isDeleted = 1;
		$coupon->isActive = 0;
		$coupon->save();
		$result['success'] = 'true';
		$result['message'] = 'Deleted a coupon';
		return $result;
	}

	public static function updatePromo($id, $name){
		$result = array();
		$promo = Promo::find($id);
		if ($promo == NULL){
			$result['success'] = 'false';
			$result['message'] = 'No such promo'; 
			return $result;
		}
		$promo->assignedTo = $name;
		$promo->save();
		
		$result['success'] = 'true';
		$result['message'] = 'Updated promocode successfully'; 
		$result['name'] = $name;
		return $result;
	}

	public static function addPromo($params){
		$result = array();
		$promo = Promo::where('code', $params['code'])->where('isDeleted', 0)->first();
		if ($promo == NULL){
			$promo = new Promo;
			$promo->code = $params['code'];
			$promo->created = date('Y-m-d H:i:s');
			$promo->assignedTo = $params['assignedTo'];
			$promo->isActive = 1;
			$promo->requireActivation = $params['requireActivation'];
			$promo->isdeleted = 0;
			$promo->totalSignedUp = 0;
			$promo->totalActivated = 0;
			$promo->save();
			$result['success'] = 'true';
			$result['message'] = 'That promo code has been created!';
		} else{
			$result['success'] = 'false';
			$result['message'] = 'That promo code already exists!';
		}
		return $result;
	}

	public static function togglePromoNeedActivation($id){
		$result = array();
		$promo = Promo::find($id);
		if ($promo == NULL){
			$result['success'] = 'false';
			$result['message'] = 'No such promo';
		} else{
			$promo->requireActivation = $promo->requireActivation == 1 ? 0 : 1;
			$promo->save();
			$result['success'] = 'true';
			$result['message'] = 'Promo code has been activated';
			$result['requireActivation'] = $promo->requireActivation == 1 ? 'True' : 'False';
		}
		return $result;
	}

	public static function togglePromoActivation($id){
		$result = array();
		$promo = Promo::find($id);
		if ($promo == NULL){
			$result['success'] = 'false';
			$result['message'] = 'No such promo';
		} else{
			$promo->isActive = $promo->isActive == 1 ? 0 : 1;
			$promo->save();
			$result['success'] = 'true';
			$result['message'] = 'Promo code has been activated';
			$result['isActive'] = $promo->isActive == 1 ? 'True' : 'False';
		}
		return $result;
	}

	public static function deletePromo($id){
		$result = array();
		$promo = Promo::find($id);
		if ($promo == NULL){
			$result['success'] = 'false';
			$result['message'] = 'No such promo';
		} else{
			$promo->isDeleted = 1;
			$promo->save();
			$result['success'] = 'true';
			$result['message'] = 'Promo code has been deleted';
		}
		return $result;
	}

	public static function saveGalleryImage($image, $category){
		$gi = new GalleryImage;
		$gi->added = date('Y-m-d H:i:s');
		$gi->category = $category;
		$gi->save();
		$result = AdminHelper::uploadImage($image, 'Gallery', $gi->id);
		if ($result['success'] == 'false'){
			$gi->delete();
			return $result;
		}
		$gi->url = 'Images/Gallery/' . $result['name'];
		$gi->save();
		$result['success'] = 'true';
		return $result;
	}

	public static function removeGalleryImage($gid){
		$gi = GalleryImage::find($gid);
		if ($gid != NULL){
			$gi->delete();
		}
	}

	public static function removeBusinessGalleryImage($bid, $gid){
		$business = Business::find($bid);
		$business->images()->detach($gid);
	}

	public static function saveBusinessCriteria($franchiseId, $businessName, $consumerName, $businessContactName, $businessContactName2, $phoneNumber, $zipcode){
		$bc = new BusinessSelection;
		$bc->franchiseId = $franchiseId;
		$bc->businessName = $businessName;
		$bc->consumerNominated = $consumerName;
		$bc->businessContact = $businessContactName;
		$bc->businessContact2 = $businessContactName2;
		$bc->businessPhone = $phoneNumber;
		$bc->businessZip = $zipcode;
		$bc->siteInspection = 0;
		$bc->interview = 0;
		$bc->missionStatement = 0;
		$bc->communityInvolvement = 0;
		$bc->achievements = 0;
		$bc->yearsInBusiness = 0;
		$bc->bbbMembership = 0;
		$bc->onlineCustomerReviews = 0;
		$bc->chamberOfCommerce = 0;
		$bc->passed = 0;
		$bc->isDeleted = 0;
		$bc->dateSubmitted = date('Y-m-d H:i:s');
		$bc->save();
		return $bc->id;
	}

	public static function updateBusinessCriteria($id, $inspection, $interview, $mission, $community, $achievement, $years, $bbb, $review, $chamber){
		$bc = BusinessSelection::find($id);
		$bc->siteInspection = $inspection;
		$bc->interview = $interview;
		$bc->missionStatement = $mission;
		$bc->communityInvolvement = $community;
		$bc->achievements = $achievement;
		$bc->yearsInBusiness = $years;
		$bc->bbbMembership = $bbb;
		$bc->onlineCustomerReviews = $review;
		$bc->chamberOfCommerce = $chamber;
		$bc->dateSubmitted = date('Y-m-d H:i:s');
		$sum = $inspection + $interview + $mission + $community + $achievement + $years + $bbb + $review + $chamber;
		if ($sum >= 75){
			$bc->passed = 1;
		} else{
			$bc->passed = 0;
		}
		$bc->save();
		return $sum;
	}

	public static function getBusinessNames($franchiseId, $contains){
		$franchisee = Franchisee::find($franchiseId);
		$businesses = $franchisee->businesses()->where('name', 'like', '%' . $contains . '%')->where('isDeleted', 0)->get();
		$names = [];
		foreach ($businesses as $business){
			$names[] = $business->name;
		}
		return $names;
	}
}
?>