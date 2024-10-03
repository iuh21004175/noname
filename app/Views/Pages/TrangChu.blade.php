@extends('Main')
@section('title', 'Trang chủ')
@section('content')
    <div>

        <div id="chartContainer" style="height: 370px; width: 100%;"></div>
    </div>
@endsection
@section('script')
    <script src="./public/assets/js/canvasjs.min.js"></script>
    <script src="./public/assets/js/trangchu.js"></script>

@endsection