<?php

namespace App\Jobs;

use App\Jobs\Job;
use Illuminate\Contracts\Bus\SelfHandling;

use App\Helper\FrontHelper;

use Excel;

class ImportUser extends Job implements SelfHandling
{
    /**
     * Create a new job instance.
     *
     * @return void
     */
    protected $path;
    protected $promo;
    protected $email;

    public function __construct($promo, $path)
    {
        $this->promo = $promo;
        $this->path = $path;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // Excel::load($this->path, function($reader){
        //     // $reader->delimiter  = ',';
        //     // $reader->enclosure  = '"';
        //     // $reader->lineEnding = '\r\n';
            
        //     $reader->each(function($row){
        //         $fname = $row->firstname;
        //         $lname = $row->lastname;
        //         $email = $row->email;
        //         $zipcode = $row->zipcode;
        //         // FrontHelper::createUser($this->promo, $fname, $lname, $zipcode, $email, 'topten', 0, false);
        //     });
        // });
        $file = fopen($this->path, 'r');
        $headers = fgetcsv($file);

        $success = 0;
        $failed = 0;

        while (!feof($file)){
            $row = fgetcsv($file);

            $fname = $row[0];
            $lname = $row[1];
            $email = $row[2];
            $zipcode = $row[3];
            if (FrontHelper::createUser($this->promo, $fname, $lname, $zipcode, $email, 'topten', 0, false) > 0){
                $success++;
            } else{
                $failed++;
            }
        }

        error_log("Bulk user import has been finished. Success : $success, Failed : $failed ", 1, "alexjin9317@outlook.com", "Subject: TTP User Import Notification");
    }
}
