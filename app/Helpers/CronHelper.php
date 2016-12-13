<?php

namespace App\Helper;

use App\Model\User;
use App\Model\Email;
use App\Model\Complaint;
use App\Model\Business;
use App\Model\Franchisee;
use App\Model\FranchiseeZipcode;

use App\Model\PUser;
use App\Model\PList;

use Mail;


class CronHelper{
    private static function date_diff($date_from) {
        $dt = new \DateTime();
        $diff = $date_from->diff($dt);
        if($diff->invert > 0)
        {
            return -($diff->days());
        }
        else {
            return $diff->days();
        }
    }

	public static function send14DayExpireEmails(){
		$complaints = Complaint::where('isDeleted', 0)->where('isResolved', 0)->get();
        $emailed = 0;
        $resolved = 0;
        $dt = new \DateTime();

		foreach ($complaints as $complaint){
            if($complaint->emailed_on == null) {
                $df = new \DateTime($complaint->submitted_on);

                $diff_days = CronHelper::date_diff($df);
                if($diff_days >= 14)
                {
                    $user = User::find($complaint->userId);
                    $business = Business::find($complaint->businessId);
                    $link1 = '<a href = "' . env('DOMAIN') . '/businessratings/' . $business->id . '?renew=true&complaint=' . $complaint->id . '">Here</a>';
                    $link2 = '<a href = "' . env('DOMAIN') . '/confirm_complaint/' . $complaint->id . '">Here</a>';
                    if (count($business->franchisees) > 0) {
                        $franchisee = $business->franchisees[0];
                        echo $business->name, ' ', $business->id, ' ', $franchisee->id, ' ', $franchisee->name, '<br>';
                        MailHelper::send14DayExpireEmail($user, $link1, $link2, $business, $franchisee->contactEmail);
                        usleep(500);

                        $complaint->emailed_on = date('Y-m-d');
                        $complaint->save();
                    }
                    $emailed++;
                }
            }
            else {
                $df = new \DateTime($complaint->emailed_on);

                $diff_days = CronHelper::date_diff($df);
                if($diff_days > 7)
                {
                    // After 7 days, the email was sent to consumer, complaint is resolved
                    $complaint->isResolved = 1;
                    $complaint->save();
                    $resolved ++;
                }
            }

		}
        error_log("Complaint mail cronjob was called. $resolved complaints have been resolved, $emailed complaints have been emailed.", 1, "alexjin9317@outlook.com", "Subject: TTP Compliant processing notification");
//        error_log("Complaint mail cronjob was called. $deleted complaints have been deleted, $processed complaints have been processed.", 3, "/var/log/php_error.log");
	}

    public static function syncUsers(){
        $cnt = 0;


        $franchisees = Franchisee::where('isDeleted', 0)->get();
        foreach ($franchisees as $franchisee){
            if (PList::where('name', $franchisee->code)->count() == 0){
                $list = new PList;
                $list->name = $franchisee->code;
                $list->description = $franchisee->name;
                $list->entered = $franchisee->created;
                $list->listorder = 0;
                $list->prefix = '';
                $list->modified = date('Y-m-d H:m:s');
                $list->active = 1;
                $list->owner = 2;
                $list->save();
            }
        }

        $resultstr = '';

        for ($i = 0; $i < 10; $i++) {
            $users = User::where('isDeleted', 0)->where('inMarketing', 0)->take(1000)->get();
            if (count($users) == 0){
                break;
            }
            $cnt += count($users);
            foreach ($users as $user){
                $franchisees = FranchiseeZipcode::where('zipcode', $user->zipcode)->get();
                if (count($franchisees) == 0){
                    //echo 'Zipcode ', $user->zipcode, ' has no owner.<br>', "\r\n";
                    $franchisees[] = Franchisee::where('code', 'Top Ten Percent')->first();
                }
                
                $pUser = PUser::where('email', 'like', $user->email)->first();


                if ($pUser != NULL){
                    if ($pUser->blacklisted == 1){
                        // $user->isDeleted = 1;
                        // $user->timestamps = 0;
                        // $user->save();
                        echo 'User ', $user->email, ' already exists, but blacklisted.<br>', "\r\n";
                        $resultstr .= 'User '. $user->email . ' already exists, but blacklisted.<br>' . "\r\n";
                    } else {
                        echo 'User ', $user->email, ' already exists.<br>', "\r\n";
                        $resultstr .= 'User ' . $user->email . ' already exists.<br>' . "\r\n";

                        foreach ($franchisees as $franchisee){
                            $list = PList::where('name', $franchisee->code)->first();
                            if ($list != NULL){
                                if ($list->users()->where('userid', $pUser->id)->count() == 0){
                                    $list->users()->attach($pUser->id, [
                                        'entered' => $user->createdDate,
                                        'modified' => date('Y-m-d H:m:s'),
                                        ]);
                                    echo 'User ', $user->email, ' has been linked to list - ' . $list->name . ' - ' . $list->description . '.<br>', "\r\n";
                                    $resultstr .= 'User ' . $user->email . ' has been linked to list - ' . $list->name . ' - ' . $list->description . '.<br>' . "\r\n";
                                }
                            }
                        }
                    }
                } else{
                    $nPUser = new PUser;
                    $nPUser->email = $user->email;
                    $nPUser->confirmed = 1;
                    $nPUser->blacklisted = 0;
                    $nPUser->optedin = 0;
                    $nPUser->bouncecount = 0;
                    $nPUser->entered = $user->createdDate;
                    $nPUser->modified = date('Y-m-d H:m:s');
                    $nPUser->uniqid = CronHelper::GUID();
                    $nPUser->htmlemail = 1;
                    $nPUser->disabled = 0;
                    $nPUser->save();
                    //echo $user->id, ' - List User ', $user->email, ' has been created. <br>', "\r\n";
                    echo 'User ', $user->email, ' has been created.<br>', "\r\n";
                    $resultstr .= 'User ' . $user->email . ' has been created.<br>' . "\r\n";

                    foreach ($franchisees as $franchisee){
                        $list = PList::where('name', $franchisee->name)->first();
                        if ($list != NULL){

                            $list->users()->attach($nPUser->id, [
                                'entered' => $user->createdDate,
                                'modified' => date('Y-m-d H:m:s'),
                                ]);
                        }
                    }
                }
                $user->timestamps = false;
                $user->inMarketing = true;
                $user->save();
            }
            echo '1000 users have been added, last user id is ', $user->id, "<br>\r\n";
            $resultstr .= '1000 users have been added, last user id is ' . $user->id . "<br>\r\n";
        }

        if ($cnt > 0){
            error_log("User Sync was called.<br>\r\n $resultstr \r\n\r\n<br><br> $cnt users have been added to marketing system.", 1, "alexjin9317@outlook.com", "Subject: TTP Synchronising notification");
        }
    }

    static function GUID()
    {
        if (function_exists('com_create_guid') === true)
        {
            return trim(com_create_guid(), '{}');
        }

        return sprintf('%04X%04X-%04X-%04X-%04X-%04X%04X%04X', mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(16384, 20479), mt_rand(32768, 49151), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535));
    }
}

?>