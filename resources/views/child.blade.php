@extends('layouts.welcome')

@section('title','マイページ')

@section('sidebar')
@parent

<p>メインのサイドバー（共通部品）に追加される個別の部品</p>
@endsection

@section('content')
<p>メインコンテンツ</p>
@endsection

@section('footer')
@parent
<script src="dashbord.js"></script>
@endsection