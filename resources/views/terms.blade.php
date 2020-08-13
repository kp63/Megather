@extends('layouts.app')

@section('page_title', '利用規約')

@section('content')
    <div class="content-box">
        <h1>利用規約</h1>
        <h3>1. 禁止事項</h3>
        <p>
            当掲示板 (Megather)では、以下のような行為を禁止します。
        </p>
        <ul style="list-style: decimal;">
            <li>法令または公序良俗に違反する行為</li>
            <li>犯罪行為に関連する行為</li>
            <li>当掲示板の内容等、当掲示板に含まれる著作権、商標権ほか知的財産権を侵害する行為</li>
            <li>当サーバーまたはネットワークの機能を破壊したり、妨害したりする行為</li>
            <li>不正な目的を持って当掲示板を利用する行為</li>
            <li>当掲示板内で他のユーザーまたはその他の第三者に不利益、損害、不快感を与える行為</li>
            <li>他のユーザーに成りすます行為</li>
            <li>その他、管理者が不適切と判断する行為</li>
        </ul>

        <h3>2. 免責事項</h3>
        <p>
            当掲示板で生じた損害、ユーザーと他のユーザーまたは第三者との間において生じた取引、連絡または紛争等について一切責任を負いません。
        </p>
    </div>
    <style>
        h3 {
            margin-top: 20px;
        }
        p {
            padding: 10px;
        }
        li {
            margin: 4px 2px;
        }
    </style>
@endsection
