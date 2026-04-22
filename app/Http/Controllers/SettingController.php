<?php

namespace App\Http\Controllers;

use App\Models\Option;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function __construct(
        private Option $option,
    ) {
        $this->middleware('can:master-data.setting.menu-setting');
    }

    public function general()
    {
        $settings = $this->option
            ->whereIn('key', [
                'title',
                'description',
                'sidebar_logo_filepath'
            ])
            ->get();

        $data['title']              = $settings->first(fn($i) => $i->key == 'title')?->value;
        $data['description']        = $settings->first(fn($i) => $i->key == 'description')?->value;
        $sidebarLogoPath            = $settings->first(fn($i) => $i->key == 'sidebar_logo_filepath')?->value;
        $data['sidebar_logo_url']   = $sidebarLogoPath ? Storage::url($sidebarLogoPath) : null;
        $data = (object) $data;

        return view('setting.general', compact('data'));
    }

    public function generalStore(Request $request)
    {
        DB::beginTransaction();
        try {
            $this->saveSetting($request->all());
            
            DB::commit();
            
            return back()->with('success', 'Setting Berhasil Diupdate');
        } catch (\Throwable $th) {
            DB::rollBack();

            Log::error('Save setting error', [
                'error' => $th->getMessage(),
                'line'  => $th->getLine(),
                'file'  => $th->getFile(),
            ]);

            return back()->with('danger', 'Setting Gagal Diupdate');
        }
    }

    private function saveSetting(array $data)
    {
        if(@$data['title']) {
            $this->option->updateOrCreate([
                'key'   => 'title',
            ],[
                'value' => @$data['title'],
            ]);
        }

        if(@$data['description']) {
            $this->option->updateOrCreate([
                'key'   => 'description',
            ],[
                'value' => @$data['description'],
            ]);
        }

        if(@$data['sidebar_logo'] instanceof UploadedFile) {
            $this->option->updateOrCreate([
                'key'   => 'sidebar_logo_filepath',
            ],[
                'value' => @$data['sidebar_logo']->store('setting', 'public'),
            ]);
        }
    }
}
