<h3><center>{"my account"|_}</center></h3>

<form action="editAvatar" method="post" enctype="multipart/form-data">
  <p class="paragraphTitle">avatar</p>
  {include file="auth/avatar.tpl" user=$user}
  <label for="avatarFileName">File:</label>
  <input id="avatarFileName" type="file" name="avatarFileName">
  <input id="avatarSubmit" type="submit" name="submit" value="Edit" disabled="disabled">
  <a href="saveAvatar?delete=1" onclick="return confirm('Confirm deleting the image?');">Delete image</a>
</form>

<form method="post">
  <table class="form">
    <tr>
      <td><label for="username">{"username"|_}:</label></td>
      <td>
        {if $firstLogin}
          <input type="text" id="username" name="username" value="{$editUser->username}" maxlength="20" placeholder="{"choose a username"|_}" autofocus>
          <div class="fieldDesc">{"required; 3-20 characters including letters, digits, '-', '.' and '_'"|_}</div>
        {else}
          {$editUser->username}
        {/if}
      </td>
    </tr>
    <tr>
      <td><label for="name">{"name"|_}:</label></td>
      <td>
        <input type="text" id="name" name="name" value="{$editUser->name}" maxlength="50" placeholder="{"enter your full name"|_}">
        <div class="fieldDesc">{"optional; 3-50 characters"|_}</div>
      </td>
    </tr>
    <tr>
      <td><label for="email">{"email"|_}:</label></td>
      <td>
        <input type="text" id="email" name="email" value="{$editUser->email}" maxlength="50" placeholder="{"enter your email address"|_}">
        <div class="fieldDesc">{"optional; 3-50 characters"|_}</div>
      </td>
    </tr>
    <tr>
      <td colspan="2"><input type="submit" name="submitButton" value="{"save"|_}"></td>
    </tr>
  </table>
</form>

{if $identities}
  <h3>{"OpenID identities"|_}</h3>

  <ul>
    {foreach from=$identities item=i}
      <li>{$i->openId}</li>
    {/foreach}
  </ul>

  <a href="login">{"link another OpenID to this account"|_}</a>
{/if}

<script type="text/javascript">
{literal}
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
{/literal}
</script>
