<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\Attendance;
use App\Models\User;
use App\Models\Rest;
use App\Models\TotalRest;

class AttendanceController extends Controller
{
    public function showStampPage()
    {
        $datetime = Carbon::now();
        $user_id = Auth::id();

        // 今日出勤済みかどうか
        $exist = Attendance::where('user_id',$user_id)
                ->where('work_date',$datetime->format('Y-m-d'))
                ->get();
        // 今日退勤しているかどうか
        $out_time_exist = Attendance::where('user_id',$user_id)
                ->where('work_date',$datetime->format('Y-m-d'))
                ->whereNotNull('out_time')
                ->get();
        // 休憩中どうか
        $exist_rest = Rest::where('user_id',$user_id)
                          ->where('work_date',$datetime->format('Y-m-d'))
                          ->whereNull('end_time')
                          ->get();

        return view('user.stamp',compact('exist','out_time_exist','exist_rest'));
    }

    public function sendStartWork()
    {
        $datetime = Carbon::now();
        $user_id = Auth::id();

        Attendance::create([
            'user_id' => Auth::id(),
            'work_date' => $datetime->format('Y-m-d'),
            'in_time' => $datetime->format('H:i:s'),
        ]);

        return back();
    }

    public function sendEndWork()
    {
        $user_id = Auth::id();
        $datetime = Carbon::now();

        Attendance::where('work_date',$datetime->format('Y-m-d'))
                   ->where('user_id',$user_id)
                   ->update([
                    'out_time' => $datetime->format('H:i:s')
                   ]);

        return back();
    }

    public function sendStartRest()
    {
        $datetime = Carbon::now();
        $user_id = Auth::id();
        $attendance_id = Attendance::select('id')
                   ->where('user_id',$user_id)
                   ->where('work_date',$datetime->format('Y-m-d'))
                   ->first();

        Rest::create([
            'user_id' => Auth::id(),
            'attendance_id' => $attendance_id->id,
            'work_date' => $datetime->format('Y-m-d'),
            'start_time' => $datetime->format('H:i:s'),
        ]);

        return back();
    }

    public function sendEndRest()
    {
        $datetime = Carbon::now();
        $user_id = Auth::id();
        $attendance_id = Attendance::select('id')
                   ->where('user_id',$user_id)
                   ->where('work_date',$datetime->format('Y-m-d'))
                   ->first();

        $target_id = Rest::select('id')
                        ->where('work_date',$datetime->format('Y-m-d'))
                        ->where('user_id',$user_id)
                        ->orderBy('start_time','desc')
                        ->first();

        Rest::where('user_id',$user_id)
            ->whereNull('end_time')
            ->where('work_date',$datetime->format('Y-m-d'))
            ->update([
                'end_time' => $datetime->format('H:i:s')
            ]);

        $TotalRest = Rest::select('rests.id','rests.attendance_id','end_time',DB::raw('TIMEDIFF(end_time,start_time) as rest_time'))
        ->leftjoin('attendances','rests.attendance_id','=','attendances.id')
        ->where('attendance_id',$attendance_id->id)
        ->orderBy('end_time','desc')
        ->first();

        TotalRest::create([
            'attendance_id' => $attendance_id->id,
            'rest_id' => $TotalRest->id,
            'total_rest' => $TotalRest->rest_time
        ]);

        return back();
    }

    public function showAttendances()
    {
        $datetime = Carbon::now();

        $attendances = Attendance::select('name','attendances.id','work_date','in_time','out_time',DB::raw('TIMEDIFF(out_time,in_time) as work_time'))
                    ->join('users','attendances.user_id','=','users.id')
                    ->leftjoin('total_rests','attendances.id','=','total_rests.attendance_id')
                    ->selectRaw('SEC_TO_TIME(SUM(TIME_TO_SEC(total_rest))) as total_rest_time')
                    ->groupBy('attendance_id')
                    ->orderBy('in_time','desc')
                    ->get();

        foreach($attendances as $attendance){

            // 勤務時間 － 休憩時間
           $work_time = strtotime($attendance->work_time);
           $rest_time = strtotime($attendance->total_rest_time);

           $work_hour = floor($work_time/3600);
           $work_minut = floor((round($work_time/3600,2)-$work_hour)*60);

           $real_time = $work_time - $rest_time;

           $real_hour = floor($real_time/3600);

           $real_minut = floor(($real_time/60) - $real_hour*60);

           $work_time = $real_hour.'時間'.$real_minut.'分';
           $total_rest = $attendance->total_rest_time;
           $out_time = $attendance->out_time;

        //退勤していない場合は勤務終了時間と勤務時間をハイフンにする。
           if($attendance->total_rest_time == null){
                $total_rest = '-';
           }

           if($attendance->out_time == null){
                $work_time = '-';
                $out_time = '-';
           }

           $attendance_data[] = array(
            'name' => $attendance->name,
            'in_time' => $attendance->in_time,
            'out_time' => $out_time,
            'total_rest' => $total_rest,
            'work_time' => $work_time
           );
        }

        return view('user.attendances',compact('attendance_data'));
    }
}
