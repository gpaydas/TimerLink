<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Url;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class UrlController extends Controller
{
    public function index()
    {
        return view('home');
    }

    public function kaydet()
    {

        $rules = [
            "period" => "required|numeric",
            "long_link" => "required|url"
        ];
    
        $customMessages = [
            'required' => 'Sure ve Link Alanı Boş Geçilemez.',
            'numeric' => 'Süre Sayı Girilmelidir!',
            'url' => 'Link url Olmalıdır!'
        ];
        $request=request()->all();
        $validator = Validator::make($request, $rules, $customMessages);

        if ($validator->fails()) {
            // session()->flash('mesaj_tur', 'danger');
            // session()->flash('mesaj', $validator->errors()->first());
            return response()->json(['success' => false,'msj'=>$validator->errors()->first()]
            ,400,
            ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'], JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES|JSON_PRETTY_PRINT
                                    );
        }
        $period_type = request('period_type');
        $period=request('period');
        $total=$period*$period_type;

        if ($total<=0)
        {
            return response()->json(['success' => false,'msj'=>'Süre Minumum 1 Dakika Olabilir...']
            ,400,
            ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'], JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES|JSON_PRETTY_PRINT
                                    );            
        }

        if ($total>7200)
        {
            return response()->json(['success' => false,'msj'=>'Süre Maksimum 5 Gün Olabilir...']
            ,400,
            ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'], JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES|JSON_PRETTY_PRINT
                                    );            
        }

        $url=url('/');
        $start_date = new Carbon('UTC');
        $end_date=new Carbon('UTC');
        $end_date=$end_date->addMinutes($total);

        $sonuc=Url::create(
            [
            'ipadress'=>request()->ip(),
            'long_link'=>request('long_link'),
            'short_link'=>"-",
            'start_date'=>$start_date->format('Y-m-d H:i:s'),
            'end_date'=>$end_date->format('Y-m-d H:i:s'),
            'period'=>request('period'),
            'period_type'=>request('period_type')
            ]
            );
        $sonuc_url=$url.'/'.'lnk/'.strtolower(Str::random(4)).$sonuc->id.strtolower(Str::random(5));
        Url::where('id', $sonuc->id)
            ->update(['short_link' => $sonuc_url]);
        return response()->json(['success' => true,'msj'=>$sonuc_url]
        ,200,
        ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'], JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES|JSON_PRETTY_PRINT
                                );
    }
}
