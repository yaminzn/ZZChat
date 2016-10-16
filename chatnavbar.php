<nav class="navbar navbar-default navbar-static-top no-margin-bottom">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <span id="roomName" class="navbar-brand" href="#">RoomName</span>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li><a ng-href="" id="userlist" data-toggle="popover"><div class="container-fluid"><span id="userlistSpan">Users list</span><span class="glyphicon glyphicon-user"> </span></div></a></li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-cog"></span><span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="#">Add friends</a></li>
            <li><a href="#">Kick friends</a></li>
            <li role="separator" class="divider"></li>
            <li><a href="#">Rename chatroom</a></li>
            <li><a href="#">Clean all messages</a></li>                        
            <li><a href="#">Delete chatroom</a></li>
          </ul>
        </li>
    </ul>
    <ul class="nav navbar-nav navbar-right">
    	<li><a href="#"><span class="glyphicon glyphicon-bell"></span></a></li>
    	<li><a href="#" id="bookmarkBtn" ><span id="bookmarkGlyph" class="glyphicon glyphicon-heart-empty"></span></a></li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Help<span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="#">Stats</a></li>
            <li><a href="#">Chat commands</a></li>
            <li><a href="#">Shortcuts</a></li>
          </ul>
        </li>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>