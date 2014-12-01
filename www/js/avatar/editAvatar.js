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
