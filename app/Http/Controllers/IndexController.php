<?php


namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class IndexController extends Controller
{
    public function index(Request $request)
    {
        $user = session('user');
        if (empty($user)){ header('location: /login');die;};

        //房间id
        $room_id = $request->input('room_id', '1');
        //获取所有房间号
        $group = DB::table('chat_room')->get();
        //获取当前房间号信息
        $dq_room = DB::table('chat_room')->where(['id' => $room_id])->get();
        return view('chat', ['room' => $group, 'room_id' => $room_id, 'user' => $user, 'dq_room' => $dq_room]);
    }

    public function getReord(Request $request)
    {
        // 获取到当前currentpage 和 perpage 每页多少条
        $currentPage = (int)$request->input('current_page', '1');
        $perage = (int)$request->input('perpage', '10');
        //当前页
        $limitprame = ($currentPage - 1) * $perage;

        //房间号
        $room_id = (int)$request->input('room_id');
        $where = 'r.to_group = ' . intval($room_id);

        //私聊人
        if (!$room_id) {
            $send_user_id = (int)$request->input('send_user_id', '');
            $to_user_id = (int)$request->input('to_user_id', '');
            $where = 'r.send_user = ' . $send_user_id . ' and ' . 'r.to_user = ' . $to_user_id;
        }

        //$data = DB::select('select u.id,u.name,u.image_id,r.content ,r.create_time from chat_rcord as r right join chat_user u on r.send_user = u.client_id where ? order by r.create_time desc limit ?,? ', [$where, $limitprame, $perage]);
        $data = DB::select('select u.id,u.client_id,u.name,u.image_id,r.content ,r.create_time from chat_rcord as r right join chat_user u on r.send_user = u.id where ' . $where . ' order by r.create_time desc limit  ' . $limitprame . ',' . $perage);
        //取当前房间最近10条聊天记录
        return json_encode(array_reverse($data));

    }

    public function login(Request $request)
    {
        if ($request->isMethod("POST")) {
            $name = addslashes($request->input('name'));
            $pwd = addslashes($request->input('pwd'));
            try{
                $result = DB::table('chat_user')->where(['name' => $name, 'password' => $pwd])->get();
                if (!$result->isEmpty()) {
                    //存储用户信息
                    session(['user' => $result->toArray()[0]]);
                    return ['status' => 1, 'msg' => '登录成功'];
                } else {
                    return ['status' => 2, 'msg' => '账号或密码错误'];
                }
            }catch (\Exception $e){
                return ['status' => 4, 'msg' => '出现异常错误','errno' => $e->getMessage()];
            }
        }
        return view('login');
    }

    public function register(Request $request)
    {
        if ($request->isMethod("POST")) {
            $name = addslashes($request->input('name'));
            $pwd = addslashes($request->input('pwd'));
            try{
                $result = DB::table('chat_user')->where(['name' => $name])->get();
                if ($result->isEmpty()) {
                    $ins = DB::table('chat_user')->insertGetId(['name' => $name,'create_time' => date('Y-m-d H:i:s',time()), 'password' => $pwd]);
                    DB::table('chat_user')->where('id', $ins)->update(['image_id' => $ins]);
                    $data = DB::table('chat_user')->where(['id' => $ins])->get();
                    //存储用户信息
                    session(['user' => $data->toArray()[0]]);
                    return ['status' => 1, 'msg' => '注册成功，自动登录'];
                } else {
                    return ['status' => 3, 'msg' => '此用户名已存在'];
                }
            }catch (\Exception $e){
                return ['status' => 4, 'msg' => '出现异常错误','errno' => $e->getMessage()];
            }
        }
        return view('register');
    }
}