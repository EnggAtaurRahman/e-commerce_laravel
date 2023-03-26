<?php 
namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Admin;

class AdminsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       $adminRecords = [
        ['id'=>1, 'name'=>'Super Admin','type'=>'superadmin','vendor_id'=>0,'mobile'=>'01717368804','email'=>'admin@admin.com','password'=>'$2a$12$ebXFaQ.V1mCjGaDPV.PYkO4UcqAi5fKNFiqZV9pYzPXRpU7iQqIC.','image'=>'','status'=>1]
       ];
       Admin::insert($adminRecords);
    }
}
