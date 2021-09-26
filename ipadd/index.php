<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>IP주소찾기</title>
    <meta property="og:url" content="http://ipadd.kr/">
    <meta property="og:title" content="IP주소찾기">
    <meta property="og:type" content="website">
    <meta property="og:image" content="http://ipadd.kr/ipadd/img/icons8-ok-480.png">
    <meta property="og:description" content="IP주소찾기 - 현재 IP를 확인하고 IP위치를 확인합니다.">
    <meta name="description" content="IP주소찾기 - 현재 IP를 확인하고 IP위치를 확인합니다.">
    <meta name="keywords" content="IP,주소찾기,IP주소찾기,IP위치,아이피,아이피주소">
    <link rel="shortcut icon" href="/ipadd/img/icons8-ok-48.png">
    <script src="//developers.kakao.com/sdk/js/kakao.min.js"></script>

    <script type="text/javascript"src="//dapi.kakao.com/v2/maps/sdk.js?appkey=2d68640b56d986af5c8a48505c7c8c71&libraries=services,clusterer,drawing"></script>
    <script src="ipadd/kakaoMapsJavaScriptAPIwrapper.js"></script>
    <script>
        Kakao.init('7f505caea4941d8f531b21c220bc1cff');
    </script>
    <!--bootstrapcdn-->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/css/toastr.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/js/toastr.js"></script>

    <script type="text/javascript">

    </script>

<style>
        html,
        body {
            width: 100%;
            height: 100%;
            margin: 0;
            padding: 0;
        }

        .map_wrap {
            position: relative;
            overflow: hidden;
            width: 100%;
            height: 350px;
        }

        .radius_border {
            visibility: hidden;
            border: 0px solid #919191;
            border-radius: 5px;
        }

        .custom_typecontrol {
            position: absolute;
            top: 10px;
            right: 10px;
            overflow: hidden;
            width: 130px;
            height: 30px;
            margin: 0;
            padding: 0;
            z-index: 1;
            font-size: 12px;
            font-family: 'Malgun Gothic', '맑은 고딕', sans-serif;
        }

        .custom_typecontrol span {
            display: block;
            width: 65px;
            height: 30px;
            float: left;
            text-align: center;
            line-height: 30px;
            cursor: pointer;
        }

        .custom_typecontrol .unselected_btn {
            background: #fff;
            background: linear-gradient(#fff, #e6e6e6);
        }

        .custom_typecontrol .unselected_btn:hover {
            background: #f5f5f5;
            background: linear-gradient(#f5f5f5, #e3e3e3);
        }

        .custom_typecontrol .unselected_btn:active {
            background: #e6e6e6;
            background: linear-gradient(#e6e6e6, #fff);
        }

        .custom_typecontrol .selected_btn {
            color: #fff;
            background: #425470;
            background: linear-gradient(#425470, #5b6d8a);
        }

        .custom_typecontrol .selected_btn:hover {
            color: #fff;
        }

        .custom_zoomcontrol {
            position: absolute;
            top: 50px;
            right: 10px;
            width: 36px;
            height: 80px;
            overflow: hidden;
            z-index: 1;
            background-color: #f5f5f5;
        }

        .custom_zoomcontrol span {
            display: block;
            width: 36px;
            height: 40px;
            text-align: center;
            cursor: pointer;
        }

        .custom_zoomcontrol span img {
            width: 15px;
            height: 15px;
            padding: 0px 0;
            border: none;
        }

        .custom_zoomcontrol span:first-child {
            border-bottom: 1px solid #bfbfbf;
        }
    </style>    
</head>
<?php
function getRealClientIp()
{

    $ipaddress = '';
    if ($_SERVER['HTTP_CLIENT_IP']) {
        $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
    } else if ($_SERVER['HTTP_X_FORWARDED_FOR']) {
        $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else if ($_SERVER['HTTP_X_FORWARDED']) {
        $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
    } else if ($_SERVER['HTTP_FORWARDED_FOR']) {
        $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
    } else if ($_SERVER['HTTP_FORWARDED']) {
        $ipaddress = $_SERVER['HTTP_FORWARDED'];
    } else if ($_SERVER['REMOTE_ADDR']) {
        $ipaddress = $_SERVER['REMOTE_ADDR'];
    } else {
        $ipaddress = '알수없음';
    }
    return $ipaddress;
}

ini_set('allow_url_fopen',1);
$details = json_decode(file_get_contents("http://ipinfo.io/"));
$country = $details->country;
$region = $details->region;
$loc = $details->loc;

?>

<body>
    <header>
        <nav class="navbar-expand-sm navbar-toggleable-sm ng-white border-bottom box-shadow mb-3 navbar navbar-light">
            <div class="container">
                <h1>IP주소찾기</h1>
            </div>
        </nav>
    </header>
    <div class="container">
        <div class="card-group">
            <div class="card border-dark mb-3">
                <div class="card-header">내 아이피</div>
                <div class="card-body text-dark">
                    <h2 class="card-title"><?= getRealClientIp() ?></h2>
                    <p></p>
                    <h5 class="card-title"></h5>
                    <?= $country ?> <?= $region ?>
                    <p></p>
                    <h5 class="card-title"></h5>
                    <div class="map_wrap">
                        <div id="map" style="width:100%;height:350px;position:relative;overflow:hidden;"></div>
                        <script>
                            map = new Map(<?= $loc ?>, "map", 3);
                        </script>                        
                    </div>                    
                    <p></p>
                    
                </div>
            </div>

            <div class="card text-white bg-dark mb-3">
                <div class="card-header">Link</div>
                <div class="card-body">

                </div>
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>

</html>