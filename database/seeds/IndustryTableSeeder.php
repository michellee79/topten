<?php

use Illuminate\Database\Seeder;

class IndustryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$industries = ['Italian Restaurants', 'Chinese Restaurants', 'Steakhouses', 'Pizza', 'Mexican Restaurants', 'Night Clubs / Bars', 
    					'Entertainment','Chiropractors', 'Physicians', 'Dentists', 'Fitness Centers', 'Hair Salons / Barbershops', 'Spas – Massage',
						'Nail Salons', 'Florists', 'Pet Care', 'Attorneys', 'Accountants', 'Real Estate Agents', 'Insurance Agents',
						'Dry Cleaners', 'Auto Dealerships / Mechanics', 'Carpet Cleaners', 'Plumbers', 'Electricians', 'Painters', 
						'Roofing Contractors', 'Heating and Cooling Contractors', 'Pest Control Service Companies' ,'Home Improvement Contractors',
						'Lawn Care/Landscapers', 'Tree Companies', 'Furniture Stores', 'Clothing Stores', 'Other'];
        $percentages = [7,7,7,7,7,7,10,5,3,5,5,8,8,8,3,3,3,3,3,3,5,5,8,4,4,4,3,3,3,6,3,2,3,7,4.75];
        for ($i = 0; $i < count($industries); $i++){
        	DB::table('industries')->insert([
	            'industry' => $industries[$i],
	            'percentage' => $percentages[$i],
	        ]);
        }
    }
}
