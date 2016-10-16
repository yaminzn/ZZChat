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
            <li><a href="#" data-toggle="modal" data-target="#modalRenameChatroom">Rename chatroom</a></li>
            <li><a href="#" data-toggle="modal" data-target="#modalChangeChatroomDescription">Change description</a></li>                       
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

<div class="modal fade" id="modalRenameChatroom" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Rename chatroom</h4><br />
        <form id="formRenameChatroom" action="javascript:void(0);">
          <div class="form-group">
            <label for="previousChatroomName">Previous name</label>
            <input type="text" class="form-control" id="previousChatroomName" disabled>
          </div>
          <div class="form-group">
            <label for="newChatroomName">New name</label>
            <input type="text" class="form-control" name="newChatroomName" id="newChatroomName" required autofocus>
          </div>
          <button id="submitBtnNewChatroomName" type="submit" class="btn btn-primary">Save changes</button>
        </form>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="modalChangeChatroomDescription" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Change chatroom description</h4><br />
        <form id="formChangeChatroomDescription" action="javascript:void(0);">
          <div class="form-group">
            <label for="previousChatroomDescription">Previous description</label>
            <div id="previousChatroomDescription"></div>
          </div>
          <div class="form-group">
            <label for="newChatroomDescription">New description</label>
            <textarea class="form-control" name="newChatroomDescription" id="newChatroomDescription" rows="5" autofocus></textarea>
          </div>
          <button id="submitBtnChangeChatroomDescription" type="submit" class="btn btn-primary">Save changes</button>
        </form>
      </div>
    </div>
  </div>
</div>