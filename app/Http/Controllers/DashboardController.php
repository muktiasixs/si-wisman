<?php

namespace App\Http\Controllers;

use App\Models\Kunjungan;
use App\Models\Negara;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class DashboardController extends Controller
{
    private function getCountriesMapping()
    {
        return [
            'BRUNEI D' => 'bn',
            'MALAYSIA' => 'my',
            'PHILIPPINES' => 'ph',
            'SINGAPORE' => 'sg',
            'THAILAND' => 'th',
            'VIETNAM' => 'vn',
            'LAOS' => 'la',
            'INDONESIA' => 'id',
            'JAPAN' => 'jp',
            'SOUTH KOREA' => 'kr',
            'CHINA' => 'cn',
            'INDIA' => 'in',
            'AUSTRALIA' => 'au',
            'UNITED STATES' => 'us',
            'UNITED KINGDOM' => 'gb',
            'FRANCE' => 'fr',
            'GERMANY' => 'de',
            'NETHERLANDS' => 'nl',
            'RUSSIA' => 'ru',
            'SAUDI ARABIA' => 'sa',
            'TURKEY' => 'tr',
            'BRAZIL' => 'br',
            'SOUTH AFRICA' => 'za',
            'NEW ZEALAND' => 'nz'
        ];
    }

    public function index()
    {
        $totalNegara = Negara::count();
        $totalWisatawan = Kunjungan::where('bulan', 'Mei')->sum('jumlah'); // Asumsikan bulan terakhir adalah Mei
        $totalBulan = Kunjungan::select('bulan')->distinct()->count();
        $listNegara = array_keys($this->getCountriesMapping());

        $topCountries = Kunjungan::select('negara.nama_negara', 'kunjungan.jumlah')
            ->join('negara', 'kunjungan.id_negara_asal', '=', 'negara.id_negara')
            ->where('kunjungan.bulan', 'Mei')
            ->orderByDesc('kunjungan.jumlah')
            ->take(5)
            ->get();

        $totalByMonth = Kunjungan::select('bulan', \Illuminate\Support\Facades\DB::raw('SUM(jumlah) as total'))
            ->groupBy('bulan')
            ->orderByRaw("FIELD(bulan, 'Jan', 'Feb', 'Mar', 'Apr', 'Mei')")
            ->get();

        return view('dashboard', compact('totalNegara', 'totalWisatawan', 'totalBulan', 'listNegara', 'topCountries', 'totalByMonth'));
    }

    public function geomapData()
    {
        $negaraList = Negara::all();
        $mapping = $this->getCountriesMapping();
        $data = [];
        
        foreach ($negaraList as $negara) {
            $kunjunganMei = Kunjungan::where('id_negara_asal', $negara->id_negara)->where('bulan', 'Mei')->first();
            $kunjunganApril = Kunjungan::where('id_negara_asal', $negara->id_negara)->where('bulan', 'Apr')->first();

            if ($kunjunganMei) {
                $jumlahMei = $kunjunganMei->jumlah;
                $jumlahApril = $kunjunganApril ? $kunjunganApril->jumlah : 0;
                $selisih = $jumlahMei - $jumlahApril;
                
                $iso = $mapping[strtoupper($negara->nama_negara)] ?? '';

                $data[] = [
                    'hc-key' => $iso,
                    'value' => $jumlahMei,
                    'kode_negara' => strtoupper($iso),
                    'meta' => [
                        'nama' => $negara->nama_negara,
                        'mei' => $jumlahMei,
                        'april' => $jumlahApril,
                        'selisih' => $selisih
                    ]
                ];
            }
        }

        return response()->json($data);
    }

    public function datatableData()
    {
        // Pivot Jan-Mei
        $negaraList = Negara::with('kunjungan')->get();
        
        $data = [];
        foreach ($negaraList as $index => $negara) {
            $row = [
                'id_negara' => $negara->id_negara,
                'no' => $index + 1,
                'nama_negara' => $negara->nama_negara,
                'Jan' => 0,
                'Feb' => 0,
                'Mar' => 0,
                'Apr' => 0,
                'Mei' => 0,
            ];

            foreach ($negara->kunjungan as $k) {
                if (array_key_exists($k->bulan, $row)) {
                    $row[$k->bulan] = $k->jumlah;
                }
            }

            $data[] = $row;
        }

        return response()->json(['data' => $data]);
    }

    public function store(Request $request)
    {
        $validCountries = array_keys($this->getCountriesMapping());
        
        $request->validate([
            'nama_negara' => 'required|string|in:' . implode(',', $validCountries),
        ], [
            'nama_negara.in' => 'Nama negara tidak valid atau tidak ada dalam daftar yang diizinkan.'
        ]);
        
        if (Negara::where('nama_negara', strtoupper($request->nama_negara))->exists()) {
            return response()->json(['success' => false, 'message' => 'Negara sudah terdaftar.'], 422);
        }

        DB::beginTransaction();
        try {
            $maxId = Negara::max('id_negara') ?? 0;
            $newId = $maxId + 1;

            $negara = Negara::create([
                'id_negara' => $newId,
                'nama_negara' => strtoupper($request->nama_negara),
                'id_sumber' => 1 // Default BPS
            ]);

            $bulanList = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei'];
            
            $maxKunjunganId = Kunjungan::max('id_kunjungan') ?? 0;
            
            foreach ($bulanList as $bulan) {
                $maxKunjunganId++;
                $jumlah = $request->input(strtolower($bulan)) ?? 0;
                Kunjungan::create([
                    'id_kunjungan' => $maxKunjunganId,
                    'id_negara_asal' => $newId,
                    'id_negara_tujuan' => 8, // Indonesia
                    'bulan' => $bulan,
                    'jumlah' => $jumlah
                ]);
            }
            DB::commit();
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request)
    {
        $id_negara = $request->input('id_negara');
        $bulanList = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei'];

        DB::beginTransaction();
        try {
            foreach ($bulanList as $bulan) {
                $jumlah = $request->input(strtolower($bulan));
                if ($jumlah !== null) {
                    Kunjungan::updateOrCreate(
                        ['id_negara_asal' => $id_negara, 'bulan' => $bulan],
                        ['jumlah' => $jumlah]
                    );
                }
            }
            DB::commit();
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function delete(Request $request)
    {
        $id_negara = $request->input('id_negara');
        Kunjungan::where('id_negara_asal', $id_negara)->delete();
        Negara::where('id_negara', $id_negara)->delete(); // Aturan opsional: hapus juga negaranya jika diinginkan

        return response()->json(['success' => true]);
    }

    public function chat(Request $request)
    {
        $question = $request->input('question');
        $groqApiKey = env('GROQ_API_KEY');
        $geminiApiKey = env('GEMINI_API_KEY');

        if (!$groqApiKey && !$geminiApiKey) {
            return response()->json(['answer' => 'API Key (Groq / Gemini) belum disetting di .env']);
        }

        // Ambil data untuk konteks AI
        $kunjunganData = DB::table('kunjungan')
            ->join('negara', 'kunjungan.id_negara_asal', '=', 'negara.id_negara')
            ->select('negara.nama_negara', 'kunjungan.bulan', 'kunjungan.jumlah')
            ->get();
            
        $context = "Data Wisatawan:\n";
        foreach ($kunjunganData as $k) {
            $context .= "- {$k->nama_negara} ({$k->bulan}): {$k->jumlah}\n";
        }

        $systemPrompt = "Kamu adalah AI Assistant Dashboard Wisatawan Indonesia.\n" .
                        "Jawab pertanyaan berdasarkan data wisatawan yang tersedia.\n" .
                        "Jangan mengarang data.\n" .
                        "Gunakan bahasa Indonesia yang ramah.\n" .
                        "Berikan jawaban singkat dan padat.\n\n" .
                        $context;

        if ($groqApiKey) {
            // Gunakan API Groq (LLaMA 3)
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . $groqApiKey,
            ])->post("https://api.groq.com/openai/v1/chat/completions", [
                'model' => 'llama-3.3-70b-versatile',
                'messages' => [
                    ['role' => 'system', 'content' => $systemPrompt],
                    ['role' => 'user', 'content' => $question]
                ],
                'temperature' => 0.5,
                'max_tokens' => 512
            ]);

            if ($response->successful()) {
                $result = $response->json();
                $answer = $result['choices'][0]['message']['content'] ?? 'Maaf, saya tidak mengerti.';
                return response()->json(['answer' => $answer]);
            }

            $errorMsg = $response->json('error.message') ?? 'Gagal menghubungi Groq API.';
            return response()->json(['answer' => 'Error API Groq: ' . $errorMsg], 500);

        } else {
            // Gunakan API Gemini (Fallback)
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
            ])->post("https://generativelanguage.googleapis.com/v1beta/models/gemini-flash-latest:generateContent?key={$geminiApiKey}", [
                'contents' => [
                    [
                        'parts' => [
                            ['text' => $systemPrompt . "\n\nPertanyaan: " . $question]
                        ]
                    ]
                ]
            ]);

            if ($response->successful()) {
                $result = $response->json();
                $answer = $result['candidates'][0]['content']['parts'][0]['text'] ?? 'Maaf, saya tidak mengerti.';
                return response()->json(['answer' => $answer]);
            }

            $errorMsg = $response->json('error.message') ?? 'Gagal menghubungi Gemini API.';
            return response()->json(['answer' => 'Error API Gemini: ' . $errorMsg], 500);
        }
    }
}
