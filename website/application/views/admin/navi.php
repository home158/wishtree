  <style type="text/css">
    body { padding-top: 50px; min-height: 410px }
    .navbar .container { margin-top:0px; margin-bottom:0px; }
  </style>
  <header class="navbar navbar-fixed-top navbar-inverse">
    <div class="container">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="/admin">首頁</a>
      <div class="navbar-collapse nav-collapse collapse navbar-header">
        <ul class="nav navbar-nav">
          <li class="dropdown">
            <a href="#" class="dropdown-toggle js-activated">最新消息<b class="caret"></b></a>
            <ul class="dropdown-menu">
              <li><a href="/admin/news/view">小善心新鮮農事</a></li>
              <li><a href="/admin/news/promotion">好康組合資訊</a></li>
            </ul>
          </li>
          <li class="dropdown">
            <a href="#" class="dropdown-toggle js-activated" data-toggle="dropdown">蔬果培育記事<b class="caret"></b></a>
            <ul class="dropdown-menu">
              <li><a tabindex="-1" href="/admin/notepad/farm_village">小善心農園介紹</a></li>
              <li><a tabindex="-1" href="/admin/notepad/process">蔬果生產流程</a></li>
              <li><a tabindex="-1" href="/admin/notepad/growing">專業技術培植</a></li>
              <li><a tabindex="-1" href="/admin/notepad/vegetable">蔬果種類介紹</a></li>
              <li><a tabindex="-1" href="/admin/notepad/farmer">小善心農夫群</a></li>
            </ul>
          </li>
          <li class="dropdown">
            <a href="#" class="dropdown-toggle js-activated" data-toggle="dropdown">當季鮮蔬果<b class="caret"></b></a>
            <ul class="dropdown-menu">

              <li><a tabindex="-1" href="/admin/seasonal">當季鮮蔬果</a></li>
            </ul>
          </li>
          <li class="dropdown">
            <a href="#" class="dropdown-toggle js-activated" data-toggle="dropdown">產品管理<b class="caret"></b></a>
            <ul class="dropdown-menu">
              <li><a tabindex="-1" href="/admin/products/view">總覽</a></li>
              <li class="divider"></li>
              {navi_list}
              <li><a tabindex="-1" href="/admin/products/view/{GUID}">{CategoryName}</a></li>
              {/navi_list}
              <li class="divider"></li>
              <li><a tabindex="-1" href="/admin/products/category">類別管理</a></li>
            </ul>
          </li>          <li class="dropdown">
            <a href="#" class="dropdown-toggle js-activated" data-toggle="dropdown">訂單<b class="caret"></b></a>
            <ul class="dropdown-menu">
              <li><a tabindex="-1" href="/admin/orders/view">總覽</a></li>
              <li class="divider"></li>
              <li><a tabindex="-1" href="/admin/orders/view/CD081E64-8314-4C4F-B010-EF734BCE6FB1">未出貨訂單</a></li>
              <!--<li><a tabindex="-1" href="/admin/orders/view/9AF999A6-550F-4FCD-93AF-24222D79EB31">部份出貨訂單</a></li>-->
              <li><a tabindex="-1" href="/admin/orders/view/3D06BDFD-B2FB-41DA-A472-E7DB9854D8B4">已出貨訂單</a></li>
                
            </ul>
          </li>

          <li class="dropdown">
            <a href="#" class="dropdown-toggle js-activated" data-toggle="dropdown">會員中心<b class="caret"></b></a>
            <ul class="dropdown-menu">
              <li><a tabindex="-1" href="/admin/members/view">總覽</a></li>
              <li class="divider"></li>
              <li><a tabindex="-1" href="/admin/members/view/6A928D1F-EB98-4D78-A792-F8B35B03E166">一般會員</a></li>
              <li><a tabindex="-1" href="/admin/members/view/8C06A53F-4971-4954-9C6B-D3EC709A3BC9">停權會員</a></li>
              <li><a tabindex="-1" href="/admin/members/view/B5F90B86-52AE-4F8B-BDB6-E7C7CC8325FB">管理員</a></li>
           </ul>
          </li>
          <li class="dropdown">
            <a href="#" class="dropdown-toggle js-activated" data-toggle="dropdown">管理者帳戶<b class="caret"></b></a>
            <ul class="dropdown-menu">
              <li><a tabindex="-1" href="/admin/account/change_password">更改密碼</a></li>
              <li class="divider"></li>
              <li><a tabindex="-1" href="/admin/account/logout">登出</a></li>
            </ul>
          </li>
        </ul>
      </div> <!-- .nav-collapse -->
    </div> <!-- .container -->
  </header> <!-- .navbar -->
  <script>
    // very simple to use!
    $(document).ready(function() {
      $('.js-activated').dropdownHover().dropdown();
    });
  </script>
