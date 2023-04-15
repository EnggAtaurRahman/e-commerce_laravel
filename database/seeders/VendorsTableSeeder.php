<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Vendor;

class VendorsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       $vendorRecord = [
        ['id'=>1, 'name'=>'John', 'address'=>'CP-112','city'=>'Dhaka', 'state'=>'Dhaka','country'=>'Bangladesh','pincode'=>'110001', 'mobile'=>'01917368804', 'email'=>'john@admin.com', 'status'=>0], 
        
       ];
       Vendor::insert($vendorRecord);
    }
}
