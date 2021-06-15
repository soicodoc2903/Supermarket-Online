<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use App\Models\shipping;
use App\Models\order;
use App\Models\order_details;
use App\Models\customer;
use App\Models\coupon;
use Carbon\Carbon;
use Session;
use Auth;
session_start();

class CouponController extends Controller
{
	public function AuthLogin(){
		$admin_id = Auth::id();
		if($admin_id) {
			return Redirect::to('dashboard');
		}else{
			return Redirect::to('admin')->send();
		}
	}

     public function check_coupon(Request $request){
        $data = $request->all();
        $now = Carbon::now('Asia/Ho_Chi_Minh')->format('d/m/Y');
        $coupon = coupon::where('coupon_code',$data['coupon_code'])->where('coupon_status',1)->where('coupon_date_end','>=',$now)->first();
        $coupon_check_use = coupon::where('coupon_code',$data['coupon_code'])->where('coupon_status',1)->where('coupon_date_end','>=',$now)->where('coupon_used','LIKE','%'.Session::get('customer_id'.'%'))->first();
        if ($coupon_check_use) {
            return Redirect()->back()->with('error_coupon','Bạn đã sử dụng mã khuyến mãi này, bạn chỉ có quyền sử dụng mã khuyến mãi này 1 lần cho tài khoản của bạn!');
        }
    	else if($coupon) {
                $coupon_count = $coupon->count();
                if($coupon_count>0) {
                $coupon_session = Session::get('coupon');
                if($coupon_session==true) {
                    $is_avaiable=0;
                    if($is_avaiable==0) {
                        $cou[] = array(
                            'coupon_code' => $coupon->coupon_code,
                            'coupon_number' => $coupon->coupon_number,
                        );
                        Session::put('coupon',$cou);
                        }
                    }else{
                        $cou[] = array(
                            'coupon_code' => $coupon->coupon_code,
                            'coupon_number' => $coupon->coupon_number,
                        );
                        Session::put('coupon',$cou);
                    }
                    Session::save();
                    return Redirect()->back()->with('message_coupon','Thêm mã giảm giá thành công!');
                }
        }else{
            return Redirect()->back()->with('error_coupon','Mã giảm giá này không tồn tại, hoặc là đã hết hạn!');
        }


    }

    public function add_coupon_admin(){
    	$this->AuthLogin();
    	return view('admin.coupon.add_coupon_admin');
    }

    public function insert_coupon_admin(Request $request){
    	$this->AuthLogin();
    	$rules=[
            'coupon_name' => 'required|max:50',
            'coupon_code' => 'required|unique:tbl_coupon,coupon_code',
            'coupon_quantity' => 'required|numeric',
            'coupon_number' => 'required|numeric',
            'coupon_date_end' => 'required',
            'coupon_date_start' => 'required',
        ];

        $message=[
        	'coupon_name.required' => 'Bạn chưa nhập tên mã khuyến mãi',
            'coupon_name.max' => 'Tên mã khuyến mãi không được vượt quá 50 ký tự',

            'coupon_code.required' => 'Bạn chưa nhập mã khuyến mãi',
            'coupon_code.unique' => 'Mã khuyến mãi này đã tồn tại',

            'coupon_quantity.required' => 'Bạn chưa nhập số lượng mã khuyến mãi',
            'coupon_quantity.numeric' => 'Số lượng phải là ký tự số',

            'coupon_number.required' => 'Bạn chưa nhập số tiền hoặc số phần trăm cho mã khuyến mãi',
            'coupon_number.numeric' => 'Số tiền hoặc số phần trăm cho mã khuyến mãi phải là ký tự số',

            'coupon_date_start.required' => 'Bạn chưa nhập ngày bắt đầu cho mã khuyến mãi',

            'coupon_date_end.required' => 'Bạn chưa nhập ngày kết thúc cho mã khuyến mãi',
        ];

        $validator = Validator::make($request->all(),$rules,$message);
        if ($validator->fails()) {
            return Redirect()->back()->withErrors($validator)->withInput();
        }else{
            $data = $request->all();
            $coupon = new coupon();
            $coupon->coupon_name = $data['coupon_name'];
            $coupon->coupon_code = $data['coupon_code'];
            $coupon->coupon_quantity = $data['coupon_quantity'];
            $coupon->coupon_number = $data['coupon_number'];
            $coupon->coupon_date_start = $data['coupon_date_start'];
            $coupon->coupon_date_end = $data['coupon_date_end'];
            $coupon->save();
            return Redirect::to('/add-coupon-admin')->with('message','Thêm mã khuyến mãi thành công !');
        }
    	
    }
    public function list_coupon_admin(Request $request){
    	$this->AuthLogin();
    	$coupon = coupon::orderBy('coupon_id','DESC')->get();
    	return view('admin.coupon.list_coupon_admin')->with(compact('coupon'));
    }
    public function delete_coupon_admin($coupon_id){
    	$this->AuthLogin();
    	coupon::where('coupon_id',$coupon_id)->delete();
    	return Redirect::to('list-coupon-admin')->with('message','Xóa mã khuyến mãi thành công!');
    }
    public function edit_coupon_admin($coupon_id){
    	$this->AuthLogin();
    	$coupon_edit = coupon::where('coupon_id',$coupon_id)->get();
    	return view('admin.coupon.edit_coupon_admin')->with(compact('coupon_edit'));
    }

    public function update_coupon_admin(Request $request,$coupon_id){
        $this->AuthLogin();
        $rules=[
            'coupon_name' => 'required|max:50',
            'coupon_code' => 'required|unique:tbl_coupon,coupon_code',
            'coupon_quantity' => 'required|numeric',
            'coupon_number' => 'required|numeric',
        ];

        $message=[
            'coupon_name.required' => 'Bạn chưa nhập tên mã khuyến mãi',
            'coupon_name.max' => 'Tên mã khuyến mãi không được vượt quá 50 ký tự',

            'coupon_code.required' => 'Bạn chưa nhập mã khuyến mãi',
            'coupon_code.unique' => 'Mã khuyến mãi này đã tồn tại',

            'coupon_quantity.required' => 'Bạn chưa nhập số lượng mã khuyến mãi',
            'coupon_quantity.numeric' => 'Số lượng phải là ký tự số',

            'coupon_number.required' => 'Bạn chưa nhập số tiền hoặc số phần trăm cho mã khuyến mãi',
            'coupon_number.numeric' => 'Số tiền hoặc số phần trăm cho mã khuyến mãi phải là ký tự số',
        ];

        $validator = Validator::make($request->all(),$rules,$message);
        if ($validator->fails()) {
            return Redirect()->back()->withErrors($validator)->withInput();
        }else{
            $data = $request->all();
            $coupon = coupon::find($coupon_id);
            $coupon->coupon_name = $data['coupon_name'];
            $coupon->coupon_code = $data['coupon_code'];
            $coupon->coupon_quantity = $data['coupon_quantity'];
            $coupon->coupon_number = $data['coupon_number'];
            $coupon->save();
            return Redirect::to('/list-coupon-admin')->with('message','Cập mã khuyến mãi thành công !');
        }
    }

    public function unset_coupon_customer(){
    	$coupon = Session::get('coupon');
    	if ($coupon==true) {
    		Session::forget('coupon');
    		return Redirect()->back()->with('message_coupon','Đã hủy áp dụng mã khuyến mãi!');
    	}
    }
}
