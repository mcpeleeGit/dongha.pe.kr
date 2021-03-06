<?php
session_start();
$APP_ADMIN_KEY = "72462462f6fc9baad63f2de2ad3d865b";
$REST_API_KEY = "4408b5bb51bdf4c89879e933556a21e8";
$JAVASCRIPT_KEY = "2d68640b56d986af5c8a48505c7c8c71";
$CHANNEL_ID = "_GVVxnK";

if (isset($_GET["sess"]) && $_GET["sess"] == "clear") {
    unset($_SESSION["accessToken"]);
    unset($_SESSION["accessAgree"]);
}
?>
<!doctype html>
<html lang="kr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,shrink-to-fit=no">
    <meta name="theme-color" content="#000000">
    <base href="/" />
    <link rel="manifest" href="/manifest.json">
    <link rel="shortcut icon" href="/favicon.ico">
    <link href="/static/css/2.86aa6515.chunk.css" rel="stylesheet">
    <link href="/static/css/main.a583af82.chunk.css" rel="stylesheet">
    <!--highlight.js cdn-->
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/highlight.js/10.4.1/styles/default.min.css">
    <script src="//cdnjs.cloudflare.com/ajax/libs/highlight.js/10.4.1/highlight.min.js"></script>
    <!--bootstrapcdn-->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <!--toastr-->
    <script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/css/toastr.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/js/toastr.js"></script>
    <script src="/toastrWrapper.js"></script>


    <title>카카오 로그인</title>
    <script src="https://developers.kakao.com/sdk/js/kakao.js"></script>
    <script>
        // SDK를 초기화 합니다. 사용할 앱의 JavaScript 키를 설정해 주세요.
        Kakao.init('<?= $JAVASCRIPT_KEY ?>'); //★ 수정 할 것
        // SDK 초기화 여부를 판단합니다.
        console.log(Kakao.isInitialized());
    </script>
</head>

<body>
    <header>
        <nav class="navbar-expand-sm navbar-toggleable-sm ng-white border-bottom box-shadow mb-3 navbar navbar-light">
            <div class="container"><a class="navbar-brand" href="/"><img src="/img/icon/googsu.png" class="logo" alt="logo">Kakao API Test</a>
                <h1>카카오 로그인</h1>
            </div>
        </nav>
    </header>
    <div class="container">
        <ul class="list-group">
            <li class="list-group-item">
                <h2>로그인</h2>
                <ul class="nav nav-tabs">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#JavaScript">JavaScript SDK 로그인(Redirect)</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#JavaScript1">JavaScript SDK 로그인(PopUp)</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#PHP">PHP</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#JAVA">JAVA</a>
                    </li>                    
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#AndroidKotlin">Android(Kotlin)</a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="JavaScript">

                        <p></p>
                        <p>Kakao JavaScript SDK를 이용한 Redirect방식 로그인은 Kakao인증 후, CallBack Url이 호출됩니다. 즉, CallBack Url이 호출된 이후에는 REST API 방식 사용</p>
                        <a id="custom-login-btn" href="javascript:loginWithKakao()"><img src="//k.kakaocdn.net/14/dn/btqCn0WEmI3/nijroPfbpCa4at5EIsjyf0/o.jpg" width="222" /></a>
                        <script type="text/javascript">
                            function loginWithKakao() {
                                Kakao.Auth.authorize({
                                    redirectUri: encodeURI('http://<?= $_SERVER['HTTP_HOST'] ?>/callBackForKakao.php') //★ 수정 할 것
                                })
                            }
                        </script>
                        <p></p>
                        <pre><code class="JavaScript">
Kakao.init('{JAVASCRIPT_KEY}'); //★ 수정 할 것 : SDK를 초기화 합니다. 사용할 앱의 JavaScript 키를 설정해 주세요.
console.log(Kakao.isInitialized()); // SDK 초기화 여부를 판단합니다.

function loginWithKakao() {
    Kakao.Auth.authorize({
        redirectUri: encodeURI('http://localhost/callBackForKakao.php') //★ 수정 할 것
    })
}                       </code></pre>
                        <pre><code class="language-html">
<a id="custom-login-btn" href="javascript:loginWithKakao()"><img src="//k.kakaocdn.net/14/dn/btqCn0WEmI3/nijroPfbpCa4at5EIsjyf0/o.jpg" width="222" /></a>
                        </code></pre>
                    </div>
                    <div class="tab-pane fade show" id="JavaScript1">

                        <p></p>
                        <p>Kakao JavaScript SDK를 이용한 PopUp방식 로그인은 Kakao인증 후, CallBack Url 호출하지 않습니다. 즉, Kakao인증 이후에는 로그인 후 처리 및 액세스 토큰 저장을 Script에서 해야합니다.</p>
                        <a id="custom-login-btn" href="javascript:loginWithKakaoPopUp()"><img src="//k.kakaocdn.net/14/dn/btqCn0WEmI3/nijroPfbpCa4at5EIsjyf0/o.jpg" width="222" /></a>
                        <script type="text/javascript">
                            function loginWithKakaoPopUp() {
                                Kakao.Auth.login({
                                    success: function(authObj) {
                                        console.log(JSON.stringify(authObj));
                                        Kakao.Auth.setAccessToken(authObj.access_token);
                                        //★ 추가 할 것 : 로그인 성공 후 처리 
                                    },
                                    fail: function(err) {
                                        console.log(JSON.stringify(err))
                                    },
                                })
                            }
                        </script>
                        <p></p>
                        <pre><code class="JavaScript">
Kakao.init('{JAVASCRIPT_KEY}'); //★ 수정 할 것 : SDK를 초기화 합니다. 사용할 앱의 JavaScript 키를 설정해 주세요.
console.log(Kakao.isInitialized()); // SDK 초기화 여부를 판단합니다.

function loginWithKakaoPopUp() {
    Kakao.Auth.login({
        success: function(authObj) {
            alert(JSON.stringify(authObj));
            Kakao.Auth.setAccessToken(authObj.access_token);
            //★ 추가 할 것 : 로그인 성공 후 처리 
        },
        fail: function(err) {
            alert(JSON.stringify(err))
        },
    })
}</code></pre>
                        <pre><code class="language-html">
<a id="custom-login-btn" href="javascript:loginWithKakaoPopUp()"><img src="//k.kakaocdn.net/14/dn/btqCn0WEmI3/nijroPfbpCa4at5EIsjyf0/o.jpg" width="222" /></a>
</code></pre>




                        <h2>JavaScript SDK 로그아웃</h2>
                        <p>JavaScript SDK로 로그인(PopUp)한 경우만 사용, Redirect로그인 or REST API 로그인은 이후 로직 REST API로 로그아웃 구현 해야함.</p>
                        <p>JavaScript SDK를 사용하고자 한다면, Kakao.Auth.setAccessToken(authObj.access_token); 설정 후 사용</p>
                        <button type="button" class="btn btn-primary" onclick="javascript:logoutWithKakao()">Kakao LogOut</button>
                        <script type="text/javascript">
                            function logoutWithKakao() {
                                if (!Kakao.Auth.getAccessToken()) {
                                    console.log('Not logged in.');
                                    return;
                                }
                                console.log(Kakao.Auth.getAccessToken()); //before Logout
                                Kakao.Auth.logout(function() {
                                    console.log(Kakao.Auth.getAccessToken()); //after Logout
                                    console.log("LogOut Success");
                                    //★ 추가 할 것 : 로그아웃 성공 후 처리 
                                });
                            }
                        </script>
                        <pre><code class="JavaScript">
function logoutWithKakao() {
    if (!Kakao.Auth.getAccessToken()) {
        console.log('Not logged in.');
        alert("Not logged in.");
        return;
    }
    console.log(Kakao.Auth.getAccessToken()); //before Logout
    Kakao.Auth.logout(function() {
        console.log(Kakao.Auth.getAccessToken()); //after Logout
        alert("LogOut Success");
        //★ 추가 할 것 : 로그아웃 성공 후 처리 
    });
}               </code></pre>

                        <h2>JavaScript 연결 끊기</h2>
                        <p>JavaScript SDK로 로그인(PopUp)한 경우만 사용, Redirect로그인 or REST API 로그인은 이후 로직 REST API로 로그아웃 구현 해야함.</p>
                        <p>JavaScript SDK를 사용하고자 한다면, Kakao.Auth.setAccessToken(authObj.access_token); 설정 후 사용</p>
                        <button type="button" class="btn btn-primary" onclick="javascript:unlinkWithKakao()">Kakao UnLink</button>
                        <script type="text/javascript">
                            function unlinkWithKakao() {
                                Kakao.API.request({
                                    url: '/v1/user/unlink',
                                    success: function(response) {
                                        console.log(response);
                                    },
                                    fail: function(error) {
                                        console.log(error);
                                    }
                                });
                            }
                        </script>
                        <pre><code class="JavaScript">
function unlinkWithKakao() {
    Kakao.API.request({
        url: '/v1/user/unlink',
        success: function(response) {
            console.log(response);
        },
        fail: function(error) {
            console.log(error);
        }
    });
}               </code></pre>

                        <h2>JavaScript 사용자 정보 가져오기</h2>
                        <p>JavaScript SDK로 로그인(PopUp)한 경우만 사용, Redirect로그인 or REST API 로그인은 이후 로직 REST API로 로그아웃 구현 해야함.</p>
                        <p>JavaScript SDK를 사용하고자 한다면, Kakao.Auth.setAccessToken(authObj.access_token); 설정 후 사용</p>
                        <button type="button" class="btn btn-primary" onclick="javascript:profileWithKakao()">Kakao Profile</button>
                        <p id="userid"></p>
                        <p id="nickname"></p>
                        <img id="profile_image" />
                        <img id="thumbnail_image" />
                        <script type="text/javascript">
                            function profileWithKakao() {
                                Kakao.API.request({
                                    url: '/v2/user/me',
                                    success: function(response) {
                                        console.log(response);
                                        document.getElementById("userid").innerText = response.id;
                                        document.getElementById("nickname").innerText = response.kakao_account.profile.nickname;
                                        document.getElementById("profile_image").src = response.properties.profile_image;
                                        document.getElementById("thumbnail_image").src = response.properties.thumbnail_image;
                                    },
                                    fail: function(error) {
                                        console.log(error);
                                    }
                                });
                            }
                        </script>
                        <pre><code class="JavaScript">
function profileWithKakao() {
    Kakao.API.request({
        url: '/v2/user/me',
        success: function(response) {
            console.log(response);
            document.getElementById("userid").innerText = response.id;
            document.getElementById("nickname").innerText = response.kakao_account.profile.nickname;
            document.getElementById("profile_image").src = response.properties.profile_image;
            document.getElementById("thumbnail_image").src = response.properties.thumbnail_image;
        },
        fail: function(error) {
            console.log(error);
        }
    });
}               </code></pre>


                    </div>
                    <div class="tab-pane fade" id="PHP">
                        <p></p>
                        <h4><a href="/PHPSimplePack.php">PHP Simple Pack 참고</a></h4>
                        <p></p>
                        <p>/oauth/authorize 요청은 Url만 호출 하므로 언어에 상관 없이 처리 가능합니다. 다만, CallBack Url설정 시, 인코딩을 해야합니다.</p>
                        <!--REST API Login-->
                        <?php
                        //state는 Cross-Site Request Forgery(CSRF) 공격으로부터 보호하기 위해 난수 설정 후, 콜백 페이지에서 검증할 수 있는 기능이나
                        //로그인 후, 원래 페이지로 돌아가기 위한 파라메터로 사용하기도 함.
                        $state = urlencode("http://" . $_SERVER['HTTP_HOST'] . "/kakao.php?test=한글&p=인코딩");
                        $client_id = $REST_API_KEY; //★ 수정 할 것
                        $redirect_uri = urlencode("http://" . $_SERVER['HTTP_HOST'] . "/callBackForKakao.php"); //★ 수정 할 것
                        $kakaoLoginUrl = "https://kauth.kakao.com/oauth/authorize?client_id=" . $client_id . "&redirect_uri=" . $redirect_uri . "&response_type=code&state=" . $state;
                        ?>
                        <a href="<?= $kakaoLoginUrl ?>"><img src="//k.kakaocdn.net/14/dn/btqCn0WEmI3/nijroPfbpCa4at5EIsjyf0/o.jpg" width="222" /></a>
                        <p></p>
                        <!--talk profile-->
                        <div id="Response" class="alert alert-success" role="alert" style="overflow:hidden;word-wrap:break-word;" class="w-100 p-3">
                            GET kauth.kakao.com/oauth/authorize HTTP/1.1
                        </div>
                        <pre><code class="php">
//state는 Cross-Site Request Forgery(CSRF) 공격으로부터 보호하기 위해 난수 설정 후, 콜백 페이지에서 검증할 수 있는 기능이나
//로그인 후, 원래 페이지로 돌아가기 위한 파라메터로 사용하기도 함.
$state = urlencode("http://" . $_SERVER['HTTP_HOST'] . "/returnPage.php?test=한글&p=인코딩"); 
$client_id = $REST_API_KEY; //★ 수정 할 것
$redirect_uri = urlencode("http://" . $_SERVER['HTTP_HOST'] . "/callBackForKakao.php"); //★ 수정 할 것
$kakaoLoginUrl = "https://kauth.kakao.com/oauth/authorize?client_id=" . $client_id . "&redirect_uri=" . $redirect_uri . "&response_type=code&state=" . $state;
                        </code></pre>
                    </div>
                    <div class="tab-pane fade" id="JAVA">
                        <p></p>
                        <p>Login Button</p>
                        <pre><code class="java"><a href="https://kauth.kakao.com/oauth/authorize?client_id={REST_API_KEY}&redirect_uri={REDIRECT_URI}&response_type=code&client_secret={CLIENT_SECRET}">
<img src="//k.kakaocdn.net/14/dn/btqCn0WEmI3/nijroPfbpCa4at5EIsjyf0/o.jpg" width="222" />
</a></code></pre>
                        <p></p>
                        <p>Callback Controller</p>
                        <pre><code class="java">package com.googsu.login.controller;

import java.io.UnsupportedEncodingException;
import java.util.HashMap;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.RequestParam;
import org.springframework.web.bind.annotation.RestController;

import com.googsu.login.service.LoginService;

@RestController
public class LoginController {

	@Autowired
	public LoginService loginService;
	
	@RequestMapping("/login-callback")
	public String loginCallback(@RequestParam("code") String code) throws UnsupportedEncodingException {
		System.out.println("controller code : " + code);
        String access_Token = loginService.getAccessToken(code);
        System.out.println("controller access_token : " + access_Token);
        HashMap&lt;String, Object&gt; userInfo = loginService.getUserInfo(access_Token);
        System.out.println("login Controller : " + userInfo);        		
		return "Success";
	}	
}                       </code></pre>
                        <p>Kakao Login Service</p>
                        <pre><code class="java">package com.googsu.login.service;

import java.io.BufferedReader;
import java.io.BufferedWriter;
import java.io.IOException;
import java.io.InputStreamReader;
import java.io.OutputStreamWriter;
import java.io.UnsupportedEncodingException;
import java.net.HttpURLConnection;
import java.net.URL;
import java.util.HashMap;

import org.springframework.stereotype.Service;

import com.google.gson.JsonElement;
import com.google.gson.JsonObject;
import com.google.gson.JsonParser;

@Service
public class LoginService {

	private String CLIENT_ID = "";
	private String REDIRECT_URI = "http://localhost:8080/login-callback";
	private String CLIENT_SECRET = "";

    public String getAccessToken (String authorize_code) throws UnsupportedEncodingException {
        String access_Token = "";
        String refresh_Token = "";
        String reqURL = "https://kauth.kakao.com/oauth/token";
        
        try {
            URL url = new URL(reqURL);
            HttpURLConnection conn = (HttpURLConnection) url.openConnection();
            conn.setRequestMethod("POST");
            conn.setDoOutput(true);
            
            BufferedWriter bw = new BufferedWriter(new OutputStreamWriter(conn.getOutputStream()));
            StringBuilder sb = new StringBuilder();
            sb.append("grant_type=authorization_code");
            sb.append("&amp;client_id="+CLIENT_ID); 
            sb.append("&amp;redirect_uri="+REDIRECT_URI); 
            sb.append("&amp;client_secret="+CLIENT_SECRET);
            sb.append("&amp;code=" + authorize_code);
            bw.write(sb.toString());
            bw.flush();
            int responseCode = conn.getResponseCode();
            System.out.println("responseCode : " + responseCode);
 
            BufferedReader br = new BufferedReader(new InputStreamReader(conn.getInputStream()));
            String line = "";
            String result = "";
            
            while ((line = br.readLine()) != null) {
                result += line;
            }
            System.out.println("response body : " + result);
            
            JsonParser parser = new JsonParser();
            JsonElement element = parser.parse(result);
            
            access_Token = element.getAsJsonObject().get("access_token").getAsString();
            refresh_Token = element.getAsJsonObject().get("refresh_token").getAsString();
            
            System.out.println("access_token : " + access_Token);
            System.out.println("refresh_token : " + refresh_Token);
            
            br.close();

        } catch (IOException e) {
            // TODO Auto-generated catch block
            e.printStackTrace();
        } 
        
        return refresh_Token;
    }
    
    public HashMap&lt;String, Object&gt; getUserInfo (String access_Token) {
        
        HashMap&lt;String, Object&gt; userInfo = new HashMap<>();
        String reqURL = "https://kapi.kakao.com/v2/user/me";
        try {
            URL url = new URL(reqURL);
            HttpURLConnection conn = (HttpURLConnection) url.openConnection();
            conn.setRequestMethod("GET");
            conn.setRequestProperty("Authorization", "Bearer " + access_Token);
            System.out.println("setRequestProperty : " + "Authorization:" + "Bearer " + access_Token);
            int responseCode = conn.getResponseCode();
            String responseMsg = conn.getResponseMessage();
            System.out.println("responseCode : " + responseCode);
            System.out.println("responseMsg : " + responseMsg);
            
            BufferedReader br = new BufferedReader(new InputStreamReader(conn.getInputStream()));
            
            String line = "";
            String result = "";
            
            while ((line = br.readLine()) != null) {
                result += line;
            }
            System.out.println("response body : " + result);
            
            JsonParser parser = new JsonParser();
            JsonElement element = parser.parse(result);
            
            JsonObject properties = element.getAsJsonObject().get("properties").getAsJsonObject();
            JsonObject kakao_account = element.getAsJsonObject().get("kakao_account").getAsJsonObject();
            
            String nickname = properties.getAsJsonObject().get("nickname").getAsString();
            String email = kakao_account.getAsJsonObject().get("email").getAsString();
            
            userInfo.put("nickname", nickname);
            userInfo.put("email", email);
            
        } catch (IOException e) {
            // TODO Auto-generated catch block
            e.printStackTrace();
        }
        
        return userInfo;
    }
}   </code></pre>
                    </div>
                    <div class="tab-pane fade" id="AndroidKotlin">
                        <p></p>
                        <a href="https://play.google.com/store/apps/details?id=com.googsu.app" target="_blank"><img src="/img/en_badge_web_generic.png" alt="google" width="222" /></a>


                        <p></p>
                        <p>Build.gradle(App) 수정</p>
                        <pre><code class="php">
plugins {
    id 'com.android.application'
    id 'kotlin-android'
    id 'kotlin-android-extensions'
}

...중략

dependencies {
    implementation "com.kakao.sdk:v2-user:2.2.0" // 카카오 로그인
    implementation "com.kakao.sdk:v2-talk:2.2.0" // 친구, 메시지(카카오톡)
    implementation "com.kakao.sdk:v2-story:2.2.0" // 카카오스토리
    implementation "com.kakao.sdk:v2-link:2.2.0" // 메시지(카카오링크)
    implementation "com.kakao.sdk:v2-navi:2.2.0" // 카카오내비
...중략
}                   </code></pre>
                        <p></p>
                        <p>Build.gradle(Module) 수정</p>
                        <pre><code class="php">
buildscript {
...중략

allprojects {
    repositories {
        google()
        jcenter()
        // Kakao SDK
        maven { url 'https://devrepo.kakao.com/nexus/content/groups/public/' }
    }
}
                 </code></pre>
                        <p></p>
                        <p>GlobalApplication 클래스 생성</p>
                        <pre><code class="php">
class GlobalApplication : Application() {
    override fun onCreate() {
        super.onCreate()f
        KakaoSdk.init(this, "ccccccccccccccccccccccccccccccccccc") //네이티브 앱 키
        var keyHash = Utility.getKeyHash(this)
        Log.d("keyHash",keyHash)
    }
}                    </code></pre>
                        <p></p>
                        <p>Login (HomeFragment)</p>
                        <pre><code class="php">
private fun kakaoLogin(root: View?) {
    val buttonkakaoLogin = root?.findViewById(R.id.kakao_login_button) as ImageButton
    val textHome = root?.findViewById(R.id.text_home) as TextView
    val callback: (OAuthToken?, Throwable?) -> Unit = { token, error ->
        if (error != null) {
            when {
                error.toString() == AuthErrorCause.AccessDenied.toString() -> { textHome.text = "AccessDenied :"+error.message }
                error.toString() == AuthErrorCause.InvalidClient.toString() -> { textHome.text = "InvalidClient :"+error.message }
                error.toString() == AuthErrorCause.InvalidGrant.toString() -> { textHome.text = "InvalidGrant :"+error.message }
                error.toString() == AuthErrorCause.InvalidRequest.toString() -> { textHome.text = "InvalidRequest :"+error.message }
                error.toString() == AuthErrorCause.InvalidScope.toString() -> { textHome.text = "InvalidScope :"+error.message }
                error.toString() == AuthErrorCause.Misconfigured.toString() -> { textHome.text = "Misconfigured :"+error.message }
                error.toString() == AuthErrorCause.ServerError.toString() -> { textHome.text = "ServerError :"+error.message }
                error.toString() == AuthErrorCause.Unauthorized.toString() -> { textHome.text = "Unauthorized :"+error.message  }
                else -> { textHome.text = error.message }
            }
        }
        else if (token != null) {
            textHome.text = "로그인에 성공하였습니다."
            val intent = Intent(requireContext(), SecondActivity::class.java)
            startActivity(intent)
        }
    }

    buttonkakaoLogin.setOnClickListener {
        if(LoginClient.instance.isKakaoTalkLoginAvailable(requireContext())){
            LoginClient.instance.loginWithKakaoTalk(requireContext(), callback = callback)
        }else{
            LoginClient.instance.loginWithKakaoAccount(requireContext(), callback = callback)
        }
    }
}                    </code></pre>
                        <p></p>
                        <p>SecondActivity에서 로그인 성공 이후 처리</p>
                        <pre><code class="php">
// 프로필 정보
UserApiClient.instance.me { user, error ->
    id.text = "회원번호: ${user?.id}"
    nickname.text = "닉네임: ${user?.kakaoAccount?.profile?.nickname}"
    profileimage_url.text = "프로필 링크: ${user?.kakaoAccount?.profile?.profileImageUrl}"
    thumbnailimage_url.text = "썸네일 링크: ${user?.kakaoAccount?.profile?.thumbnailImageUrl}"
}                   

// Log out
kakao_logout_button.setOnClickListener {
    UserApiClient.instance.logout { error ->
        if (error != null) {
            Toast.makeText(this, "로그아웃 실패 $error", Toast.LENGTH_SHORT).show()
        }else {
            Toast.makeText(this, "로그아웃 성공", Toast.LENGTH_SHORT).show()
        }
        val intent = Intent(this, MainActivity::class.java)
        startActivity(intent.addFlags(FLAG_ACTIVITY_CLEAR_TOP))
    }
}

// UnLink
kakao_unlink_button.setOnClickListener {
    UserApiClient.instance.unlink { error ->
        if (error != null) {
            Toast.makeText(this, "unlink 실패 $error", Toast.LENGTH_SHORT).show()
        }else {
            Toast.makeText(this, "unlink 성공", Toast.LENGTH_SHORT).show()
            val intent = Intent(this, MainActivity::class.java)
            startActivity(intent.addFlags(FLAG_ACTIVITY_CLEAR_TOP))
        }
    }
}


</code></pre>
                    </div>
                </div>
            </li>
        </ul>
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script>
        hljs.initHighlightingOnLoad();
        document.querySelectorAll("code").forEach(function(element) {
            element.innerHTML = element.innerHTML.replace(/&/g, "&amp;").replace(/</g, "&lt;").replace(/>/g, "&gt;").replace(/"/g, "&quot;").replace(/'/g, "&#039;");
        });
    </script>
</body>

</html>