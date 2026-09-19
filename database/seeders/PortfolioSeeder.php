<?php

namespace Database\Seeders;

use App\Models\Experience;
use App\Models\Profile;
use App\Models\Project;
use App\Models\Skill;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PortfolioSeeder extends Seeder
{
    public function run(): void
    {
        // ====== PROFILE: Randi Mulyana ======
        Profile::updateOrCreate(['id' => 1], [
            'name'     => 'Randi Mulyana',
            'title'    => 'Web Developer & Tech Enthusiast',
            'email'    => 'randi.mulyana@example.com',
            'phone'    => '+62 812-0000-0000',
            'location' => 'Indonesia',
            'bio'      => "Halo, saya Randi Mulyana — seorang web developer yang senang membangun aplikasi bersih, cepat, dan mudah dipakai. Fokus utama saya di Laravel, PHP, dan front-end modern. Terbuka untuk kolaborasi, proyek freelance, dan peluang kerja remote.",
            'socials'  => [
                'github'   => 'https://github.com/randimulyana',
                'linkedin' => 'https://linkedin.com/in/randimulyana',
                'twitter'  => 'https://twitter.com/randimulyana',
            ],
        ]);

        // ====== SKILLS ======
        $skills = [
            // Backend
            ['Laravel',     'backend',  90],
            ['PHP',         'backend',  88],
            ['MySQL',       'backend',  80],
            ['SQLite',      'backend',  75],
            ['REST API',    'backend',  82],
            // Frontend
            ['HTML & CSS',  'frontend', 90],
            ['Tailwind CSS','frontend', 85],
            ['JavaScript',  'frontend', 78],
            ['Blade',       'frontend', 88],
            // Tools
            ['Git & GitHub','tools',    85],
            ['VS Code',     'tools',    90],
            ['Termux',      'tools',    70],
        ];
        foreach ($skills as $i => [$name, $cat, $level]) {
            Skill::updateOrCreate(
                ['name' => $name],
                [
                    'category'   => $cat,
                    'level'      => $level,
                    'sort_order' => $i,
                ]
            );
        }

        // ====== PROJECTS ======
        $projects = [
            [
                'title'       => 'Personal Portfolio Website',
                'summary'     => 'Website portofolio responsif dengan Laravel 11 + Tailwind. Section About, Skills, Projects, Experience, dan Contact form.',
                'description' => "Website portofolio pribadi yang sedang Anda lihat sekarang 🚀.\n\nDibangun dengan Laravel 11, Blade, dan Tailwind CSS. Data disimpan di SQLite, contact form tersimpan langsung ke database. Sepenuhnya responsif untuk desktop, tablet, dan HP.",
                'tech_stack'  => ['Laravel', 'Blade', 'Tailwind CSS', 'SQLite'],
                'is_featured' => true,
                'demo_url'    => '#',
                'repo_url'    => '#',
            ],
            [
                'title'       => 'Daily Food Intake Logger',
                'summary'     => 'Aplikasi pencatat asupan makanan harian dengan kalkulator kalori otomatis.',
                'description' => "Aplikasi web sederhana untuk mencatat makanan harian, lengkap dengan kalkulator kalori dan makronutrisi.\n\nStack: Laravel + SQLite, fokus pada UX cepat input dari HP.",
                'tech_stack'  => ['Laravel', 'PHP', 'SQLite', 'Tailwind CSS'],
                'is_featured' => true,
                'repo_url'    => '#',
            ],
            [
                'title'       => 'Task Tracker CLI',
                'summary'     => 'Tool command-line berbasis Termux untuk manajemen task harian dengan persistensi JSON.',
                'description' => "Tool CLI ringan yang berjalan di Termux (Android) untuk mencatat task harian.\n\nFitur: tambah, tandai selesai, hapus, dan ekspor ke markdown.",
                'tech_stack'  => ['PHP', 'Bash', 'Termux'],
                'is_featured' => true,
                'repo_url'    => '#',
            ],
        ];
        foreach ($projects as $i => $data) {
            Project::updateOrCreate(
                ['title' => $data['title']],
                array_merge($data, [
                    'slug'       => Str::slug($data['title']),
                    'sort_order' => $i,
                ])
            );
        }

        // ====== EXPERIENCES ======
        $experiences = [
            [
                'role'        => 'Web Developer',
                'company'     => 'Freelance / Personal Projects',
                'location'    => 'Indonesia (Remote)',
                'start_date'  => '2023-01-01',
                'is_current'  => true,
                'description' => 'Membangun aplikasi web menggunakan Laravel dan stack modern. Fokus pada portofolio pribadi, pencatat harian, dan automasi berbasis Termux.',
                'highlights'  => [
                    'Membangun website portofolio Laravel + Tailwind',
                    'Mengembangkan Daily Food Intake Logger',
                    'Belajar deployment & DevOps dasar',
                ],
                'sort_order'  => 0,
            ],
            [
                'role'        => 'Junior Web Developer',
                'company'     => 'Project Based',
                'location'    => 'Remote',
                'start_date'  => '2021-06-01',
                'end_date'    => '2022-12-31',
                'description' => 'Belajar dan membangun project web dari nol: HTML, CSS, JavaScript, hingga PHP & Laravel. Eksplorasi deployment di shared hosting dan Termux.',
                'highlights'  => [
                    'Menguasai dasar PHP & MySQL',
                    'Membangun blog sederhana dengan Laravel',
                    'Aktif belajar via dokumentasi & tutorial',
                ],
                'sort_order'  => 1,
            ],
        ];
        foreach ($experiences as $exp) {
            Experience::updateOrCreate(
                ['role' => $exp['role'], 'company' => $exp['company']],
                $exp
            );
        }
    }
}
