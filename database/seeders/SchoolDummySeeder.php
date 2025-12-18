<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class SchoolDummySeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create('id_ID'); // Pakai data orang Indonesia

        // 1. Reset Data Lama (Opsional, hati-hati menghapus data lama)
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('students')->truncate();
        DB::table('school_classes')->truncate();
        DB::table('school_majors')->truncate();
        DB::table('school_programs')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // 2. Buat Data Program (Reguler & Unggulan) - Penting untuk relasi
        $programRegulerId = DB::table('school_programs')->insertGetId([
            'name' => 'Reguler',
            'fee' => 100000,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $programUnggulanId = DB::table('school_programs')->insertGetId([
            'name' => 'Unggulan',
            'fee' => 250000,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // 2. Buat Data Jurusan
        $majorIpaId = DB::table('school_majors')->insertGetId([
            'name' => 'Ilmu Pengetahuan Alam',
            'abbreviation' => 'IPA',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        $majorIpsId = DB::table('school_majors')->insertGetId([
            'name' => 'Ilmu Pengetahuan Sosial',
            'abbreviation' => 'IPS',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // 3. Buat Data Kelas & 30 Siswa per Kelas
        $classList = [
            ['name' => 'X IPA 1', 'major_id' => $majorIpaId],
            ['name' => 'X IPA 2', 'major_id' => $majorIpaId],
            ['name' => 'X IPS 1', 'major_id' => $majorIpsId],
            ['name' => 'X IPS 2', 'major_id' => $majorIpsId],
        ];

        foreach ($classList as $classData) {
            // Insert Kelas (REVISI: Hapus school_major_id karena tidak ada di tabel school_classes)
            $classId = DB::table('school_classes')->insertGetId([
                'name' => $classData['name'],
                // 'school_major_id' => $classData['major_id'], // <--- BARIS INI DIHAPUS
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Insert 30 Siswa
            for ($i = 1; $i <= 30; $i++) {
                // Random program (80% reguler, 20% unggulan)
                $programId = ($i % 5 == 0) ? $programUnggulanId : $programRegulerId;

                DB::table('students')->insert([
                    'school_class_id' => $classId,
                    'school_major_id' => $classData['major_id'], // Di tabel siswa tetap ada, jadi aman
                    'school_program_id' => $programId,
                    'identification_number' => $faker->unique()->numerify('2025####'),
                    'name' => $faker->name,
                    'phone_number' => $faker->phoneNumber,
                    'gender' => $faker->randomElement([1, 2]), // 1: Laki, 2: Perempuan
                    'school_year_start' => 2025,
                    'school_year_end' => 2028,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
