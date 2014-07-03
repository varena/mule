$('#avatarFileName').change(function() {
  var error = '';
  var allowedTypes = ['image/gif', 'image/jpeg', 'image/png'];
  if (this.files[0].size > (1 << 21)) {
    error = 'Maximum file size allowed is 2 MB.';
  } else if (allowedTypes.indexOf(this.files[0].type) == -1) {
    error = 'Invalid file type.';
  }
  if (error) {
    $('#avatarFileName').val('');
    $('#avatarSubmit').attr('disabled', 'disabled');
    alert(error);
  } else {
    $('#avatarSubmit').removeAttr('disabled');
  }
  return false;
});
