<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Seller;
use App\Models\Shop;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //Admin
        User::create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin123'),
            'userType' => 'A'
        ]);

        //Customer
        $userC = User::create([
            'name' => 'customer',
            'email' => 'customer@gmail.com',
            'password' => Hash::make('customer123'),
            'userType' => 'C'
        ]);

        Customer::create([
            'user_id' => $userC->id,
            'FName' => 'Customer',
            'LName' => 'Cus',
            'gender' => 'Laki-laki',
            'date_of_birth' => '2006-11-24',
            'email' => 'customer@gmail.com',
            'phone' => '081234567890',
            'profile_icon' => 'avatar.png'
        ]);

        //Seller
        $userS = User::create([
            'name' => 'seller',
            'email' => 'seller@gmail.com',
            'password' => Hash::make('seller123'),
            'userType' => 'S'
        ]);

        $customer = Customer::create([
            'user_id' => $userS->id,
            'FName' => 'Seller',
            'LName' => 'Sel',
            'gender' => 'Laki-laki',
            'date_of_birth' => '2006-11-24',
            'email' => 'seller@gmail.com',
            'phone' => '081234567890',
            'profile_icon' => 'avatar.png'
        ]);

        $seller = Seller::create([
            'ktp_nik' => '1234567887654321',
            'customer_id' => $customer->customer_id,
            'status_seller' => 'Verified',
            'ktp_nama' => 'Seller',
            'ktp_tempat_lahir' => 'Bandung',
            'ktp_birth' => '2006-11-24',
            'ktp_jk' => 'Laki-laki',
            'ktp_gol_darah' => 'O',
            'ktp_alamat' => 'GG. MANUNGGAL 2C',
            'ktp_rt' => '003',
            'ktp_rw' => '001',
            'ktp_kel_desa' => 'Cijerah',
            'ktp_kecamatan' => 'Bandung Kulon',
            'ktp_agama' => 'Islam',
            'ktp_status_perkawinan' => 'Belum',
            'ktp_pekerjaan' => 'Pelajar/Mahasiswa',
            'ktp_kewarganegaraan' => 'WNI',
            'ktp_picture' => 'picture.jpg',
        ]);

        Shop::create([
            'seller_ktp_nik' => $seller->ktp_nik,
            'name' => 'Adidas Indonesia',
            'url_domain' => 'http://marketfash.siswa.smkn11bdg.sch.id/AdidasIndonesia',
            'description' => 'Adidas Indonesia Official',
            'shop_icon' => 'icon.ico',
            'kota' => 'Kota Bandung',
        ]);
    }
}
