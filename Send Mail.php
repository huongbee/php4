.env

MAIL_DRIVER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=huonghuong08.php@gmail.com
MAIL_PASSWORD=*******
MAIL_ENCRYPTION=tls 

------------------------------------------------------------
mail.php

<?php

return [

    'driver' => env('MAIL_DRIVER', 'smtp'),
    'host' => env('MAIL_HOST', 'smtp.gmail.com'),
    'port' => env('MAIL_PORT', 587),
    'from' => [
        'address' => env('MAIL_USERNAME', 'huongnguyenak96@gmail.com'),
        'name' => env('MAIL_PASSWORD', 'Khoa Phạm Training'),
    ],
    'encryption' => env('MAIL_ENCRYPTION', 'tls'),
    'username' => env('MAIL_USERNAME'),
    'password' => env('MAIL_PASSWORD'),
    'sendmail' => '/usr/sbin/sendmail -bs',

];
---------------------------------------------------------------
php artisan config:cache


public function mail(){
    $products = M_Product::where('id',1)->first()->toArray();
	Mail::send('pages.send_email', ['products' => $products], function ($message)
	{
		$message->from('huongnguyen08.cv@gmail.com', 'hhhh');
		$message->to('huongnguyen08.cv@gmail.com','ngoc huong');
		$message->subject('Reset Password');
	});
	echo 'đã gửi';
}


//view 
{{$products['name']}}