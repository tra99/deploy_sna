<?php

namespace App\Http\Controllers\Auth;

// ===================================================>> Core Library

use App\Mail\Email;
use App\Enum\UserType;
use App\Models\User\User;


// ===================================================>> Third Party Library fuck
use App\Services\FileUpload;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;



// ===================================================>> Custom Library
use App\Services\TelegramService;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\Controller;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('jwt.verify', ['except' => ['login', 'register','verify', 'sendOTP', 'forgotPassword']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $req)
    {
        // ================================================>> Data Validation
        $this->validate($req,
            [
                'username' => ['required'],
                'password' => 'required|min:6|max:20'
            ],
            [
                'username.required' => 'សូមបញ្ចូលអុីម៉ែលឬលេខទូរស័ព្ទ',
                'password.required' => 'សូមបញ្ចូលលេខសម្ងាត់',
                'password.min'      => 'លេខសម្ងាត់ត្រូវធំជាងឬស្មើ៦',
                'password.max'      => 'លេខសម្ងាត់ត្រូវតូចជាងឬស្មើ២០',
            ]
        );

        // ================================================>> Check Login
        $credentials = array(
            'phone'             =>  $req->username,
            'password'          =>  $req->password,
            'is_active'         =>  1,
            'deleted_at'        =>  null,
        );

        try {

            JWTAuth::factory()->setTTL(1200); //1200 នាទី
            $token = JWTAuth::attempt($credentials);

            if (!$token) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'ឈ្មោះអ្នកប្រើឬពាក្យសម្ងាត់មិនត្រឹមត្រូវ។'
                ], Response::HTTP_UNAUTHORIZED);
            }

        } catch (JWTException $e) {

            return response()->json([
                'status'    => 'បរាជ័យ',
                'message'   => 'Cannot Login',
                'error'     => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);

        }

        // ================================================>> Prepare Response Data
        $user = auth()->user();
        $dataUser = [
            'id'        => $user->id,
            'name'      => $user->name,
            'email'     => $user->email,
            'avatar'    => $user->avatar,
            'phone'     => $user->phone
        ];
        // ================================================>> Check Role
        $role = '';
        if ($user->type_id == 2) { //
            $role = 'Staff';
        } else {
            $role = 'Admin';
        }

        $user_ip = $req->ip(); // get user ip address

        // Send Telegram Notification
        $this->_customerLogingAlertAdmin($user, $user_ip);

        // ================================================>> Response Back to Client
        return response()->json([
            'access_token'  => $token,
            'token_type'    => 'bearer',
            'expires_in'    => JWTAuth::factory()->getTTL() / 60 . ' hours',
            'user'          => $dataUser,
            'role'          => $role
        ], Response::HTTP_OK);

    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();
        return response()->json(['message' => 'Successfully logged out'], 200);
    }


    public function register(Request $req)
    {
        User::where('phone',$req->phone)->delete();

        //==============================>> Check validation
        $this->validate(
            $req,
            [
                'name'     => 'required|min:1|max:20',
                'phone'    => 'required|unique:user,phone',
                'password' => 'required|min:6|max:20',
                'email'    => 'unique:user,email'
            ],
            [
                'name.required'     => 'សូមវាយបញ្ចូលឈ្មោះរបស់អ្នក',
                'phone.required'    => 'សូមវាយបញ្ចូលលេខទូរស័ព្ទរបស់អ្នក',
                'phone.unique'      => 'លេខទូរស័ព្ទនេះត្រូវបានប្រើប្រាស់រួចហើយនៅក្នុងប្រព័ន្ធ',
                'email.unique'      => 'អ៊ីមែលនេះមានក្នុងប្រព័ន្ធរួចហើយ',
                'password.required' => 'សូមវាយបញ្ចូលពាក្យសម្ងាត់របស់អ្នក',
                'password.min'      => 'សូមបញ្ចូលលេខសម្ងាត់ធំជាងឬស្មើ៦',
                'password.max'      => 'សូមបញ្ចូលលេខសម្ងាត់តូចឬស្មើ២០'
            ]
        );

        //==============================>> Start Adding data
        $user            =   new User;
        $user->name      =   $req->name;
        $user->type_id   =   UserType::CUSTOMER;
        $user->phone     =   $req->phone;
        $user->email     =   $req->email;
        $user->password  =   Hash::make($req->password);
        $user->address   =   $req->address;
        $user->is_active =   0;
        $user->avatar    =   'static/icon/user.png';

        // Need to create folder before storing images
        if ($req->image) {
            $image     = FileUpload::uploadFile($req->image, 'users', $req->fileName);
            if ($image['url']) {
                $user->avatar = $image['url'];
            }
        }


        $user->otp = Rand(100000, 999999);
        $user->otp_sent_at = Date('Y-m-d H:i:s');
        $user->save();

        //send opt to email of user
        $this->_sendEmail($user);

        //alert admin in telegram
        $this->_alertAdmin($user);


        return response()->json([
            // 'data'    => $user,
            'message' => 'OTP has been sent to your email, please check your email and verify'
        ], Response::HTTP_OK);

    }

    public function verify(Request $req){

        $user = User::select('id','type_id', 'phone', 'email', 'name','address', 'otp' ,'otp_sent_at')
        ->where('phone',$req->phone)
        ->first();

        $checkOTPExpire = Carbon::now();
        $opt_send_at = Carbon::parse($user->otp_sent_at);

        if($opt_send_at->diffInSeconds($checkOTPExpire) >= 60){ // if opt sent over 60 seconds expires
            return response()->json([
                'status'  => 'fail',
                'message' => 'OTP ផុតកំណត់'
            ], Response::HTTP_BAD_REQUEST);
        }

        if($user->otp != $req->otp){   // Check if OTP is compatible

            return response()->json([
                'status'  => 'fail',
                'message' => 'OTP មិនត្រឹមត្រូវ'
            ], Response::HTTP_BAD_REQUEST);
        }
        $user->otp_verified_at = Date('Y-m-d H:i:s');
        $user->is_active = 1 ;
        $user->save();


        $this->_createSuccessfully($user);

        return response()->json([
            'data'    => $user,
            'message' => 'គណនីរបស់អ្នកបង្កើតបានដោយជោគជ័យ'
        ], Response::HTTP_OK);

    }

    // send new otp code when otp expired
    function sendOTP(Request $req){

        $user = User::select('id','type_id', 'phone', 'email', 'name', 'otp' ,'otp_sent_at')
        ->where('phone',$req->phone)
        ->first();

        $this->_sentOTP($user);

        return response()->json([
            'data'    => $user,
            'message' => 'OTP has been sent to your email, please check your email and verify'
        ], Response::HTTP_OK);

    }

    function forgotPassword(Request $req){

        // ================================================>> Check user
        $user = User::select('id','type_id', 'phone', 'email' , 'address', 'name', 'otp' ,'otp_sent_at')
        ->where('phone',$req->phone)
        ->first();

        try {
            if (!$user) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'ឈ្មោះអ្នកប្រើមិនមានក្នុងប្រព័ន្ធ'
                ], Response::HTTP_UNAUTHORIZED);
            }

        } catch (JWTException $e) {

            return response()->json([
                'status'    => 'បរាជ័យ',
                'message'   => 'User account cannot found',
                'error'     => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);

        }

        $checkOTPExpire = Carbon::now();
        $opt_send_at = Carbon::parse($user->otp_sent_at);

        if($opt_send_at->diffInSeconds($checkOTPExpire) >= 60){ // if opt sent over 60 seconds expires
            return response()->json([
                'status'  => 'fail',
                'message' => 'OTP ផុតកំណត់'
            ], Response::HTTP_BAD_REQUEST);
        }

        if($user->otp != $req->otp){   // Check if OTP is compatible

            return response()->json([
                'status'  => 'fail',
                'message' => 'OTP មិនត្រឹមត្រូវ'
            ], Response::HTTP_BAD_REQUEST);
        }

        $user->password = Hash::make($req->new_password);
        $user->save();

        $this->_changePassword($user);

        return response()->json([
            'data'    => $user,
            'message' => 'ពាក្យសម្ងាត់បានផ្លាស់ប្តូរដោយជោគជ័យ'
        ], Response::HTTP_OK);
    }

    private function _sentOTP($user = null){

        $user->otp = Rand(100000, 999999);
        $user->otp_sent_at = Date('Y-m-d H:i:s');
        $user->save();

        $htmlMessage = "<b>ផ្ញើរ OTP ថ្មី</b>\n";
        $htmlMessage .= "- ឈ្មោះ      ៖ " . $user->name . "\n";
        $htmlMessage .= "- លេខទូរស័ព្ទ​ ៖ " . $user->phone . "\n";
        $htmlMessage .= "- អីម៉ែល​​     ៖ " . $user->email . "\n";
        $htmlMessage .= "- OTP ថ្មី     ៖ " . $user->otp . "\n";
        $htmlMessage .= "- កាលបរិច្ឆេទ​ ៖ " . $user->otp_sent_at . "\n";

        //send opt to email of user
        $this->_sendEmail($user);

        // send message into telegram to alert admin
        TelegramService::send($htmlMessage, env('TELEGRAM_CHAT_ID_ACCOUNT'));

    }

    private function _alertAdmin($user = null){

        $htmlMessage = "<b>អតិថិជនបានចុះឈ្មោះ</b>\n";
        $htmlMessage .= "- ឈ្មោះ      ៖ " . $user->name . "\n";
        $htmlMessage .= "- លេខទូរស័ព្ទ​ ៖ " . $user->phone . "\n";
        $htmlMessage .= "- អីម៉ែល​​     ៖ " . $user->email . "\n";
        $htmlMessage .= "- អាស័យដ្ឋាន​ ៖ " . $user->address . "\n";
        $htmlMessage .= "- OTP       ៖ " . $user->otp . "\n";
        $htmlMessage .= "- កាលបរិច្ឆេទ​ ៖ " . $user->otp_sent_at . "\n";

        TelegramService::send($htmlMessage, env('TELEGRAM_CHAT_ID_ACCOUNT'));
    }

    private function _createSuccessfully($user = null){

        $htmlMessage = "<b>អតិថិជនបានចុះឈ្មោះដោយជោគជ័យ</b>\n";
        $htmlMessage .= "- ឈ្មោះ      ៖ " . $user->name . "\n";
        $htmlMessage .= "- លេខទូរស័ព្ទ​ ៖ " . $user->phone . "\n";
        $htmlMessage .= "- អីម៉ែល​​     ៖ " . $user->email . "\n";
        $htmlMessage .= "- អាស័យដ្ឋាន​ ៖ " . $user->address . "\n";
        $htmlMessage .= "- កាលបរិច្ឆេទ​ ៖ " . $user->otp_verified_at . "\n";

        TelegramService::send($htmlMessage, env('TELEGRAM_CHAT_ID_ACCOUNT'));
    }

    private function _customerLogingAlertAdmin($user = null, $user_ip = null){

        $htmlMessage = "<b>អតិថិជនបានចូលប្រើប្រាស់់</b>\n";
        $htmlMessage .= "- ឈ្មោះ      ៖ " . $user->name . "\n";
        $htmlMessage .= "- លេខទូរស័ព្ទ​ ៖ " . $user->phone . "\n";
        $htmlMessage .= "- អីម៉ែល​​     ៖ " . $user->email . "\n";
        $htmlMessage .= "- អាស័យដ្ឋាន​ ៖ " . $user->address . "\n";

        $htmlMessage .= "- IP Address៖ " . $user_ip. "\n";

        TelegramService::send($htmlMessage, env('TELEGRAM_CHAT_ID_LOGIN_LOGS'));
    }

    private function _sendEmail($user = null){

        $data = [
            'toEmail'   => $user->email,
            'fromName'  => 'Awesome Shoes',
            'fromEmail' => 'tongmeng016@gmail.com',
            'otp'       => $user->otp,
            'subject'   => 'Account Verification',
            'body'      => 'Your OTP code below ',
            'footer'    => 'Thanks for your participating'
        ];
        // sent opt code to user gmail
        Mail::to($user->email)->send(new Email($data));
    }

    private function _changePassword($user = null){

        $htmlMessage = "<b>អតិថិជនបានផ្លាស់ប្តូរពាក្យសម្ងាត់ដោយជោគជ័យ</b>\n";
        $htmlMessage .= "- ឈ្មោះ      ៖ " . $user->name . "\n";
        $htmlMessage .= "- លេខទូរស័ព្ទ​ ៖ " . $user->phone . "\n";
        $htmlMessage .= "- អីម៉ែល​​     ៖ " . $user->email . "\n";
        $htmlMessage .= "- អាស័យដ្ឋាន​ ៖ " . $user->address . "\n";
        $htmlMessage .= "- កាលបរិច្ឆេទ​ ៖ " . $user->otp_sent_at . "\n";

        TelegramService::send($htmlMessage, env('TELEGRAM_CHAT_ID_ACCOUNT'));
    }


}
