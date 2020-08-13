<!doctype html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="robots" content="noindex">
    <title>Megather - Management Panel</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            background: none;
            font: inherit;
            border: none;
            outline: none;
        }

        body {
            line-height: 1.4;
            font-family: 'Yu Gothic UI', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        header {
            height: 50px;
            background-color: #3480e4;
            color: whitesmoke;
            user-select: none;
        }

        header span {
            margin-left: 20px;
            line-height: 50px;
            font-size: 16px;
        }

        h2 {
            margin: 10px;
            font-size: 24px;
        }

        table {
            margin: 10px;
            border-collapse: collapse;
        }
        th, td {
            padding: 4px;
            border: solid 1px #9c9c9c;
        }
        th {
            background-color: #f3f3f3;
        }
    </style>
</head>
<body>
    <header>
        <span>Megather 管理パネル</span>
    </header>

    <h2>レポート</h2>
    <table>
        <tbody>
        <tr>
            <th rowspan="2">タイプ</th>
            <th colspan="1">報告元情報</th>
            <th colspan="2">報告対象情報</th>
        </tr>
        <tr>
            <th>ユーザー</th>
{{--                <th>報告理由</th>--}}
            <th>ユーザー</th>
            <th>投稿内容</th>
        </tr>
        <tr>
            <td>REPORT_POST</td>
            <td><a href="#333">daxiongmao</a> (1)</td>
            {{--                <td>内容</td>--}}
            <td><a href="#333">freedom</a> (2)</td>
            <td><a href="#333">内容</a></td>
        </tr>
        <tr>
            <td>REPORT_POST</td>
            <td><a href="#333">daxiongmao</a> (1)</td>
            {{--                <td>内容</td>--}}
            <td><a href="#333">freedom</a> (2)</td>
            <td><a href="#333">内容</a></td>
        </tr>
        </tbody>
    </table>
</body>
</html>
