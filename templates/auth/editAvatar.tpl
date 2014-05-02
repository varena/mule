<p class="paragraphTitle">Edit your avatar</p>

Cut a square area in the image below. The selected area will be automatically resized to 100x100 pixels. This is the standard size of your profile
picture.

<div id="rawAvatarContainer">
  <img id="jcropTarget" src="{$wwwRoot}img/user/{$rawFileName}?cb={1000000000|rand:9999999999}" alt="profile picture"/>
</div>

<p class="paragraphTitle">Preview</p>

<form id="avatarForm" action="saveAvatar" method="post">
  <div id="avatarPreviewContainer">
    <img id="jcropPreview" src="{$wwwRoot}img/user/{$rawFileName}?cb={1000000000|rand:9999999999}" alt="preview" class="jcrop-preview" />
  </div>
  <input type="hidden" name="x0" value=""/>
  <input type="hidden" name="y0" value=""/>
  <input type="hidden" name="side" value=""/>
  
  Press the Save button when you are done.
  
  <input type="submit" name="submit" value="Save"/>
  <a href="saveAvatar?discard=1" onclick="return confirm('Discard changes?');">Discard</a>
</form>

<script type="text/javascript">
{literal}
  $(function() {
    var jcropOrigWidth, jcropOrigHeight;
  
    $('#jcropTarget').Jcrop({
      aspectRatio: 1,
      keySupport: false,
      onChange: updateJcropPreview,
      onSelect: updateJcropPreview,
    }, function() {
      var bounds = this.getBounds();
      jcropOrigWidth = bounds[0];
      jcropOrigHeight = bounds[1];
    });

    function updateJcropPreview(c) {
      if (parseInt(c.w) > 0) {
        var r = 100 / c.w;
        $('#avatarForm input[name=x0]').val(c.x);
        $('#avatarForm input[name=y0]').val(c.y);
        $('#avatarForm input[name=side]').val(c.w);

        $('#jcropPreview').css({
          width: Math.round(r * jcropOrigWidth) + 'px',
          height: Math.round(r * jcropOrigHeight) + 'px',
          marginLeft: '-' + Math.round(r * c.x) + 'px',
          marginTop: '-' + Math.round(r * c.y) + 'px'
        });
      }
    };
  });
{/literal}
</script>
