<?php

namespace App\Services;

use App\Models\Course;
use Illuminate\Support\Facades\Cache;
use Prism\Prism\Facades\Prism;

class ChatbotService
{
    public function generateResponse(string $question): string
    {
        $context = $this->buildContext();

        $knowledgeBasePrompt = <<<PROMPT
Kamu adalah asisten virtual untuk platform e-learning {$context['platform_name']}.

INFORMASI WEBSITE (WAJIB DIGUNAKAN SEBAGAI KNOWLEDGE BASE):
{$context['knowledge']}

ATURAN PENTING:
1. Jawab HANYA berdasarkan informasi di atas. Jangan mengarang data.
2. Jika user menanyakan kursus, SEBUTKAN kursus yang tersedia beserta instruktur dan harganya.
3. Jika menanyakan tentang fitur, jelaskan fitur yang ada di platform.
4. Jika user bertanya tentang cara mendaftar/belajar, jelaskan langkah-langkahnya.
5. Jika pertanyaan tidak terkait platform e-learning, jawab dengan sopan tapi arahkan kembali ke topik belajar.
6. Jawab dalam Bahasa Indonesia yang ramah, jelas, dan singkat.
7. Jangan gunakan format markdown kecuali yang memang penting (bullet points, bold untuk nama kursus).
PROMPT;

        $response = Prism::text()
            ->using('sumopod', config('prism.providers.sumopod.model', 'MiniMax-M2.7-highspeed'))
            ->withSystemPrompt($knowledgeBasePrompt)
            ->withPrompt($question)
            ->asText();

        return $response->text;
    }

    public function generateResponseStream(string $question): \Generator
    {
        $context = $this->buildContext();

        $knowledgeBasePrompt = <<<PROMPT
Kamu adalah asisten virtual untuk platform e-learning {$context['platform_name']}.

INFORMASI WEBSITE (WAJIB DIGUNAKAN SEBAGAI KNOWLEDGE BASE):
{$context['knowledge']}

ATURAN PENTING:
1. Jawab HANYA berdasarkan informasi di atas. Jangan mengarang data.
2. Jika user menanyakan kursus, SEBUTKAN kursus yang tersedia beserta instruktur dan harganya.
3. Jika menanyakan tentang fitur, jelaskan fitur yang ada di platform.
4. Jika user bertanya tentang cara mendaftar/belajar, jelaskan langkah-langkahnya.
5. Jika pertanyaan tidak terkait platform e-learning, jawab dengan sopan tapi arahkan kembali ke topik belajar.
6. Jawab dalam Bahasa Indonesia yang ramah, jelas, dan singkat.
7. Jangan gunakan format markdown kecuali yang memang penting (bullet points, bold untuk nama kursus).
PROMPT;

        yield from Prism::text()
            ->using('sumopod', config('prism.providers.sumopod.model', 'MiniMax-M2.7-highspeed'))
            ->withSystemPrompt($knowledgeBasePrompt)
            ->withPrompt($question)
            ->asStream();
    }

    protected function buildContext(): array
    {
        return Cache::remember('chatbot_knowledge', 3600, function () {
            $courses = Course::query()
                ->where('status', 'published')
                ->with('teacher')
                ->latest()
                ->limit(20)
                ->get();

            $courseList = $courses->map(fn ($course) => sprintf(
                '- %s | Instruktur: %s | Harga: Rp %s',
                $course->title,
                $course->teacher?->name ?? 'N/A',
                number_format($course->price, 0, ',', '.')
            ))->join("\n");

            $knowledge = <<<KNOWLEDGE

Platform ini merupakan platform e-learning kursus online.

KURSUS TERSEDIA:
{$courseList}

FITUR PLATFORM:
1. Kursus Terstruktur - Materi tersusun rapi dari dasar hingga mahir dengan progres yang jelas
2. Progres Real-time - Pantau kemajuan belajar secara langsung
3. Sertifikat Resmi - Sertifikat diakui setelah menyelesaikan kursus

CARA MENDAFTAR: Klik tombol "Register" di pojok kanan atas, isi data diri, lalu mulai belajar.
CARA BELAJAR: Setelah registrasi, buka halaman kursus dan mulai sesuai modul yang tersedia.
KNOWLEDGE;

            return [
                'platform_name' => config('app.name', 'EduMentor'),
                'knowledge' => $knowledge,
            ];
        });
    }
}
