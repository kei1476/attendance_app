@extends('components.default')
@section('content')

@component('components.user_header')
@endcomponent
<main>
    <div class="attendance-stamp-area">
        <p class="home-message">{{Auth::user()->name}}さんお疲れ様です。</p>
        <div class="stamps">
            <div class="stamp">
                <form action="/start/work" class="attendance-form" method="POST">
                    @csrf
                    @if($exist->isNotEmpty())
                        <button class="stamped" disabled>勤務開始</button>
                    @else
                    <button>勤務開始</button>
                    @endif
                </form>
            </div>
            {{-- 今日出勤済みでかつ退勤していない場合に押せる --}}
            <div class="stamp">
                <form action="/end/work" class="attendance-form" method="POST">
                    @csrf
                    @if($exist->isNotEmpty() && $out_time_exist->isEmpty())
                        <button>勤務終了</button>
                    @else
                        <button class="stamped" disabled>勤務終了</button>
                    @endif
                </form>
            </div>
            <div class="stamp">
                <form action="/start/rest" class="attendance-form" method="POST">
                    @csrf
                    @if($exist->isNotEmpty() && $out_time_exist->isEmpty() && $exist_rest->isEmpty())
                    <button>休憩開始</button>
                    @else
                    <button class="stamped" disabled>休憩開始</button>
                    @endif
                </form>
            </div>
            <div class="stamp">
                <form action="/end/rest" class="attendance-form" method="POST">
                    @csrf
                    @if($exist->isNotEmpty() && $out_time_exist->isEmpty() && $exist_rest->isNotEmpty())
                    <button>休憩終了</button>
                    @else
                    <button class="stamped" disabled>休憩終了</button>
                    @endif
                </form>
            </div>
        </div>
    </div>
</main>
@component('components.user_footer')
@endcomponent
@endsection
