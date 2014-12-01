<p class="paragraphTitle">{"Edit your avatar"|_}</p>

{"Cut a square area in the image below. The selected area will be automatically resized to 100x100 pixels. This is the standard size of your profile picture."|_}

<div id="rawAvatarContainer">
  <img id="jcropTarget" src="{$wwwRoot}img/user/{$rawFileName}" alt="profile picture"/>
</div>

<p class="paragraphTitle">{"Preview"|_}</p>

<form id="avatarForm" action="saveAvatar" method="post">
  <div id="avatarPreviewContainer">
    <img id="jcropPreview" src="{$wwwRoot}img/user/{$rawFileName}" alt="preview" class="jcrop-preview" />
  </div>
  <input type="hidden" name="x0" value=""/>
  <input type="hidden" name="y0" value=""/>
  <input type="hidden" name="side" value=""/>
  
  {"Press the Save button when you are done."|_}
  
  <input type="submit" name="submit" value="Save"/>
  <a href="saveAvatar?discard=1" onclick="return confirm('Discard changes?');">Discard</a>
</form>
