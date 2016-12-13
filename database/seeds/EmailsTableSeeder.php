<?php

use Illuminate\Database\Seeder;

class EmailsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$titles = ["Top Ten Percent - Membership Registeration Activation", 
            "Top Ten Percent - Less than 3 Star Review", 
            "Top Ten Percent - Business Membership Agreement",
			"Top Ten Percent - Password Reset", 
            "Top Ten Percent New Business Nominations", 
            "Top Ten Percent Franchise Opportunities Info Request",
			"Top Ten Percent - Membership Registration", 
            "Top Ten Percent - 14 Day Holding Period Expired", 
            "Top Ten Percent - New Review After 14 Days Has Posted"];
    	$variables = ["FIRSTNAME,ACTIVATIONLINK", 
            "BUSINESSNAME,FIRSTNAME,LASTNAME,EMAIL,RATING,COMMENT", 
            "CONTRACTLINK,FIRSTNAME", 
            "NEWPASSWORD,FIRSTNAME", 
            "CURRENTTIME,FIRSTNAME", 
            "FIRSTNAME,LASTNAME,EMAIL,PHONE,CITY,STATE,ZIPCODE", 
            "USERNAME,FIRSTNAME", //"USERNAME,PASSWORD", 
            "FIRSTNAME,LASTNAME,LINK1,LINK2,BUSINESSNAME", 
            "FIRSTNAME,LASTNAME,BUSINESSNAME"];
        $contents = [
        "<p>&nbsp;Dear {FIRSTNAME},</p>
        <span style='font-family:Verdana; font-size:10pt;'>
<p>Congratulations! By clicking the link below you will become a LIFETIME CHARTER MEMBER of the Top Ten Percent&#8482;. This means that our normal $24.95 Annual Membership fee will be waived and your membership will be <strong>FREE FOR LIFE!</strong></p>

<p>{ACTIVATIONLINK}</p>

<p>We will email you just prior to our Official Launch date so you can start taking advantage of all the discounts offered by the world’s first Virtual On-Command Coupons&#8482; that are generated directly on your iPhone or Smartphone and accepted by all Top Ten Percent&#8482; Business Members.  Thank you for not only being a valued member, but now a LIFETIME CHARTER MEMBER! Please click the link above to authorize your membership.</p>

Thank You,<br/>
<strong>Top Ten Percent&#8482;</strong><br/>
<i>Buy From The Best For Less&#8482;</i></span>",

"<p>The following complaint has been filed for <strong>{BUSINESSNAME}</strong></p>
<p>Member: {FIRSTNAME} {LASTNAME}</p>
<p>{EMAIL}</p>
<p>Rating: {RATING}</p>
<p>Comment: {COMMENT}</p>",

"<p>Thank you for signing up with Top Ten Percent. You can find the complete business membership agreement via the following link</p>
<p>{CONTRACTLINK}</p>
Thank You,<br/>
<strong>Top Ten Percent&#8482;</strong><br/>
<i>Buy From The Best For Less&#8482;</i></span>",

"<p>Please find below your user credentials for Top Ten Percent:</p>
<p><b>Your new password is: {NEWPASSWORD}<br/><br/></b></p>
Thank You,<br/>
<strong>Top Ten Percent&#8482;</strong><br/>
<i>Buy From The Best For Less&#8482;</i></span>",

"<span style='font-family:Verdana; font-size:10pt;'>
<p>A new business nomination has been submitted at {CURRENTTIME}</p>
<br/>
<strong>Top Ten Percent&#8482;</strong><br/>
<i>Buy From The Best For Less&#8482;</i></span>",

"<span style='font-family:Verdana; font-size:10pt;'>
<h2>Franchise Info Request:</h2>
<table cellpadding='0' cellspacing='0' style='line-height:1.8;'>
<tr>
<td style='width:150px;'>First Name: </td>
<td>{FIRSTNAME}</td>
</tr>
<tr>
<td>Last Name: </td>
<td>{LASTNAME}</td>
</tr>
<tr>
<td>Email: </td>
<td>{EMAIL}</td>
</tr>
<tr>
<td>Phone Number: </td>
<td>{PHONE}</td>
</tr>
</table>
<h2>The market you are interested in:</h2>
<table cellpadding='0' cellspacing='0' style='line-height:1.8;'>
<tr>
<td style='width:150px;'>City: </td>
<td>{CITY}</td>
</tr>
<tr>
<td>State: </td>
<td>{STATE}</td>
</tr>
<tr>
<td>Zip Code: </td>
<td>{ZIPCODE}</td>
</tr>
</table>
<p></p>
<br/>
<strong>Top Ten Percent&#8482;</strong><br/>
<i>Buy From The Best For Less&#8482;</i></span>",

"<p>Congratulations and thank you for signing up for your <b>FREE LIFETIME CHARTER MEMBERSHIP</b> for the Top Ten Percent&#8482;.</p>

<p><b>Your Login name is: {USERNAME}<br/>;
Your password is what you set it as<br/><br/>
You will be prompted to change your password the first time you log in.</b></p>

<p>The Top Ten Percent&#8482; is the world's first Virtual On-command Coupon Service&#8482; that generates coupons for hundreds of products and services from local merchants to your iPhone or smartphone in an instant. Never go out to dinner or buy another product or service without saving money.</p>

<p>Even better, you will be able to BUY FROM THE BEST FOR LESS&#8482;. All of our Business Members are recognized as being in the top 10% of their respective fields.</p>

<p>Start saving now by going to <a href='http://www.TopTenPercent.com'>www.TopTenPercent.com</a></p>

Thank You,<br/>
<strong>Top Ten Percent&#8482;</strong><br/>
<i>Buy From The Best For Less&#8482;</i></span>",
"<p>&nbsp;</p>
<p>14 days ago, {FIRSTNAME} {LASTNAME} left a less than 3 Star Review. &nbsp;It is our hope that {BUSINESSNAME} was able to satisfactorily resolve the concerns.&nbsp;</p>
<p>{FIRSTNAME} {LASTNAME}&nbsp;has three options available.</p>
<p>1. &nbsp;Do nothing and the original review will be deleted.</p>
<p>2. &nbsp;Click {LINK1}&nbsp;and leave a new review that is 3 Stars or better if you feel that {BUSINESSNAME} made an honest attempt of addressing your concerns.</p>
<p>3. &nbsp;Click {LINK2}&nbsp;and leave a new review with the same number of stars you gave them originally.</p>
<p>&nbsp;</p>
<p>(TTP LINK WOULD GO HERE AND WHEN THEY CLICK IT, IT AUTOMATICALLY TAKES THEM TO PAGE FOR THAT BUSINESS WHERE THEY CAN LEAVE A REVIEW THAT WILL POST LIVE REGARDLESS IF THE REVIEW IS LESS THAN 3 STARS)</p>
<p>&nbsp;</p>",

"<p>{FIRSTNAME} {LASTNAME}&nbsp;who previously left a less than 3 Star Review for {BUSINESSNAME} 14 days ago, has posted a final review that is now live on the site. &nbsp;We cannot delete or modify this review this review in any way as the Business Member was given the opportunity to resolve the concern(s.)</p>
<p>&nbsp;</p>
<p>Thank you,</p>
<p>TTP Franchising, Inc.</p>
<p>&nbsp;</p>"

        ];
    	for ($i = 0; $i < count($titles); $i++){
	        DB::table('emails')->insert([
		            'title' => $titles[$i],
		            'variables' => $variables[$i],
                    'content' => $contents[$i],
		        ]);
    	}
        DB::table('emails')->insert([
                'title' => "Email Header",
            ]);
        DB::table('emails')->insert([
                'title' => "Email Footer",
            ]);
    }
}
