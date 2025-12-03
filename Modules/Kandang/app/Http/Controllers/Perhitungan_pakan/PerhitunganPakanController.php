<?php

namespace Modules\Kandang\Http\Controllers\Perhitungan_pakan;

use App\Http\Controllers\Controller;
use App\Models\User;
use Modules\Kandang\Models\PerhitunganPakan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\Kandang\Models\JenisPakan;
use Modules\Kandang\Models\Kandang;
use Modules\Kandang\Models\Pipe;

class PerhitunganPakanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $currentUserId = Auth::id();                     
        $Users = User::where('id', '!=',
         $currentUserId)->get(); 
        $listJenisPakan = JenisPakan::all();   
        $listPipe = Pipe::all();

        return view("kandang::perhitungan-pakan.create",
         compact('Users','listJenisPakan','listPipe'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
       
        $validated = $request->validate([
                'tanggal' => ['required', 'date'],
                'pipe_id' => ['required', 'exists:pipe,id'],
                'jenis_pakan_id' => ['required', 'exists:jenis_pakan,id'],
                'jumlah_ayam' => ['required', 'integer', 'min:1'],
                'jumlah_pakan_per_ekor_gram' => ['required', 'numeric', 'min:0'],
                'proporsi_pemberian_pagi' => ['required', 'numeric', 'between:0,100'],
                'proporsi_pemberian_sore' => ['required', 'numeric', 'between:0,100'],
                'jam_pemberian_pagi' => ['required', 'date_format:H:i', 'after_or_equal:05:00', 'before_or_equal:09:30'],
                'jam_pemberian_sore' => ['required', 'date_format:H:i', 'after_or_equal:15:00', 'before_or_equal:18:30'],
                'catatan' => ['nullable', 'string', 'max:500'],
        ]);
         $userId  = Auth::id();
         $executor = User::where('id', '!=', Auth::id())->get();

         $validated['user_creator_id'] = $userId;
         $validated['user_executor_id'] = $executor;
         dd($validated);

        //  PerhitunganPakan::create([
        //     'tanggal_pemberian pakan' => $validated["tanggal"],
        //     'user_cretor_id' => $userId,
        //     'user_executor_id' => $executor,
        //     'jenis_pakan_id' => $validated['jenis_pakan_id'],
        //     'pipe_id' => $validated['pipe_id'],
        //     'proposi_pemberian_pagi' => $validated['proposi_pemberian_pagi'],
        //      'proposi_pemberian_sore' => $validated['proposi_pemberian_sore'],
        //       'jam_pemberian_pagi' => $validated['jam_pemberian_pagi'],
        //  ])

        
    }

    /**
     * Display the specified resource.
     */
    public function show(PerhitunganPakan $perhitunganPakan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PerhitunganPakan $perhitunganPakan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PerhitunganPakan $perhitunganPakan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PerhitunganPakan $perhitunganPakan)
    {
        //
    }

    public function createSisaPakan()
    {
        return view("kandang::sisa-pakan.create");
    }
}
