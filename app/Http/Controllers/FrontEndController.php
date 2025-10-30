<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use App\Models\Cart;
use App\Models\Citizen;
use App\Models\Stock;
use App\Models\Faq;
use App\Models\Division;
use App\Models\Content;
use App\Models\User;
use App\Models\Video;
use App\Models\ContentFile;
use App\Models\TemplateSetting;
use App\Models\Page;
use App\Models\Technology;
use App\Models\Varient;
use App\Models\Category;
use App\Models\Product;
use App\Models\Setting;
use App\Models\Order;
use App\Models\Country;
use App\Models\Notify;
use App\Models\Bank;
use App\Models\OrderDetail;
use App\Models\Payment;
use App\Models\Review;
use App\Models\PackingType;
use App\Models\Slider;
use App\Models\District;
use App\Models\Upazila;
use App\Models\GuestCart;
use App\Models\Otpvarification;
use App\Models\ShippingAddress;
use App\Models\OrderReturn;
use App\Models\OrderReturnDetail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Validator;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\SslCommerzPaymentController;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class FrontendController extends Controller
{
    public function index()
    {
        $main_categories = Category::withCount('SellProducts')->where([
            'parent_id' => 0,
            'status' => 1,
        ])->orderBy('sl', 'asc')->limit(4)->get();

        $featured_products = Product::where([
            'featured' => 1,
            'status' => 1,
            'type' => 1,
        ])->with('productVarient')->limit(12)->orderBy('discount_price')->get()->chunk(4);

        $sliders = Slider::where('status', 1)->orderBy('sl')->get();

        return view('frontend.index', compact('main_categories', 'featured_products', 'sliders'));
    }

    public function user_login(Request $request)
    {
        // dd($request->all());
        // $previousPath = parse_url(url()->previous(), PHP_URL_PATH);
        $login = $request->input('username');
        $password = $request->input('password');

        // Check if fields are empty
        if (!$login || !$password) {
            // return back()->withErrors(['login' => 'Please provide both login and password.'])->withInput();
            return response()->json([
                'status' => 'error',
                'message' => 'Please provide both login email or mbile and password'
            ], 404);
        }

        // Determine login type: email or mobile
        $loginType = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'mobile';

        $credentials = [
            $loginType => $login,
            'password' => $password,
        ];

        // Attempt login
        if (Auth::attempt($credentials)) {
            // $request->session()->regenerate();
            if (($request->product_id > 0) and ($request->quantity > 0)) {
                // $data['product_id'] = $request->product_id;
                // $data['varient'] = $request->varient;
                // $data['quantity'] = $request->quantity;

                // use Illuminate\Http\Request;
                $data = new Request([
                    'product_id' => $request->product_id,
                    'varient' => $request->varient,
                    'quantity' => $request->quantity,
                    'buy_now' => $request->buy_now ?? 0,
                ]);

                $get_info = $this->add_to_cart($data);
                if (($get_info->getData(true)['cart_id'] ?? '') != '') {
                    return response()->json([
                        'status' => 'success',
                        'message' => 'Login successfully',
                        'cart_id' => $get_info->getData(true)['cart_id'],
                    ], 200);
                }
            }

            return response()->json([
                    'status' => 'success',
                    'message' => 'Login successfully'
                ], 200);
            // Redirect to intended page or home
            // if ($previousPath == '/user-login') {
            //     return redirect()->intended('/admin');
            // } else {
            //     return back()->with('success', 'Login in successful');
            // }
        }

        // Login failed, redirect back with error
        return response()->json([
            'status' => 'error',
            'message' => 'Login unsuccessfully'
        ], 401);
    }

    // frontend about us page
    public function aboutus()
    {
        $page = Page::where('type', 1)->first();
        return view('frontend.aboutus', compact('page'));
    }
    // frontend contact us page
    public function contactus()
    {
        $page = Page::where('type', 2)->first();
        return view('frontend.contactus', compact('page'));
    }

    public function login()
    {
        return view('frontend.login');
    }

    public function registration(Request $request)
    {
        // dd($request->all());
        // if ($request->type == 1) {



            $request->validate([
                // 'type'          => 'required',
                'first_name'    => 'required|max:255',
                'last_name'     => 'required|max:255',
                'mobile'        => 'required|min:11|unique:users',
                // 'email'         => 'unique:users',
                'password'      => 'required|min:8',
            ]);

        // }
        // else {

        //     $request->validate([
        //         'type'              => 'required',
        //         'first_name'        => 'required|max:255',
        //         'last_name'         => 'required|max:255',
        //         'mobile'            => 'required|min:11|unique:users',
        //         'email'             => 'unique:users',
        //         'password'          => 'required|confirmed|min:8',
        //         'nid_no'            => 'required|unique:users',
        //         'bin_no'            => 'required|unique:users',
        //         'tin_no'            => 'required|unique:users',
        //         'image'             => 'required|mimes:jpeg,jpg,png',
        //         'nid'               => 'required|mimes:jpeg,jpg,png,pdf',
        //         'bin'               => 'required|mimes:jpeg,jpg,png,pdf',
        //         'tin'               => 'required|mimes:jpeg,jpg,png,pdf',
        //     ]);

        // }

        $user = new User;

        $user->role_id              = 0;
        $user->type                 = 1;
        $user->first_name           = $request->first_name;
        $user->last_name            = $request->last_name;
        $user->mobile               = $request->mobile;
        $user->email                = $request->email ?? '';
        $user->present_address      = $request->present_address ?? '';
        $user->password             = bcrypt($request->password);
        $user->nid_no               = $request->nid_no ?? '';
        $user->bin_no               = $request->bin_no ?? '';
        $user->tin_no               = $request->tin_no ?? '';
        $user->username               = Str::lower($request->first_name.$request->last_name.$user->id);
        $user->status           = 1;
        // if ($request->type == 1) {
        //     $user->status           = 1;
        // } else {
        //     $user->status           = 3;
        // }

        $user->save();

        // $user->username             = Str::lower($request->first_name.$request->last_name.$user->id);
        $user->created_by           = $user->id;

        $user->save();

        // Send notification of new corporate consumer or dealer
        // if ($request->type != 1) {
        //     $notification = new Notify;
        //     $notification->type = $request->type;
        //     if($request->type == 2){
        //         $notification->data = 'New Corporate Consumer account is pending';
        //     }else{
        //         $notification->data = 'New Dealer account is pending';
        //     }
        //     $notification->status = 1;
        //     $notification->save();
        // }

        if($request->hasFile('image'))
        {
            $cp = $request->file('image');
            $extension = strtolower($cp->getClientOriginalExtension());
            $randomFileName = $user->id.'image'.date('Y_m_d_his').'_'.rand(10000000,99999999).'.'.$extension;

            Storage::disk('public')->put('users/'.$randomFileName, File::get($cp));

            $user->image = $randomFileName;
            $user->save();
      	}
        if($request->hasFile('nid'))
        {
            $cp = $request->file('nid');
            $extension = strtolower($cp->getClientOriginalExtension());
            $randomFileName = $user->id.'nid'.date('Y_m_d_his').'_'.rand(10000000,99999999).'.'.$extension;

            Storage::disk('public')->put('nid/'.$randomFileName, File::get($cp));

            $user->nid = $randomFileName;
            $user->save();
      	}
        if($request->hasFile('bin'))
        {
            $cp = $request->file('bin');
            $extension = strtolower($cp->getClientOriginalExtension());
            $randomFileName = $user->id.'bin'.date('Y_m_d_his').'_'.rand(10000000,99999999).'.'.$extension;

            Storage::disk('public')->put('bin/'.$randomFileName, File::get($cp));

            $user->bin = $randomFileName;
            $user->save();
      	}
        if($request->hasFile('tin'))
        {
            $cp = $request->file('tin');
            $extension = strtolower($cp->getClientOriginalExtension());
            $randomFileName = $user->id.'tin'.date('Y_m_d_his').'_'.rand(10000000,99999999).'.'.$extension;

            Storage::disk('public')->put('tin/'.$randomFileName, File::get($cp));

            $user->tin = $randomFileName;
            $user->save();
      	}

        return back()->with('success', 'Registration Successful! Login to your account.');
    }

    // Notification redirect
    public function notificationRedirect($id, $type)
    {
        $notification = Notify::where('id', $id)->first();
        $notification->status = 2;
        $notification->read_at = date('Y-m-d H:i:s');
        $notification->save();

        if($type == 2){
            return redirect()->route('admin.customer.pending_corporate');
        }elseif($type == 3){
            return redirect()->route('admin.customer.pending_dealer');
        }else{
            return back();
        }
    }

    public function store_grid(Request $request)
    {
        $query = Product::where([
            'status' => 1,
            'type' => 1
        ]);
        if ($request->c) {
            $query = $query->where(function ($q1) use ($request) {
                $q1->whereIn('category_id', $request->c)->orWhereIn('sub_category_id', $request->c);
            });
        }
        if ($request->b) {

            $query = $query->whereIn('brand_id', $request->b);
        }

        if (isset($request->v) and $request->v != '') {
            $query->whereHas('productVarientData', function ($q) use ($request) {
                $q->whereHas('productInfo', function ($r) use ($q, $request) {
                    $r->where('has_varient', 1);
                    $q->where('varient_value_id', $request->v);
                });

            });
        }

        if (isset($request->range) and $request->range != '') {
            $range_data = explode('%3B', $request->range);
            $product_min_price_from = explode(";",$range_data[0])[0];
            $product_max_price_to = explode(";",$range_data[0])[1];


            $query = $query->where(function ($q2) use ($request,$range_data,$product_min_price_from,$product_max_price_to) {
                // $q1->whereIn('category_id', $request->c)->orWhereIn('sub_category_id', $request->c);
                $q2->whereHas('productVarient', function ($qq) use ($request) {
                    $range_data = explode('%3B', $request->range);
                    $product_min_price_from = explode(";",$range_data[0])[0];
                    $product_max_price_to = explode(";",$range_data[0])[1];

                    $qq->where('status', 1);
                    $qq->whereBetween('discount_price', [$product_min_price_from, $product_max_price_to]);
                })->OrWhereBetween('discount_price', [$product_min_price_from, $product_max_price_to])->where('has_varient',0);
            });




        }

        if (isset($request->searchProduct) and ($request->searchProduct != '')) {
            $query->where('name', 'like', '%'.$request->searchProduct.'%');
        }




        $paginate = 20;

        if ($request->per_page) {
            $paginate = $request->per_page;
        }

        if ($request->sort_option) {
            if ($request->sort_option == 1) {
                $query->orderBy('sl_price', 'ASC');
            }
            else if ($request->sort_option == 2) {
                $query->orderBy('sl_price', 'DESC');
            } else {
                $query->latest();
            }
        } else {
            $query->latest();
        }

        $products = $query->with('productVarient','productVarientData')->paginate($paginate);
        // dd($products);
        return view('frontend.store_grid', compact('products'));
    }

    public function store_category(Request $request,$id)
    {
        $products = Product::where([
            'type' => 1,
            'status' => 1,
            'category_id' => $id,
        ])->latest()->paginate(20);

        $category = Category::where('id',$id)->latest()->first();

        return view('frontend.store_category', compact('products','category'));
    }

    public function cart(Request $request)
    {

        // $carts = Cart::where('user_id', auth()->user()->id ?? 0)->with('productInfo','varientInfo')->latest()->get();

        // $setting = Setting::oldest()->first();
        return view('frontend.cart');
    }

    public function view_cart_section(Request $request)
    {

        $carts = Cart::where('user_id', auth()->user()->id ?? 0)->with('productInfo','varientInfo')->latest()->get();
        // $guest_carts = GuestCart::where('user_id', ($request->guest_id ?? 0))->with('productInfo','varientInfo')->latest()->get();
        $guest_carts = [];

        // $setting = Setting::oldest()->first();
        return view('frontend.view_cart_section', compact('carts','guest_carts'));
    }

    public function update_cart(Request $request)
    {
        if (in_array(0, $request->quantity)) {
            return redirect()->back()->with('error', 'Quantity must be at least 1');
        }

        foreach ($request->cart_id as $key => $cart_id) {
            $data['quantity'] = $request->quantity[$key];
            $data['update_by'] = auth()->user()->id;
            Cart::where('id',$cart_id)->update($data);
        }

        if (($request->checkout ?? 0) == 1) {
            return redirect()->route('checkout');
        }

        return back()->with('success', 'Your cart has been updated');
    }

    public function order_track(Request $request)
    {
        return view('frontend.order_track');
    }

    public function product_detail($id)
    {
        $id = Crypt::decryptString($id);
        $product = Product::where('id', $id)->with('productGallery')->latest()->first();
        if (!$product) {
            return back()->with('danger', "Product not found");
        }

        $reviews = Review::where('product_id', $id)->where('status', 1)->get();
        $review_count = Review::where('product_id', $id)->where('status', 1)->get()->count();
        $review_count1 = Review::where('product_id', $id)->where('status', 1)->where('rating', 1)->get()->count();
        $review_count2 = Review::where('product_id', $id)->where('status', 1)->where('rating', 2)->get()->count();
        $review_count3 = Review::where('product_id', $id)->where('status', 1)->where('rating', 3)->get()->count();
        $review_count4 = Review::where('product_id', $id)->where('status', 1)->where('rating', 4)->get()->count();
        $review_count5 = Review::where('product_id', $id)->where('status', 1)->where('rating', 5)->get()->count();
        $review_cal = Review::where('product_id', $id)->where('status', 1)->avg('rating');
        $review_avg = ceil($review_cal);

        if (($product->status ?? 0) == 0) {
            return back()->with('danger', "Product not found");
        }

        if ($product->has_varient == 1) {
            $pending_orders_quantity_array = array();
            foreach ($product->productVarient->where('status',1) as $key => $productVarientInfo) {
                $pending_orders_quantity_array[$productVarientInfo->id] = OrderDetail::where([
                    'product_id' => $product->id,
                    'varient_id' => $productVarientInfo->id,
                ])->whereHas('orderInfo', function($q){
                    $q->whereIn('status', [0,1])->where('type',2)->whereIn('delivery_status',[0,1]);
                })->sum('quantity');
            }

        } else {
            $pending_orders_quantity = OrderDetail::where([
                'product_id' => $product->id,
                'varient_id' => 0,
            ])->whereHas('orderInfo', function($q){
                $q->whereIn('status', [0,1])->where('type',2)->whereIn('delivery_status',[0,1]);
            })->sum('quantity');

            $pending_orders_quantity_array[$product->id] = $pending_orders_quantity;
        }


        $related_products = Product::inRandomOrder()->where('category_id', $product->category_id)->where('id', '!=', $id)->limit(4)->get();
        if (auth()->check()) {
            $latest_cart_item = Cart::where('user_id',auth()->user()->id)->latest()->first();
        } else {
            $latest_cart_item = null;
        }

        if (auth()->check()) {
            $user_review = Review::where([
                'user_id' => auth()->user()->id,
                'product_id' => $id,
            ])->latest()->first();

            $user_already_purchased = OrderDetail::where('product_id', $id)->whereHas('orderInfo', function ($q) {
                $q->where([
                    'user_id' => auth()->user()->id,
                    'status' => 1,
                    'delivery_status' => 3,
                    'payment_status' => 2
                ]);
            })->latest()->first();
        } else {
            $user_review = '';
            $user_already_purchased = '';
        }
        // dd($pending_orders_quantity_array);
        return view('frontend.product_detail', compact(
            'product',
            'related_products',
            'reviews',
            'review_count',
            'review_avg',
            'review_count1',
            'review_count2',
            'review_count3',
            'review_count4',
            'review_count5',
            'latest_cart_item',
            'user_review',
            'user_already_purchased',
            'pending_orders_quantity_array'
        ));
    }

    public function checkout(Request $request)
    {
        if ($request->cart_id and $request->cart_id != '') {
            $cart_id = Crypt::decryptString($request->cart_id);
            $carts = Cart::where([
                'user_id' => auth()->user()->id,
                'id' => $cart_id,
            ])->with('productInfo.productCategory','varientInfo')->latest()->get();
        } else {
            $carts = Cart::where('user_id', auth()->user()->id)->with('productInfo.productCategory','varientInfo')->latest()->get();
        }

        if (count($carts) == 0) {
            return back()->with('error','Your cart is empty, please add item first for checkout');
        }
        $setting = Setting::oldest()->first();
        $shipping_addresses = ShippingAddress::where('user_id', auth()->user()->id)->latest()->get();
        return view('frontend.checkout', compact('carts','setting','shipping_addresses'));
    }

    public function account()
    {
        if (Auth::user()) {

            $user = User::where('id', Auth::id())->first();
            return view('customer.index', compact('user'));

        } else {

            return redirect()->route('index');

        }
    }

    public function edit_info(Request $request, User $user)
    {

        // if ($user->type == 1) {
            $request->validate([
                'first_name'    => 'required|max:255',
                'last_name'     => 'required|max:255',
                'mobile'        => 'required|min:11|unique:users,mobile,'.$user->id,
                'email'         => 'email|unique:users,email,'.$user->id,
            ]);
        // } else {
        //     $request->validate([
        //         'first_name'        => 'required|max:255',
        //         'last_name'         => 'required|max:255',
        //         'mobile'            => 'required|min:11|unique:users,mobile,'.$user->id,
        //         'email'             => 'email|unique:users,email,'.$user->id,
        //         'nid_no'            => 'required|unique:users,nid_no,'.$user->id,
        //         'bin_no'            => 'required|unique:users,bin_no,'.$user->id,
        //         'tin_no'            => 'required|unique:users,tin_no,'.$user->id,
        //     ]);
        // }

        // if ($user->type == 1) {
            $user->first_name           = $request->first_name;
            $user->last_name            = $request->last_name;
            $user->mobile               = $request->mobile;
            $user->email                = $request->email;
            $user->present_address                = $request->present_address;
            $user->permanent_address                = $request->permanent_address;

            if($request->hasFile('image'))
            {
                $cp = $request->file('image');
                $extension = strtolower($cp->getClientOriginalExtension());
                $randomFileName = $user->id.'image'.date('Y_m_d_his').'_'.rand(10000000,99999999).'.'.$extension;

                #delete old rows of profilepic
                Storage::disk('public')->put('users/'.$randomFileName, File::get($cp));

                if($user->image)
                {
                    $f = 'users/'.$user->image;
                    if(Storage::disk('public')->exists($f))
                    {
                        Storage::disk('public')->delete($f);
                    }
                }

                $user->image = $randomFileName;
                $user->save();
            }

            $user->save();
        // } else {
        //     $user->first_name           = $request->first_name;
        //     $user->last_name            = $request->last_name;
        //     $user->mobile               = $request->mobile;
        //     $user->email                = $request->email;
        //     $user->nid_no               = $request->nid_no;
        //     $user->bin_no               = $request->bin_no;
        //     $user->tin_no               = $request->tin_no;

        //     $user->save();

        //     $user->username             = Str::lower($request->first_name.$request->last_name.$user->id);
        //     $user->updated_by           = $user->id;

        //     $user->save();

        //     if($request->hasFile('image'))
        //     {
        //         $cp = $request->file('image');
        //         $extension = strtolower($cp->getClientOriginalExtension());
        //         $randomFileName = $user->id.'image'.date('Y_m_d_his').'_'.rand(10000000,99999999).'.'.$extension;

        //         Storage::disk('public')->put('users/'.$randomFileName, File::get($cp));

        //         if($user->image)
        //         {
        //             $f = 'users/'.$user->image;

        //             if(Storage::disk('public')->exists($f))
        //             {
        //                 Storage::disk('public')->delete($f);
        //             }
        //         }

        //         $user->image = $randomFileName;
        //         $user->save();
        //     }
        //     if($request->hasFile('nid_new'))
        //     {
        //         $cp = $request->file('nid_new');
        //         $extension = strtolower($cp->getClientOriginalExtension());
        //         $randomFileName = $user->id.'nid'.date('Y_m_d_his').'_'.rand(10000000,99999999).'.'.$extension;

        //         Storage::disk('public')->put('nid/'.$randomFileName, File::get($cp));

        //         if($user->nid)
        //         {
        //             $f = 'nid/'.$user->nid;

        //             if(Storage::disk('public')->exists($f))
        //             {
        //                 Storage::disk('public')->delete($f);
        //             }
        //         }

        //         $user->nid = $randomFileName;
        //         $user->save();
        //     }
        //     if($request->hasFile('bin_new'))
        //     {
        //         $cp = $request->file('bin_new');
        //         $extension = strtolower($cp->getClientOriginalExtension());
        //         $randomFileName = $user->id.'bin'.date('Y_m_d_his').'_'.rand(10000000,99999999).'.'.$extension;

        //         Storage::disk('public')->put('bin/'.$randomFileName, File::get($cp));

        //         if($user->bin)
        //         {
        //             $f = 'bin/'.$user->bin;

        //             if(Storage::disk('public')->exists($f))
        //             {
        //                 Storage::disk('public')->delete($f);
        //             }
        //         }

        //         $user->bin = $randomFileName;
        //         $user->save();
        //     }
        //     if($request->hasFile('tin_new'))
        //     {
        //         $cp = $request->file('tin_new');
        //         $extension = strtolower($cp->getClientOriginalExtension());
        //         $randomFileName = $user->id.'tin'.date('Y_m_d_his').'_'.rand(10000000,99999999).'.'.$extension;

        //         Storage::disk('public')->put('tin/'.$randomFileName, File::get($cp));

        //         if($user->tin)
        //         {
        //             $f = 'tin/'.$user->tin;

        //             if(Storage::disk('public')->exists($f))
        //             {
        //                 Storage::disk('public')->delete($f);
        //             }
        //         }

        //         $user->tin = $randomFileName;
        //         $user->save();
        //     }
        // }

        return back()->with('success', 'Information Updated Successfully.');
    }

    public function edit_address(Request $request, User $user)
    {
        if ($request->present_address) {

            $request->validate([
                'present_address' => 'required',
            ]);

            $user->present_address      = $request->present_address;
        }

        if ($request->permanent_address) {

            $request->validate([
                'permanent_address' => 'required',
            ]);

            $user->permanent_address    = $request->permanent_address;
        }

        $user->save();

        return redirect()->back();
    }

    public function edit_password(Request $request, User $user)
    {
        $request->validate([
            'password' => 'required|confirmed|min:8',
            'current_password' => 'required',
        ]);

        $old_password = User::where('id', $user->id)->first();

        if (!empty($old_password))
        {
            $password = Hash::check($request->current_password, $old_password->password);
            if ($password)
            {
                $current_user = User::find($user->id);
                $current_user->password = bcrypt($request->password);
                $current_user->updated_by = Auth::id();

                $current_user->save();

                return back()->with('success', 'Password Updated Successfully');

            } else {
                return back()->with('error', 'Password did not matched!');
            }
        } else {
            return back()->with('error', 'Password can not be empty');
        }
    }

    public function set_local_value(Request $request)
    {
        if(Session::get('lang') == 'en'){
            $request->session()->put('lang', 'bn');
        } else {
            $request->session()->put('lang', 'en');
        }
        return redirect()->back();
    }

    public function query()
    {
        $wings = Wing::where('status',1)->get();
        return view('frontend.query', compact('wings'));
    }

    public function page_details($id,$slag)
    {
        $page = Page::where('id',$id)->latest()->first();
        return view('frontend.pageDetails', compact('page'));
    }

    public function user_logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }



    public function add_to_cart(Request $request)
    {
        if($request->quantity <= 0){
            return response()->json([
                'status' => 'error',
                'message' => 'Quantity must be at least 1'
            ], 404);
        }
        $check_cart = Cart::where([
            'product_id' => $request->product_id,
            'variation_id' => $request->varient,
            'user_id' => auth()->user()->id,
        ])->first();

        $check_stock = Stock::where([
            'product_id' => $request->product_id,
            'varient_id' => $request->varient,
        ])->latest()->first();

        $pending_order_quantity = OrderDetail::where([
            'product_id' => $request->product_id,
            'varient_id' => $request->varient,
        ])->whereHas('orderInfo', function($q){
            $q->whereIn('status', [0,1])->where('type',2)->whereIn('delivery_status',[0,1]);
        })->sum('quantity');

        $quantity = $check_stock->quantity ?? 0;


        if ($check_cart and ($request->buy_now ?? 0) == 0) {
            if (($quantity - $pending_order_quantity) < ($check_cart->quantity + $request->quantity)) {
                // if($request->ajax()){
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Quantity is out of stock'
                    ], 404);
                // }
            }


            $check_cart->quantity = $check_cart->quantity + $request->quantity;
            $check_cart->save();

            // if($request->ajax()){
                return response()->json([
                    'status' => 'success',
                    'message' => 'Update your cart successfully'
                ], 200);
            // }


        } else {
            if (($quantity - $pending_order_quantity) < $request->quantity) {
                // if($request->ajax()){
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Quantity is out of stock'
                    ], 404);
                // }
            }

            $cart_items = new Cart;
            $cart_items->product_id = $request->product_id;
            $cart_items->variation_id = $request->varient;
            $cart_items->quantity = $request->quantity;
            $cart_items->created_by = auth()->user()->id;
            $cart_items->user_id = auth()->user()->id;
            $cart_items->save();
        }

        if (($request->buy_now ?? 0) == 1) {
            if($request->ajax()){
                return response()->json([
                    'status' => 'success',
                    'message' => 'Added to your cart successfully',
                    'cart_id' => Crypt::encryptString($cart_items->id),
                ], 200);
            } else {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Added to your cart successfully',
                    'cart_id' => Crypt::encryptString($cart_items->id),
                ], 200);
            }
        }



        if($request->ajax()){
            return response()->json([
                'status' => 'success',
                'message' => 'Added to your cart successfully'
            ], 200);
        } else {
            return response()->json([
                'status' => 'success',
                'message' => 'Added to your cart successfully'
            ], 200);
        }
    }

    public function buy_add_to_cart(Request $request)
    {
        if($request->quantity <= 0){
            return response()->json([
                'status' => 'error',
                'message' => 'Quantity must be at least 1'
            ], 404);
        }

        $check_stock = Stock::where([
            'product_id' => $request->product_id,
            'varient_id' => $request->varient,
        ])->latest()->first();

        $quantity = $check_stock->quantity ?? 0;

        $pending_order_quantity = OrderDetail::where([
            'product_id' => $request->product_id,
            'varient_id' => $request->varient,
        ])->whereHas('orderInfo', function($q){
            $q->whereIn('status', [0,1])->where('type',2)->whereIn('delivery_status',[0,1]);
        })->sum('quantity');


        if (($quantity - $pending_order_quantity) < $request->quantity) {
            if($request->ajax()){
                return response()->json([
                    'status' => 'error',
                    'message' => 'Quantity is out of stock'
                ], 404);
            }
        }

        $cart_items = new Cart;
        $cart_items->product_id = $request->product_id;
        $cart_items->variation_id = $request->varient;
        $cart_items->quantity = $request->quantity;
        $cart_items->created_by = auth()->user()->id;
        $cart_items->user_id = auth()->user()->id;
        $cart_items->save();




        if($request->ajax()){
            return response()->json([
                'status' => 'success',
                'message' => 'Added to your cart successfully',
                'cart_id' => Crypt::encryptString($cart_items->id),
            ], 200);
        }
    }

    public function guest_add_to_cart(Request $request)
    {
        if (auth()->check()) {
            return $this->add_to_cart($request);
        } else {
            if($request->quantity <= 0){
                return response()->json([
                    'status' => 'error',
                    'message' => 'Quantity must be at least 1'
                ], 404);
            }
            $check_cart = GuestCart::where([
                'product_id' => $request->product_id,
                'variation_id' => $request->varient,
                'user_id' => $request->guest_id,
            ])->first();

            $check_stock = Stock::where([
                'product_id' => $request->product_id,
                'varient_id' => $request->varient,
            ])->latest()->first();

            $quantity = $check_stock->quantity ?? 0;


            if ($check_cart) {
                if ($quantity < ($check_cart->quantity + $request->quantity)) {
                    if($request->ajax()){
                        return response()->json([
                            'status' => 'error',
                            'message' => 'Quantity is out of stock'
                        ], 404);
                    }
                }


                $check_cart->quantity = $check_cart->quantity + $request->quantity;
                $check_cart->save();

                if($request->ajax()){
                    return response()->json([
                        'status' => 'success',
                        'message' => 'Update your cart successfully'
                    ], 404);
                }


            } else {
                if ($quantity < $request->quantity) {
                    if($request->ajax()){
                        return response()->json([
                            'status' => 'error',
                            'message' => 'Quantity is out of stock'
                        ], 404);
                    }
                }
                $data['product_id'] = $request->product_id;
                $data['variation_id'] = $request->varient;
                $data['quantity'] = $request->quantity;
                $data['user_id'] = $request->guest_id;
                GuestCart::create($data);
            }

            if($request->ajax()){
                return response()->json([
                    'status' => 'success',
                    'message' => 'Added to your cart successfully'
                ], 200);
            }
        }
    }

    public function remove_cart_item(Request $request)
    {
        $check_cart = Cart::find($request->id)->delete();

        return redirect()->back()->with('success','Item removed from your cart');
    }

    public function remove_guest_cart_item(Request $request)
    {
        $check_cart = GuestCart::find($request->id)->delete();

        return redirect()->back()->with('success','Item removed from your cart');
    }

    public function checkout_complete(Request $request)
    {
        // dd($request->all());

        if (in_array($request->delivery_option, [1,2])   ) {
            return redirect()->back()->with('error', 'Please use proper delivery option.');
        }

        if ($request->delivery_option == 2) {

            $sslCommerz = new SslCommerzPaymentController();
            return $sslCommerz->index($request);

        } else if ($request->delivery_option == 1) {

            DB::transaction(function () use ($request) {
                $data = $request->all();
                // dd($data);


                $productIds = [];
                foreach ($request->cart_id as $key => $cartId) {
                    $productIds[$key] = Crypt::decryptString($cartId);
                }
                // shipping_area  = 1 = inside dhaka
                // shipping_area  = 2 = outside dhaka
                $carts = Cart::where('user_id', auth()->user()->id)->whereIn('id',$productIds)->with('productInfo','varientInfo')->latest()->get();

                $shipping_address = ShippingAddress::where('id', $request->shipping_address)->where('user_id', auth()->user()->id)->latest()->first();
                if (!$shipping_address) {
                    return back()->with('error', "Shipping address not found");
                }

                if (count($carts) == 0) {
                    return back()->with('error', "Your cart is empty");
                }

                $product_total_price = 0; // total sale price
                $product_before_discount = 0;
                foreach ($carts as $key => $cart) {
                    if ($cart->variation_id == 0) {
                        $product_total_price +=  ($cart->productInfo->discount_price ?? 0)  * $cart->quantity;
                        $product_before_discount +=  ($cart->productInfo->price ?? 0)  * $cart->quantity;
                    } else {
                        $product_total_price +=  ($cart->varientInfo->discount_price ?? 0)  * $cart->quantity;
                        $product_before_discount +=  ($cart->varientInfo->price ?? 0)  * $cart->quantity;
                    }
                }

                $tracking_code = date("yhis");
                $order_data['tracking_code'] = $tracking_code;
                $order_data['user_id'] = auth()->user()->id;
                $order_data['status'] = 0;
                $order_data['payment_status'] = 1; // 1 means pending helper function check
                $order_data['total_price'] = $product_total_price;
                $order_data['grand_total_price'] = $product_total_price + ($shipping_address->divisionInfo->shipping_cost ?? 0);
                $order_data['discount_amount'] = 0;
                $order_data['coupon_discount'] = 0;
                $order_data['shipping_cost'] = $shipping_address->divisionInfo->shipping_cost ?? 0;
                $order_data['type'] = 2;
                $order_data['vat'] = $request->vat ?? 0;
                $order_data['tax'] = $request->tax ?? 0;
                $order_data['shipping_address'] = $request->shipping_address ?? "";
                $order_data['ship_different_address'] = 0;
                $order_data['delivery_status'] = 0;
                $order_data['shipping_area'] = $request->shipping_area ?? 0;
                $order_data['personal_vehicle'] = $request->personal_vehicle ?? 0;
                $order_data['delivery_option'] = $request->delivery_option ?? 0;
                $order_data['transaction_id'] = $tracking_code;



                $order = Order::create($order_data);

                foreach ($carts as $key => $cart) {
                    $order_detail['order_id'] = $order->id;
                    $order_detail['product_id'] = $cart->product_id;
                    $order_detail['quantity'] = $cart->quantity;
                    $order_detail['varient_id'] = $cart->variation_id;

                    if ($cart->variation_id == 0){
                        $order_detail['f_price'] = $cart->productInfo->price ?? 0;
                        $order_detail['price'] = $cart->productInfo->discount_price ?? 0;
                        $order_detail['discount'] = $cart->productInfo->discount ?? 0;
                        $order_detail['discount_type'] = $cart->productInfo->discount_type ?? 0;
                    } else {
                        $order_detail['f_price'] = $cart->varientInfo->price ?? 0;
                        $order_detail['price'] = $cart->varientInfo->discount_price ?? 0;
                        $order_detail['discount'] = $cart->varientInfo->discount ?? 0;
                        $order_detail['discount_type'] = $cart->varientInfo->discount_type ?? 0;
                    }

                    OrderDetail::create($order_detail);
                }

                $payment_data['user_id'] = auth()->user()->id;
                $payment_data['order_id'] = $order->id;
                $payment_data['amount'] = $order->grand_total_price;
                $payment_data['payment_method'] = $request->delivery_option ?? 0; // 1 = cash on delivery, 2 = bkash, 3 = online payment
                $payment_data['bank_id'] = $request->bank_id ?? "";

                if (isset($request->document) and $request->file('document')) {
                    $path = $request->file('document')->store('/public/document');
                    $path = Str::replace('public/document', '', $path);
                    $payment_data['document'] = Str::replace('/', '', $path);
                }

                if (isset($request->mb_document) and $request->file('mb_document')) {
                    $path = $request->file('mb_document')->store('/public/mb_document');
                    $path = Str::replace('public/mb_document', '', $path);
                    $payment_data['mb_document'] = Str::replace('/', '', $path);
                }

                $payment_data['status'] = 1; // helper function payment functon check
                $payment_data['type'] = 1;
                $payment_data['mb_sender_no'] = $request->mb_sender_no ?? "";
                $payment_data['mb_receiver_no'] = $request->mb_receiver_no ?? "";
                $payment_data['created_by'] = auth()->user()->id;

                Payment::create($payment_data);

                // Cart::where('user_id', auth()->user()->id)->delete();
                Cart::where('user_id', auth()->user()->id)->whereIn('id',$productIds)->delete();




            });
            return redirect()->route('account_orders')->with('success','Your order is under review');
        }

    }

    // User order list
    public function account_orders(Request $request)
    {
        $user = Auth::user();
        $orders = Order::where('user_id', $user->id)->latest()->paginate(20);

        return view('customer.orderList', compact('user', 'orders', 'request'));
    }

    public function order_return(Request $request)
    {
        $user = Auth::user();

        if ($request->order_no and $request->order_no != '') {
            $order = Order::where([
                'user_id' => $user->id,
                'tracking_code' => $request->order_no,
                'status' => 1,
                'delivery_status' => 3,
            ])->latest()->with('orderDetails.returnOrderInfo.orderDetails')->first();
        } else {
            $order = '';
        }

        return view('customer.order_return', compact('order'));
    }

    // User order details page
    public function orderDetails(Request $request, $orderId)
    {
        $user = Auth::user();
        $orderDetails = Order::with('orderDetails')->where('id', $orderId)->first();
        $setting = Setting::oldest()->first();

        return view('customer.order_details', compact('user', 'orderDetails', 'setting', 'request'));
    }

    // User dashboard address
    // public function account_address(Request $request)
    // {
    //     $user = Auth::user();
    //     return view('customer.accountAddress', compact('user', 'request'));
    // }

    // User account details
    public function accountDetails(Request $request)
    {
        $user = Auth::user();
        return view('customer.accountDetails', compact('user'));
        // return view('frontend.userDashboard.accountDetails', compact('user', 'request'));
    }

    // User account password
    public function accountPassword(Request $request)
    {
        $user = Auth::user();
        return view('customer.accountPassword', compact('user', 'request'));
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function getOrderTrack(Request $request)
    {
        $validation = Validator::make($request->all(),
        [
            'tracking_code'     => 'required',
            'mobile'      => 'required'
        ]);
        if($validation->fails())
        {
            return back()
            ->withInput()->withErrors('Please, fillup the form correctly and try again.');
        }

        $order = Order::where([
            'tracking_code' => $request->tracking_code,
            'type' => 2,
            'phone' => $request->mobile
        ])->first();

        // if($order){
        //     $order = $order;
        // }
        // else{
        //     $order = '';
        // }

        return view('frontend.order_track_details',[
            'order'=>$order
        ]);

    }

    public function forget_password(Request $request)
    {
        $request->validate([
            'email'           => 'required',
        ]);

        $t=time();
        $x = $t.date("Ymd",$t);

        $user = User::where('email', $request->email)->first();

        if ($user == null) {
            return redirect()->back()->with('error','Email not found.');
        } else {
            $user->remember_token = $x.rand(10000,99999);
            $user->save();
        }

        $setting = Setting::oldest()->first();

        $msg = ($setting->title ?? "").' - Password Recovery';

        Mail::to($request->email)->send(new PasswordRecovery($user,$msg,$setting));

        return redirect()->back()->with('success', 'Password reset mail has been given to your mail.');

    }

    public function getDistrictsAJAX(Request $request)
    {

        $districts = District::where('division_id', $request->division_id)->where('status', 1)->orderBy('name')->get();

        return response()->json([
            'districts' => $districts,
        ]);
    }

    public function getUpazilasAJAX(Request $request)
    {

        $upazilas = Upazila::where('district_id', $request->district_id)->where('status', 1)->orderBy('name')->get();

        return response()->json([
            'upazilas' => $upazilas,
        ]);
    }

    public function cancel_order(Request $request, $order_id)
    {
        $order = Order::where('id', $order_id)->first();

        if ($order->status != 0) {
            return redirect()->back()->with('success', 'Order Cancelation not possible at this stage!');
        }

        $request->validate([
            'remark' => 'required',
        ]);



        $order->remark  = $request->remark;
        $order->status  = 2;
        // $order->stage   = 5;

        $order->save();

        return redirect()->back()->with('success', 'Order Canceled Successfully!');
    }

    public function guest_cart_view(Request $request)
    {
        $carts = GuestCart::where('user_id', $request->guest_id)->with('productInfo','varientInfo')->latest()->get();
        return view('frontend.guest_cart_view', compact('carts'));
    }

    public function sign_up()
    {
        return view('frontend.sign_up');
    }

    public function sent_otp_code(Request $request)
    {
        $validated = $request->validate([
            'phone_number' => 'required|regex:/^01[3-9]\d{8}$/|unique:users,mobile',
        ], [
            'phone_number.required' => __('The phone number is required'),
            'phone_number.regex' => __('The phone number must follow the valid pattern'),
            'phone_number.unique' => __('This phone number is already taken'),
        ]);


        $phoneNumber = $request->phone_number;

        // Generate a random 6-digit OTP
        $otp = rand(100000, 999999);

        // Save OTP to the database
        $user = new Otpvarification;
        $user->mobile = $phoneNumber;
        $user->otp_code = $otp;
        $user->verification_expire = Carbon::now()->addMinutes(15);
        $user->save();

        $check_user_in_user_table = User::where('mobile', $request->phone_number)->first();


        if ($check_user_in_user_table) {
            return response()->json(['message' => __('User already exist')], 400);
        }


        // Send OTP via SMS using Nexmo
        if(($request->phone_number) != ''){
            $data['number'] = $request->phone_number;
            $data['message'] = 'Your verification code for registration is: '.$otp;

            $this->sms_send($data);
        }

        return response()->json(['message' =>  __('OTP sent successfully, use OTP within 15 minutes.'), 'phone_number' => $phoneNumber]);
    }

    public function sent_forgot_password_otp_code(Request $request)
    {
        $validated = $request->validate([
            'phone_number' => 'required|regex:/^01[3-9]\d{8}$/',
        ], [
            'phone_number.required' => __('The phone number is required'),
            'phone_number.regex' => __('The phone number must follow the valid pattern'),
            // 'phone_number.unique' => __('This phone number is already taken'),
        ]);


        $phoneNumber = $request->phone_number;

        // Generate a random 6-digit OTP
        $otp = rand(100000, 999999);
        $check_user_in_user_table = User::where('mobile', $request->phone_number)->first();

        if (!$check_user_in_user_table) {
            return response()->json(['message' => __('Mobile number not exists')], 400);
        }

        // Save OTP to the database
        $user = new Otpvarification;
        $user->mobile = $phoneNumber;
        $user->otp_code = $otp;
        $user->verification_expire = Carbon::now()->addMinutes(15);
        $user->save();




        // Send OTP via SMS using Nexmo
        if(($request->phone_number) != ''){
            $data['number'] = $request->phone_number;
            $data['message'] = 'Your verification code for reset password is: '.$otp;

            $this->sms_send($data);
        }

        return response()->json(['message' =>  __('OTP sent successfully, use OTP within 15 minutes.'), 'phone_number' => $phoneNumber]);
    }

    public function sms_send($data)
    {
        $url = "http://bulksmsbd.net/api/smsapi";
        $api_key = "y3FfVATWkcvMDn67cNkp";
        $senderid = "8809617611033";
        $number = $data['number'];
        $message = $data['message'];

        $data = [
            "api_key" => $api_key,
            "senderid" => $senderid,
            "number" => $number,
            "message" => $message
        ];
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $response = curl_exec($ch);
        curl_close($ch);
        return $response;
    }

    public function resendOtp(Request $request)
    {
        // $request->validate([
        //     'phone_number' => 'required|regex:/^01[3-9]\d{8}$/|unique:users,mobile', // E.164 phone number format
        // ]);
        $validated = $request->validate([
            'phone_number' => 'required|regex:/^01[3-9]\d{8}$/|unique:users,mobile',
        ], [
            'phone_number.required' => __('The phone number is required'),
            'phone_number.regex' => __('The phone number must follow the valid pattern'),
            'phone_number.unique' => __('This phone number is already taken'),
        ]);

        $phoneNumber = $request->phone_number;

        // Generate a new OTP
        $otp = rand(100000, 999999);

        // Save the new OTP to the database
        Otpvarification::updateOrCreate(
            ['mobile' => $phoneNumber],
            ['otp_code' => $otp, 'verification_expire' => Carbon::now()->addMinutes(15)]
        );

        // Send the new OTP via SMS
        if(($request->phone_number) != ''){
            $data['number'] = $request->phone_number;
            $data['message'] = 'Your verification code for registration is: '.$otp;

            $this->sms_send($data);
        }

        return response()->json(['message' => __('OTP resent successfully')]);
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'phone_number' => 'required|regex:/^01[3-9]\d{8}$/|unique:users,mobile',
            'otp' => 'required|numeric',
        ]);

        $phoneNumber = $request->phone_number;
        $otp = $request->otp;

        // Check if OTP exists and is valid
        $otpRecord = Otpvarification::where('mobile', $phoneNumber)->whereDate('verification_expire', '<', date('Y-m-d h:i:s'))->where('otp_code', $otp)->first();

        if (!$otpRecord) {
            return response()->json(['message' => 'Invalid OTP'], 400);
        }

        $user = new User;
        $user->role_id = 0;
        $user->type  = 1;
        $user->first_name           = $request->first_name;
        $user->last_name            = $request->last_name;
        $user->email = $request->email ?? '';
        $user->present_address      = $request->present_address ?? '';
        $user->status = 1;
        $user->username               = Str::lower($request->first_name.$request->last_name.$user->id);
        $user->mobile = $request->phone_number;
        $user->nid_no               = $request->nid_no ?? '';
        $user->bin_no               = $request->bin_no ?? '';
        $user->tin_no               = $request->tin_no ?? '';
        // $user->otp_code = $otp;
        $user->password = Hash::make($request->password);
        $user->save();

        $user->created_by           = $user->id;

        $user->save();
        // OTP is correct, proceed with registration
        $otpRecord->delete();

        $data = new Request([
            'product_id' => $request->product_id,
            'varient' => $request->varient,
            'username' => $request->phone_number,
            'quantity' => $request->quantity,
            'password' => $request->password,
            'buy_now' => $request->buy_now ?? 0,
        ]);

        $get_info = $this->user_login($data);

        if (($get_info->getData(true)['cart_id'] ?? '') != '') {
            return response()->json([
                'status' => 'success',
                'message' => 'OTP verified successfully',
                'cart_id' => $get_info->getData(true)['cart_id'],
            ], 200);
        }

        return response()->json(['message' => __('OTP verified successfully')]);

    }

    public function forgot_password_otp_verify(Request $request)
    {
        $request->validate([
            'phone_number' => 'required|regex:/^01[3-9]\d{8}$/',
            'recover_otp' => 'required|numeric',
        ]);

        $phoneNumber = $request->phone_number;
        $otp = $request->recover_otp;

        // Check if OTP exists and is valid
        $otpRecord = Otpvarification::where('mobile', $phoneNumber)->whereDate('verification_expire', '<', date('Y-m-d h:i:s'))->where('otp_code', $otp)->first();

        if (!$otpRecord) {
            return response()->json(['message' => 'Invalid OTP'], 400);
        }

        if ($request->new_password !== $request->confirm_password) {
            return response()->json(['message' => 'New Password and Confirm Password not matched'], 400);
        }

        $user = User::where('mobile', $phoneNumber)->first();
        $user->password = Hash::make($request->new_password);
        $user->save();

        // OTP is correct, proceed with registration
        $otpRecord->delete();

        return response()->json(['message' => __('Password reset successfull')], 200);

    }

    public function check_auth()
    {
        if (auth()->check()) {
            return response()->json([
                'status' => 'success',
                'code' => 200
            ], 200);
        } else {
            return response()->json([
                'status' => 'success',
                'code' => 401
            ], 200);
        }
    }

    public function page_info($slug)
    {
        $page = Page::where('slug',$slug)->latest()->first();
        return view('frontend.page_info', compact('page'));
    }

    public function return_order(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'order_id' => 'required',
            'reason' => 'required',
        ]);

        if (!isset($request->details_id) or count($request->details_id) == 0) {
            return redirect()->back()->with('error', 'Please select at least one product to return.');
        }

        $quantity_sum = array_sum($request->details_id);

        if ($quantity_sum <= 0) {
            return redirect()->back()->with('error', 'Please select at least one product to return.');
        }

        $order_id = Crypt::decryptString($request->order_id);

        $order = Order::where('id', $order_id)->first();

        foreach ($request->details_id as $detail_id => $quantity) {
            if ($quantity > 0) {
                $detail_id = Crypt::decryptString($detail_id);
                $order_detail = OrderDetail::where([
                    'id' => $detail_id,
                ])->first();

                if ($order_detail) {
                    if ($order_detail->quantity < $quantity) {
                        return redirect()->back()->with('error', 'Return quantity exceeds ordered quantity for a product.');
                    }
                    $check_already_returned = OrderReturnDetail::where([
                        'order_id' => $order->id,
                        'varient_id' => $order_detail->varient_id,
                        'product_id' => $order_detail->product_id,
                    ])->whereHas('orderReturnInfo', function($q) use ($order) {
                        $q->whereIn('status', [0,1])->where('order_id', $order->id);
                    })->sum('quantity');

                    if (($check_already_returned + $quantity) > $order_detail->quantity) {
                        return redirect()->back()->with('error', 'You have already requested return for this product. Return quantity exceeds ordered quantity.');
                    }
                } else {
                    return redirect()->back()->with('error', 'Order detail not found.');
                }
            }
        }

        if (($order->status == 0) or $order->delivery_status != 3) {
            return redirect()->back()->with('error', 'Order Return not possible at this stage!');
        }

        DB::transaction(function () use ($request,$order) {

            $tracking_code = date("yhis");
            $data['tracking_code'] = $tracking_code;
            $data['invoice_no'] = sprintf('%08d', $order->id);;
            $data['order_id'] = $order->id;
            $data['user_id'] = $order->user_id;
            $data['remark'] = $request->reason;
            $data['status'] = 0;
            $return_order = OrderReturn::create($data);

            $grand_total_price = 0;
            foreach ($request->details_id as $detail_id => $quantity) {
                if ($quantity > 0) {

                    $detail_id = Crypt::decryptString($detail_id);
                    $order_detail = OrderDetail::where([
                        'id' => $detail_id,
                    ])->first();

                    if ($order_detail) {
                        $grand_total_price += ($order_detail->price * $quantity);
                        $return_data['return_order_id'] = $return_order->id;
                        $return_data['order_id'] = $order->id;
                        $return_data['order_detail_id'] = $detail_id;
                        $return_data['product_id'] = $order_detail->product_id;
                        $return_data['varient_id'] = $order_detail->varient_id;
                        $return_data['quantity'] = $quantity;
                        $return_data['price'] = $order_detail->price;
                        $return_data['f_price'] = $order_detail->f_price;
                        $return_data['discount'] = $order_detail->discount;
                        $return_data['discount_type'] = $order_detail->discount_type;
                        $return_data['weight'] = $order_detail->weight;
                        $return_data['unit'] = $order_detail->unit;

                        OrderReturnDetail::create($return_data);
                    }
                }
            }

            $payment['type'] = 2;
            $payment['order_id'] = $return_order->id;
            $payment['user_id'] = $order->user_id;
            $payment['amount'] = $grand_total_price;
            $payment['payment_method'] = 5;
            $payment['status'] = 0; // helper function return payment functon status check
            $payment['created_by'] = $order->user_id;
            Payment::create($payment);

            $return_order->grand_total_price = $grand_total_price;
            $return_order->save();
        });





        return redirect()->back()->with('success', 'Order Return Request Submitted Successfully!');


    }

    public function return_order_list(Request $request)
    {
        $user = Auth::user();

        $orders = OrderReturn::where([
                'user_id' => $user->id,
                // 'tracking_code' => $request->order_no,
            ])->latest()->paginate(20);

        return view('customer.return_order_list', compact('orders'));
    }

    public function returnOrderDetails($id)
    {
        $user = Auth::user();
        $id = Crypt::decryptString($id);

        $orderDetails = OrderReturn::where([
                'user_id' => $user->id,
                'id' => $id,
            ])->latest()->first();

        if (!$orderDetails) {
            return redirect()->back()->with('error', 'Return order not found.');
        }

        return view('customer.returnOrderDetails', compact('orderDetails','user'));
    }

}
