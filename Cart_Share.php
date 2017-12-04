AppServiceProvider

view()->composer('header',function($view){
  if(Session::has('cart')){
    $oldCart = Session::get('cart');
    $cart = new Cart($oldCart);
    $view->with(['cart'=>Session::get('cart'),'product_cart'=>$cart->items,'totalPrice'=> $cart->totalPrice]);
  }
});
		
Controller
public function getAddToCart(Request $req,$id){
		$product = Product::find($id);
    	$oldCart = Session::has('cart') ? Session::get('cart') : null;
    	$cart = new Cart($oldCart);
    	$cart->add($product, $product->id);

    	$req->session()->put('cart', $cart);
    	return redirect()->back();
	}
	
$product['qty'] //lấy số lượng
$product['item']['name'] //Lấy phần tử trong mảng