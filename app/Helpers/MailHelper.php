<?php

namespace App\Helper;

use App\Model\User;
use App\Model\Email;
use Mail;

use Illuminate\Contracts\View\View;

class MailHelper{

	public static function sendActivationEmail($user){
		$email = Email::find(1);
		
		$content = $email->content;
		$content = str_replace('{FIRSTNAME}', $user->firstName, $content);
		$link = env('DOMAIN', 'http://toptenpercent.com') . "/activate/" . $user->id;
		$activationLink = '<a href="' . $link . '">' . $link . '</a>';
		$content = str_replace('{ACTIVATIONLINK}', $activationLink, $content);
		
		MailHelper::sendEmail($user->email, $email->title, $content);
	}

	public static function sendComplaintEmail($user, $bname, $fmail, $bmail, $rating, $comment){
        $email = Email::find(2);
        $content = $email->content;
        $fmails = explode("\n", $fmail);
        $ccs = array_merge(array($bmail, 'info@toptenpercent.com'), $fmails);

        $content = str_replace('{BUSINESSNAME}', $bname, $content);
        $content = str_replace('{FIRSTNAME}', $user->firstName, $content);
        $content = str_replace('{LASTNAME}', $user->lastName, $content);
        $content = str_replace('{EMAIL}', $user->email, $content);
        $content = str_replace('{PHONE}', $user->phone, $content);
        $content = str_replace('{RATING}', $rating, $content);
        $content = str_replace('{COMMENT}', $comment, $content);

        MailHelper::sendEmail($user->email, $email->title, $content, $ccs);

	}
	
	public static function sendBusinessMembershipEmail($contract){
		$email = Email::find(3);
		
		$content = $email->content;
		$content = str_replace('{FIRSTNAME}', $contract->business->firstName, $content);
		$link = env('DOMAIN', 'http://toptenpercent.com') . "/franchise_contract/" . $contract->businessId;
		$contractLink = '<a href="' . $link . '">' . $link . '</a>';
		$content = str_replace('{CONTRACTLINK}', $contractLink, $content);

		$ccs = array('info@toptenpercent.com');

		MailHelper::sendEmail($contract->email, $email->title, $content, $ccs);

	}

	public static function sendNewPasswordEmail($user, $newPassword){
		$email = Email::find(4);
		
		$content = $email->content;
		$content = str_replace('{NEWPASSWORD}', $newPassword, $content);
		$content = str_replace('{FIRSTNAME}', $user->firstName, $content);
		MailHelper::sendEmail($user->email, $email->title, $content);

	}

	public static function sendNominationEmail($nomination){
		$email = Email::find(5);
		$content = $email->content;
		
		$now = date('l jS \of F Y h:i:s A');
		$content = str_replace('{CURRENTTIME}', $now, $content);
		$content = str_replace('{FIRSTNAME}', $nomination->firstName, $content);
		MailHelper::sendEmail('info@toptenpercent.com', $email->title, $content);
	}

	public static function sendFranchiseOpportunityEmail($firstName, $lastName, $email, $phone, $city, $state, $zipcode){
		$email = Email::find(6);
		$content = $email->content;
		
		$content = str_replace('{FIRSTNAME}', $firstName, $content);
		$content = str_replace('{LASTNAME}', $lastName, $content);
		$content = str_replace('{EMAIL}', $email, $content);
		$content = str_replace('{PHONE}', $phone, $content);
		$content = str_replace('{CITY}', $city, $content);
		$content = str_replace('{STATE}', $state, $content);
		$content = str_replace('{ZIPCODE}', $zipcode, $content);
		MailHelper::sendEmail('jerryclum@toptenpercent.com', $email->title, $content);

	}

	public static function sendWelcomeEmail($user){
		$email = Email::find(7);
		$content = $email->content;
		$content = str_replace('{FIRSTNAME}', $user->firstName, $content);
		$content = str_replace('{USERNAME}', $user->email, $content);
		// $content = str_replace('{PASSWORD}', $password, $content);
		MailHelper::sendEmail($user->email, $email->title, $content);

	}

	public static function send14DayExpireEmail($user, $link1, $link2, $business, $fmail){
		$fmails = explode("\n", $fmail);
		$ccs = array_merge(array($business->email, 'info@toptenpercent.com'), $fmails);

		$email = Email::find(8);
		$content = $email->content;

		$content = str_replace('{FIRSTNAME}', $user->firstName, $content);
		$content = str_replace('{LASTNAME}', $user->lastName, $content);
		$content = str_replace('{BUSINESSNAME}', $business->name, $content);
		$content = str_replace('{LINK1}', $link1, $content);
		$content = str_replace('{LINK2}', $link2, $content);
		MailHelper::sendEmail($user->email, $email->title, $content, $ccs);
	}

	public static function sendNewReviewEmail($user, $business, $fmail){
		$ccs = array('info@toptenpercent.com');
		$email = Email::find(9);
		$content = $email->content;

		$content = str_replace('{FIRSTNAME}', $user->firstName, $content);
		$content = str_replace('{LASTNAME}', $user->lastName, $content);
		$content = str_replace('{BUSINESSNAME}', $business->name, $content);
		
		MailHelper::sendEmail($fmail, $email->title, $content, $ccs);
	}

	public static function sendTestEmail(){
		$email = Email::find(7);
		$content = $email->content;
		
		MailHelper::sendEmail('alexjin9317@outlook.com', 'Test', $content);
		
	}


	public static function sendEmail($to, $subject, $content, $cc=[]){
		$header = Email::find(10);
		$footer = Email::find(11);

		$data = array(
			'header' => $header,
			'content' => $content,
			'footer' => $footer,
			);

		Mail::send('layouts.email_master', $data, function($message) use($to, $subject, $cc) {
			$message->from('no-reply@toptenpercent.com', 'no-reply@toptenpercent.com');
			$message->to($to)->subject($subject);
			foreach ($cc as $bcc) {
				$message->bcc($bcc);
			}
		});

		
	}

	private static function sendEmail1($to, $subject, $content, $cc=[]){
		$header = Email::find(10);
		$footer = Email::find(11);
		$data = array(
			'header' => $header,
			'content' => $content,
			'footer' => $footer,
			);
		$message = view('layouts.email_master', $data)->render();

		//echo $message;

		$headers   = array();
		$headers[] = "MIME-Version: 1.0";
		$headers[] = "Content-type: text/html; charset=iso-8859-1";
		$headers[] = "From: noreply@toptenpercent.co";
		$headers[] = "Reply-To: noreply@toptenpercent.co<noreply@toptenpercent.co>";
		if (count($cc)){
			//$ccs = implode(',', $cc);
			//$headers[] = "Cc: $ccs";
			foreach ($cc as $t) {
				mail($t, $subject, $message, implode("\r\n", $headers));
			}
		}
		$headers[] = "Subject: {$subject}";
		$headers[] = "X-Mailer: PHP/".phpversion();

		// $headers  = 'MIME-Version: 1.0' . "\r\n";
		// $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		// $headers .= 'To: Mary <mary@example.com>, Kelly <kelly@example.com>' . "\r\n";
		// $headers .= 'From: Birthday Reminder <birthday@example.com>' . "\r\n";
		// $headers .= 'Cc: birthdayarchive@example.com' . "\r\n";
		// $headers .= 'Bcc: birthdaycheck@example.com' . "\r\n";

		mail($to, $subject, $message, implode("\r\n", $headers));
		//mail($to, $subject, $message, $headers);
		//mail($to, $subject, $message);
	}

}

?>