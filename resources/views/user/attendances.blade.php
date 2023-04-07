@extends('components.default')
@section('content')
    @component('components.user_header')
    @endcomponent
    <div class="show-attendances-area">
        <div class="date">
            <p>2023-x-xx</p>
        </div>
        <div class="attendance-table">
            <table>
                <tr>
                   <th>名前</th>
                   <th>勤務開始</th>
                   <th>勤務終了</th>
                   <th>休憩時間</th>
                   <th>勤務時間</th>
                </tr>
                @for($i=0;$i<count($attendance_data);$i++)
                <tr>
                    <td>{{$attendance_data[$i]['name']}}</td>
                    <td>{{$attendance_data[$i]['in_time']}}</td>
                    <td>{{$attendance_data[$i]['out_time']}}</td>
                    <td>{{$attendance_data[$i]['total_rest']}}</td>
                    <td>{{$attendance_data[$i]['work_time']}}</td>
                </tr>
                @endfor
            </table>
        </div>
    </div>
@component('components.user_footer')
@endcomponent
@endsection
