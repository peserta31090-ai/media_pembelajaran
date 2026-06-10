<?php

namespace Database\Seeders;

use App\Models\Guru;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        $admin = User::firstOrCreate(
            ['email' => 'admin@smkn1stg.sch.id'],
            [
                'name' => 'Admin Sekolah',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ]
        );

        // Guru
        $guru = User::firstOrCreate(
            ['email' => 'guru@smkn1stg.sch.id'],
            [
                'name' => 'Guru Informatika',
                'password' => Hash::make('password'),
                'role' => 'guru',
            ]
        );

        Guru::firstOrCreate(
            ['user_id' => $guru->id],
            [
                'user_id' => $guru->id,
                'nip' => '198500112010011001',
                'alamat' => 'Jl. Pendidikan No. 1, Sintuk Toboh Gadang',
                'no_hp' => '081234567890',
            ]
        );

        // Siswa
        $siswa = User::firstOrCreate(
            ['email' => 'siswa@smkn1stg.sch.id'],
            [
                'name' => 'Siswa Contoh',
                'password' => Hash::make('password'),
                'role' => 'siswa',
            ]
        );

        Siswa::firstOrCreate(
            ['user_id' => $siswa->id],
            [
                'user_id' => $siswa->id,
                'nis' => '2024001',
                'kelas_id' => 1,
                'alamat' => 'Sintuk Toboh Gadang',
                'no_hp' => '081234567891',
            ]
        );
    }
}
