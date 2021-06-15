<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\customer;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Auth;

class CustomerController extends Controller
{
  public function AuthLogin(){
    $admin_id = Auth::id();
    if($admin_id) {
     return Redirect::to('dashboard');
   }else{
     return Redirect::to('admin')->send();
   }
 }
 public function add_customer(){
  $this->AuthLogin();
  return view('admin.customer.add_customer');
}
public function all_customer(){
  $this->AuthLogin();
  $customer = customer::all();
  return view('admin.customer.all_customer')->with('customer',$customer);
}
public function edit_customer($customer_id){
  $this->AuthLogin();
  $customer = customer::where('customer_id',$customer_id)->get();
  return view('admin.customer.edit_customer')->with('customer',$customer);
}   
public function delete_customer($customer_id){
  $this->AuthLogin();
  customer::where('customer_id',$customer_id)->delete();
  return Redirect::to('all-customer-admin')->with('message','Đã xóa tài khoản customer thành công !');
}
public function save_customer(Request $request){
 $rules=[
  'name_customer' => 'required|min:6|max:40',
  'email_customer' => 'required|email|unique:tbl_customer,customer_email|unique:tbl_shop,shop_email|unique:tbl_admin,admin_email',
  'phone_customer' => 'required|numeric',
  'password_customer' => 'required|min:6|max:20',
  'password_customer_confirm' => 'required|same:password_customer',
];
$messages = [
  'name_customer.required' => 'Trường họ tên không được để trống !',
  'name_customer.min' => 'Trường họ tên không được ít hơn 6 ký tự !',
  'name_customer.max' => 'Trường họ tên không được nhiều hơn 40 ký tự !',

  'email_customer.required' => 'Trường email không được để trống !',
  'email_customer.email' => 'Trường email không hợp lệ !',
  'email_customer.unique' => 'Email này đã tồn tại trong hệ thống!',

  'phone_customer.required' => 'Trường số điện thoại không được để trống !',
  'phone_customer.numeric' => 'Trường số điện thoại không hợp lệ ,số điện thoại phải là ký tự số !',

  'password_customer.required' => 'Trường mật khẩu không được để trống !',
  'password_customer.min' => 'Trường mật khẩu không được nhỏ hơn 6 ký tự !',
  'password_customer.max' => 'Trường mật khẩu không được lớn hơn 20 ký tự !',

  'password_customer_confirm.required' => 'Trường nhập lại mật khẩu không được để trống !',
  'password_customer_confirm.same' => 'Mật khẩu nhập không khớp với mật khẩu ở trên !',
];

$validator = Validator::make($request->all(),$rules,$messages);
if ($validator->fails()) {
  return redirect()->back()->withErrors($validator)->withInput();
}else{
  $data = $request->all();
  $customer = new customer();
  $customer->customer_name = $data['name_customer'];
  $customer->customer_email = $data['email_customer'];
  $customer->customer_password = md5($data['password_customer']);
  $customer->customer_phone = $data['phone_customer'];
  $customer->save();
  return Redirect('add-customer-admin')->with('message','Đăng ký tài khoản khách hàng thành công !');
}        
}

public function update_customer(Request $request,$customer_id){
  $this->AuthLogin();
  $rules=[
    'name_customer' => 'required|min:6|max:40',
    'email_customer' => 'required|email',
    'phone_customer' => 'required|numeric',
    'password_customer' => 'required|min:6|max:20',
  ];
  $messages = [
            //name
    'name_customer.required' => 'Trường họ tên không được để trống !',
    'name_customer.min' => 'Trường họ tên không được ít hơn 6 ký tự !',
    'name_customer.max' => 'Trường họ tên không được nhiều hơn 40 ký tự !',
            //email
    'email_customer.required' => 'Trường email không được để trống !',
    'email_customer.email' => 'Trường email không hợp lệ !',
            //phone
    'phone_customer.required' => 'Trường số điện thoại không được để trống !',
    'phone_customer.numeric' => 'Trường số điện thoại không hợp lệ ,số điện thoại phải là ký tự số !',
            //password
    'password_customer.required' => 'Trường mật khẩu không được để trống !',
    'password_customer.min' => 'Trường mật khẩu không được nhỏ hơn 6 ký tự !',
    'password_customer.max' => 'Trường mật khẩu không được lớn hơn 20 ký tự !',
  ];

  $validator = Validator::make($request->all(),$rules,$messages);
  if ($validator->fails()) {
    return redirect()->back()->withErrors($validator)->withInput();
  }else{
    $data = $request->all();
    $customer = customer::find($customer_id);
    $customer->customer_name = $data['name_customer'];
    $customer->customer_email = $data['email_customer'];
    $customer->customer_phone = $data['phone_customer'];
    $customer->customer_password = md5($data['password_customer']);
    $customer->update();
    return Redirect::to('add-customer-admin')->with('message','Cập nhập tài khoản customer thành công!');
  }
}
}
