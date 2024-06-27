<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Http;

class WaHelper
{
    const SEND_URL = "https://api.fonnte.com/send";

    private string $token;
    private string $delay;
    private string $countryCode;

    private function getToken()
    {
        return $this->token;
    }

    private function getDelay()
    {
        return $this->delay;
    }

    private function getCountryCode()
    {
        return $this->countryCode;
    }

    public function __construct()
    {
        $this->token = env('WA_TOKEN');
        $this->delay = env('WA_DELAY');
        $this->countryCode = env('WA_COUNTRY_CODE');
    }

    public static function sendMessage(string $text, string | array $dest, ?string $url = null)
    {
        $values = new WaHelper();
        $token = $values->getToken();
        $delay = $values->getDelay();
        $countryCode = $values->getCountryCode();

        if (is_array($dest)) {
            $dest = collect($dest)->join(', ');
        }

        $payload = [
            'target' => $dest,
            'message' => $text,
            'delay' => $delay,
            'countryCode' => $countryCode,
        ];

        $response = Http::withHeaders([
            "Authorization" => $token
        ])->post(self::SEND_URL, $payload);

        return $response->json();
    }

    public static function getTemplate(string $whatTemplate, String | array $payload)
    {
        $template = '';
        if ($whatTemplate == 'create_user') {
            $template = "Akun kamu telah berhasil didaftarkan.\n\n"
                . "Nama Lengkap : *" . $payload['name'] . "*\n"
                . "Tipe : *" . $payload['type'] . "*\n\n"
                . "ID : *" . $payload['id'] . "*\n"
                . "Kata Sandi : *" . $payload['id'] . "*\n\n"
                . "Kamu dapat _login_ melalui link di bawah ini.\n"
                . route('login');
        } else if ($whatTemplate == 'student_registration') {
            $template = "Akun kamu telah berhasil ditambahkan.\n\n"
                . "Nama Lengkap : *" . $payload['name'] . "*\n"
                . "NPM : *" . $payload['npm'] . "*\n"
                . "Token : *" . $payload['token'] . "*\n\n"
                . "Silahkan melakukan pendaftaran lebih lanjut melalui link di bawah ini.\n"
                . route('register');
        } else if ($whatTemplate == 'successful_registration') {
            $template = "Pendaftaran berhasil dilakukan.\n\n"
                . "Nama Lengkap : *" . $payload['name'] . "*\n"
                . "NPM : *" . $payload['npm'] . "*\n"
                . "Kata Sandi : *" . $payload['password'] . "*\n\n"
                . "Data pribadi merupakan tanggung jawab pribadi. Harap mengganti kata sandi setelah kamu berhasil _login_.\n\n"
                . "Kamu dapat _login_ melalui link di bawah ini.\n"
                . route('login');
        } else if ($whatTemplate == 'successful_registration_staff') {
            $template =  "Seorang Mahasiswa telah berhasil melakukan pendaftaran.\n\n"
                . "Nama Lengkap : *" . $payload['name'] . "*\n"
                . "NPM : *" . $payload['npm'] . "*\n\n"
                . "Silahkan tetapkan Dosen Pembimbing agar Mahasiswa tersebut dapat melakukan proses bimbingan.\n"
                . route('staff.student', ['search' => $payload['npm']]);
        } else if ($whatTemplate == 'forgot_password') {
            $template = "Proses lupa kata sandi berhasil. Berikut data akun terbaru kamu.\n\n"
                . "Nama Lengkap : *" . $payload['name'] . "*\n"
                . "ID : *" . $payload['id'] . "*\n"
                . "Kata Sandi Baru : *" . $payload['new_password'] . "*\n\n"
                . "Data pribadi merupakan tanggung jawab pribadi. Harap mengganti kata sandi setelah kamu berhasil _login_.\n\n"
                . "Kamu dapat _login_ melalui link di bawah ini.\n"
                . route('login');
        } else if ($whatTemplate == 'assign_supervisors') {
            $template = "*" . $payload['lecturer_name'] . "* telah ditetapkan sebagai *" . $payload['as'] . "* pada Mahasiswa berikut.\n\n"
                . "NPM : *" . $payload['npm'] . "*\n"
                . "Nama Lengkap : *" . $payload['name'] . "*\n\n"
                . "Mohon kerjasama terhadap proses bimbingan pada Mahasiswa tersebut.\n\n"
                . "Kamu dapat melihat Mahasiswa Bimbingan dengan mengklik tautan berikut ini.\n"
                . route('lecturer.student');
        } else if ($whatTemplate == 'assign_supervisors_student') {
            $template = "Dosen Pembimbing kamu telah ditetapkan.\n\n"
                . "*Dosen Pemimbing 1*\n"
                . "NIDN : *" . $payload['nidn_1'] . "*\n"
                . "Nama Lengkap : *" . $payload['name_1'] . "*\n\n"
                . "*Dosen Pemimbing 2*\n"
                . "NIDN : *" . $payload['nidn_2'] . "*\n"
                . "Nama Lengkap : *" . $payload['name_2'] . "*\n\n"
                . "Kamu dapat melanjutkan proses bimbingan dengan mengajukan bimbingan pada tautan di bawah ini.\n"
                . route('student.guidance');
        } else if ($whatTemplate == 'create_guidances_submission') {
            $template = "Mahasiswa bimbingan kamu mengirimkan berkas bimbingan untuk segera direviu.\n\n"
                . "NPM : *" . $payload['npm'] . "*\n"
                . "Nama Lengkap : *" . $payload['name'] . "*\n\n"
                . "Grup Bimbingan : *" . $payload['guidance_group'] . "*\n"
                . "Tipe Bimbingan : *" . $payload['guidance_type'] . "*\n"
                . "Judul Pengajuan : *" . $payload['title'] . "*\n\n"
                . "Mohon untuk segera direviu bimbingan yang telah diajukan Mahasiswa tersebut. Terimakasih.\n"
                . $payload['link'];
        } else if ($whatTemplate == 'submission_action') {
            $template = "Pengajuan judul Tugas Akhir kamu telah dikonfirmasi oleh Staf.\n\n"
                . "Judul Pengajuan : *" . $payload['title'] . "*\n"
                . "Status Pengajuan : *" . $payload['status'] . "*\n"
                . "Pesan : *" . $payload['message'] . "*\n\n"
                . "Jika status pengajuan telah disetujui. Kamu dapat melanjutkan proses bimbingan. "
                . "Apabila status belum disetujui, kamu dapat melakukan pengajuan ulang atau merevisi pengajuan tersebut.\n"
                . route('student.submission');
        } else if ($whatTemplate == 'create_review') {
            $template = "Dosen Pembimbing kamu *" . $payload['lecturer'] . " (NIDN. " . $payload['nidn'] . ")* telah melakukan reviu terhadap bimbingan kamu.\n\n"
                . "Grup Bimbingan : *" . $payload['guidance_group'] . "*\n"
                . "Tipe Bimbingan : *" . $payload['guidance_type'] . "*\n\n"
                . "Status Reviu : *" . $payload['review_status'] . "*\n"
                . "Waktu Reviu : *" . $payload['review_time'] . "*\n"
                . "Reviu : *" . $payload['review_message'] . "*\n\n"
                . "Silahkan periksa kembali bimbingan yang telah kamu ajukan. Jika ada revisi, harap segera menyelesaikannya dan mengirimkan bimbingan kembali.\n"
                . route('student.guidance');
        } else if ($whatTemplate == 'create_submission') {
            $template =  "Mahasiswa atas nama *" . $payload['name'] . " (NPM. " . $payload['npm'] . ")* telah mengirimkan pengajuan Tugas Akhir.\n\n"
                . "Judul Pengajuan : *" . $payload['title'] . "*\n"
                . "Abstrak : *" . $payload['abstract'] . "*\n\n"
                . "Silahkan konfirmasi pengajuan Mahasiswa yang bersangkutan melalui link di bawah ini.\n"
                . route('staff.approval', ['search' => $payload['npm']]);
        } else if ($whatTemplate == 'student_passed') {
            $template =  "Selamat! Kamu telah dinyatakan lulus. Berikut informasi yang kamu peroleh.\n\n"
                . "NPM : *" . $payload['npm'] . "*\n"
                . "Nama Lengkap : *" . $payload['name'] . "*\n"
                . "Predikat : *" . $payload['grade'] . "*\n"
                . "Nilai dalam angka : *" . $payload['grade_number'] . "*\n"
                . "Status : *" . $payload['status'] . "*\n\n"
                . "Segenap Dosen Pengajar dan seluruh Staf yang bertugas mengucapkan selamat atas *KELULUSAN* kamu.";
        } else if ($whatTemplate == 'student_passed_change') {
            $template =  "Mohon maaf, terjadi kesalahan pada saat kami melakukan perubahan kelulusan. Informasi kelulusan kamu telah diubah.\n\n"
                . "NPM : *" . $payload['npm'] . "*\n"
                . "Nama Lengkap : *" . $payload['name'] . "*\n"
                . "Status : *" . $payload['status'] . "*";
        }

        $footer = "\n\n\n_Pesan ini dikirimkan secara otomatis oleh Bot WA SIKITA Prodi Ilmu Komputer UGN. Mohon untuk tidak membalas pesan ini._";

        return $template . $footer;
    }
}
