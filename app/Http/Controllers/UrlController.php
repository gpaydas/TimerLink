<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Url;
use App\Models\UrlClick;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
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
        setlocale(LC_TIME, 'Turkish');
        $start_date = Carbon::now('Europe/Istanbul');
        $end_date= Carbon::now('Europe/Istanbul');
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

    public function yonlendir($url)
    {
        $int=strlen($url);
        $int=$int-9;
        if ($int<=0)
        {
            $data['title'] = '404';
            $data['name'] = 'Page not found';
            return response()
                ->view('errors.404');
        }
        else
        {
            $id_c=substr($url,4,$int);
            $sonuc=Url::where('id',$id_c)->firstOrFail();
            setlocale(LC_TIME, 'Turkish');
            $start_date = Carbon::now('Europe/Istanbul');
            if ($start_date > $sonuc->end_date)
            {
                return response()
                    ->view('errors.404');
            }
            else
            {
                $long_url=$sonuc->long_link;
                $click=$sonuc->click;
                UrlClick::create(
                    [
                        'ipadress'=>request()->ip(),
                        'url_id'=>$id_c
                    ]
                );
                // return redirect($long_url);
            }

            //  return response()
            //  ->view($long_url);
        }
    }

    public function list(){
       /* $sonuc=Url::all();*/
       $aktif= request()->input('aktif');
       $pasif= request()->input('pasif');
       $siralama= (!empty(request()->input('siralama'))) ? request()->input('siralama') : 1;

       $eksql="where 1=1";

       if (($aktif=="on") && ($pasif!="on")){$eksql=$eksql." and now()<=u.end_date";}
       if (($pasif=="on") && ($aktif!="on")){$eksql=$eksql." and now()>u.end_date";}
       if ($siralama==1){$alan="click_total"; $sira="desc";}
       else if ($siralama==2){$alan="click_total"; $sira="asc";}
       else if ($siralama==3){$alan="start_date"; $sira="desc";}
       else if ($siralama==4){$alan="start_date"; $sira="asc";}

        $sonuc = Url::select(DB::raw("*"))
            ->from(DB::raw("(SELECT u.*,
                            (case when now()>u.end_date then 'Bitti' else '' end) as durum,
                            (select count(*) from urlclick as uc where uc.url_id=u.id) as click_total
                             FROM url as u $eksql
                             ) as tab1"))
            ->orderBy($alan, $sira)
            ->paginate(8); /*sayfalandırma sağlıyor*/
        request()->flash();
        return view('admin.dashboard',compact('sonuc'));
   }

   public function userUpdate_form()
   {
    return view('admin.userupd');
   }

   public function userUpdate()
   {
    $user = Auth::user();
    $request=request()->all();
    
    $customMessages = [
        'name.required' => 'İsim Alanı Boş Geçilemez.',
        'email.required' => 'Mail Alanı Boş Geçilemez.'
    ];

    $rules = [
        'name' => 'required',
        'email' => 'required',
    ];
    $data = Validator::make($request, $rules, $customMessages);

    if ($data->fails()) {

        $errors = ['email' => $data->errors()->all()];
        return back()->withErrors($errors);
    }

    $user->name = $request['name'];
    $user->email = $request['email'];

    $user->save();

    $pass=$request['password'];
    if ($pass!=''){
        $user->password = bcrypt($pass);
        $user->save(); 
    }
    request()->session()->regenerate();
    return view('admin.userupd');
   }
}
