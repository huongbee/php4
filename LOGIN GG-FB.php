"laravel/socialite": "^3.0",
or composer require laravel/socialite 

===================config/app.php=====================
'providers' => [
	Laravel\Socialite\SocialiteServiceProvider::class,
]

'aliases' => [
	'Socialite' => Laravel\Socialite\Facades\Socialite::class,
]

============config/services.php===========================
'github' => [
    'client_id' => 'your-github-app-id',
    'client_secret' => 'your-github-app-secret',
    'redirect' => 'http://your-callback-url',
],
======================Route===========================

Route::get('login/{provider}', [
	'as'=>'provider_login',
	'uses'=>'UserController@redirectToProvider'
]);
Route::get('login/{provider}/callback', [
	'as'=>'provider_login_callback',
	'uses'=>'UserController@handleProviderCallback'
]);



=====================Controller=======================
public function redirectToProvider($providers){
    return Socialite::driver($providers)->redirect();
}
  public function handleProviderCallback($providers){
    try{
        $socialUser = Socialite::driver($providers)->user();
        //return $user->getEmail();
    }
    catch(\Exception $e){
        //dd($e->getResponse()->getBody()->getContents());
        return redirect()->route('login')->with(['flash_level'=>'danger','flash_message'=>"Đăng nhập không thành công"]);
    }
    $socialProvider = SocialProvider::where('provider_id',$socialUser->getId())->first();
    if(!$socialProvider){
        //tạo mới
        $user = User::where('email',$socialUser->getEmail())->first();
        if($user){
          return redirect()->route('login')->with(['flash_level'=>'danger','flash_message'=>"Email đã có người sử dụng"]);
        }
        else{
          $user = new User();
          $user->email = $socialUser->getEmail();
          $user->name = $socialUser->getName();
          if($providers == 'google'){
            $image = explode('?',$socialUser->getAvatar());
            $user->avatar = $image[0];
          }
          $user->avatar = $socialUser->getAvatar();
          $user->save();
        }
        $provider = new SocialProvider();
        $provider->provider_id = $socialUser->getId();
        $provider->provider = $providers;
        $provider->email = $socialUser->getEmail();
        $provider->save();
    }
    else{
        $user = User::where('email',$socialUser->getEmail())->first();
    }
    Auth()->login($user);
    return redirect()->route('trangchu')->with(['flash_level'=>'success','flash_message'=>"Đăng nhập thành công"]);
  }




https://console.developers.google.com



  ================================== cURL error=====================================
  go to https://curl.haxx.se/ca/cacert.pem
  copy file to xampp/php/ext
  open php.ini add
  [cURL]
  curl.cainfo="D:\xampp\php\ext\cacert.pem"

  restart server 
