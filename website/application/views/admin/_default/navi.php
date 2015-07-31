
  <header class="navbar navbar-fixed-top navbar-inverse">
    <div class="container">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="/admin">首頁</a>
      <div class="navbar-collapse n0av-collapse collapse navbar-header">
        <ul class="nav navbar-nav">

          <li class="dropdown">
            <a href="#" class="dropdown-toggle js-activated" data-toggle="dropdown">{menu_admin_message}<b class="caret"></b></a>
            <ul class="dropdown-menu">
              <li><a tabindex="-1" href="/admin/message/view">{message_view_all}</a></li>
              <li class="divider"></li>
              <li><a tabindex="-1" href="/admin/message/view">{message_review_pending}</a></li>
              <li><a tabindex="-1" href="/admin/message/view">{message_review_pass}</a></li>
              <li><a tabindex="-1" href="/admin/message/view">{message_review_reject}</a></li>
            </ul>
          </li>      

          <li class="dropdown">
            <a href="#" class="dropdown-toggle js-activated" data-toggle="dropdown">{menu_admin_photo}<b class="caret"></b></a>
            <ul class="dropdown-menu">
              <li><a tabindex="-1" href="/admin/photo/view">{photo_view_all}</a></li>
              <li class="divider"></li>
              <li><a tabindex="-1" href="/admin/photo/view/">{photo_review_pending}</a></li>
              <li><a tabindex="-1" href="/admin/photo/view/">{photo_review_pass}</a></li>
              <li><a tabindex="-1" href="/admin/photo/view/">{photo_review_reject}</a></li>
            </ul>
          </li>      
          <li class="dropdown">
            <a href="#" class="dropdown-toggle js-activated" data-toggle="dropdown">訂單<b class="caret"></b></a>
            <ul class="dropdown-menu">
              <li><a tabindex="-1" href="/admin/orders/view">總覽</a></li>
              <li class="divider"></li>
              <li><a tabindex="-1" href="/admin/orders/view/CD081E64-8314-4C4F-B010-EF734BCE6FB1">未到期訂單</a></li>
              <li><a tabindex="-1" href="/admin/orders/view/3D06BDFD-B2FB-41DA-A472-E7DB9854D8B4">已到期訂單</a></li>
                
            </ul>
          </li>

          <li class="dropdown">
            <a href="#" class="dropdown-toggle js-activated" data-toggle="dropdown">{menu_admin_member}<b class="caret"></b></a>
            <ul class="dropdown-menu">
              <li><a tabindex="-1" href="/admin/member/view">{rank_view_all}</a></li>
              <li class="divider"></li>
              <li><a tabindex="-1" href="/admin/member/view/6A928D1F-EB98-4D78-A792-F8B35B03E166">{rank_unvalidate}</a></li>
              <li><a tabindex="-1" href="/admin/member/view/6A928D1F-EB98-4D78-A792-F8B35B03E166">{rank_validated}</a></li>
              <li><a tabindex="-1" href="/admin/member/view/6A928D1F-EB98-4D78-A792-F8B35B03E166">{rank_review_process}</a></li>
              <li><a tabindex="-1" href="/admin/member/view/6A928D1F-EB98-4D78-A792-F8B35B03E166">{rank_review_pass}</a></li>
              <li><a tabindex="-1" href="/admin/member/view/8C06A53F-4971-4954-9C6B-D3EC709A3BC9">{rank_review_not_pass}</a></li>
              <li><a tabindex="-1" href="/admin/member/view/8C06A53F-4971-4954-9C6B-D3EC709A3BC9">{rank_advance_vip}</a></li>
              <li><a tabindex="-1" href="/admin/member/view/8C06A53F-4971-4954-9C6B-D3EC709A3BC9">{rank_deleted}</a></li>
              <li><a tabindex="-1" href="/admin/member/view/8C06A53F-4971-4954-9C6B-D3EC709A3BC9">{rank_forbidden}</a></li>
              <li><a tabindex="-1" href="/admin/member/view/B5F90B86-52AE-4F8B-BDB6-E7C7CC8325FB">{rank_administrator}</a></li>
           </ul>
          </li>
          <li class="dropdown">
            <a href="#" class="dropdown-toggle js-activated" data-toggle="dropdown">{menu_admin_account}<b class="caret"></b></a>
            <ul class="dropdown-menu">
              <li><a tabindex="-1" href="/admin/account/settings">{account_change_settings}</a></li>
              <li><a tabindex="-1" href="/admin/account/change_password">{account_change_password}</a></li>
              <li class="divider"></li>
              <li><a tabindex="-1" href="/logout">{account_logout}</a></li>
            </ul>
          </li>
        </ul>
      </div> <!-- .nav-collapse -->
    </div> <!-- .container -->
  </header> <!-- .navbar -->
<div id="bs_alert">
    <div class="alert alert-{alert_type} alert-dismissible" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <div id="alert_content">{alert_content}</div>
    </div>
</div>
<script>
$(function() {
    $('.js-activated').dropdownHover().dropdown();
    if( $('#alert_content').text() != ''){
        $('#bs_alert').fadeIn();
    }
});
</script>