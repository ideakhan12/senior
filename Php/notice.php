<?php
   session_start();

   if(!isset($_SESSION['id']))
   {
      header ('Location: ./login.html');
   }
?>
<!DOCTYPE>
<html>
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
  <link rel="stylesheet" href="//code.jquery.com/mobile/1.5.0-alpha.1/jquery.mobile-1.5.0-alpha.1.min.css">
  <script src="//code.jquery.com/jquery-3.2.1.min.js"></script>
  <script src="//code.jquery.com/mobile/1.5.0-alpha.1/jquery.mobile-1.5.0-alpha.1.min.js"></script>
  <script src="fullsize.js"></script>

   <style>
   /* 웹 폰트 */
   @import url(https://fonts.googleapis.com/css?family=Roboto:300);

   html, body, div[data-role="page"], div[data-role="content"]
   {
      width:100%;
      background: #ffffff;
      font-family: "Roboto", sans-serif;
      margin: 0px;
      padding: 0px;
   }

   /* 상단바 색상 */
   .ui-page .ui-header
   {
      background-color: #e74c3c;
      border-style: none;
   }
   #background
   {
      background: linear-gradient( rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5) ), url('img/back01.jpg');
       height: :100%;
       background-size: cover;
      background-repeat: no-repeat;
      text-align: center;
   }

   hr
   {
      background-color: #eeeeee; 
      height: 1px; 
      border: 0;
   }
   #custom-collapsible {
       width: 100% !important; 
       margin-left: 15px !important; 
       background-color: white  !important;
   }

   #custom-collapsible h4 a 
   {
       background: white  !important;
   }
</style>
   <script>
      function logout()
      {
         var answer = confirm("로그아웃 하시겠습니까?")
         if (answer)
         {
            location.href="/logout.php";
         }
      }

   </script>
</head>
<body>
   <div data-role="page">
      <div data-role="navbar" align="center" style="background-color: #ffffff">
         <ul style="margin-top:0.7em">
            <li></li>
            <li style="margin-top:0.2em"><font size="4.5em" face="sans-serif" style="cursor:pointer"
               onclick="window.location.href='./index.php'">누구세홈</font></li>
            <li><img src="img/cancel.png" width="23em" style="margin-left:4.4em; margin-top:-0.6em; margin-bottom:-0.4em; cursor:pointer" onclick="logout()" ></li>
         </ul>
         <hr/>

      </div>
      <div data-role="content" align="center">
         <div style="width:98%; background-image:url(img/notice_imgbar.jpg); 
        background-size:100%; height:27%; text-align:left; margin-top:0.2em; font-family:sans-serif;">
        <p style="font-size:1.5em; margin-left:1.5em; margin-top:0.1em; padding-top:2.9em; color:white">
          공지사항</p>
        <p style="font-size:0.7em; margin-left:3.3em; color:white; margin-top:-1.8em">
        공지사항 입니다</p>
      </div>
         <div style="width:95%; margin:auto; padding:auto" id="custom-collapsible">
         <?php
            include('config.php');
            $sql = "SELECT * FROM notice order by w_date desc limit 5";
            $result = mysqli_query($con, $sql);

            while( $data = mysqli_fetch_array($result))
            { 
               $no = $data['no'];
               $title = $data['title'];
               $contents = $data['contents'];
               $w_date = date("Y-m-d", strtotime($data['w_date']));

               echo "<div data-role='collapsible' data-mini='true' 
               data-collapsed-icon='arrow-r' data-expanded-icon='arrow-d' data-inset='false'>";
               echo "<h4>　", $title, "</h4>";
               echo "<h5>", $contents, "</h5>";
               echo "</div>";
            }
         ?>
         </div>
      </div>
   </div>
</body>
</html>