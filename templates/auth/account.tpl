<h3>{"My account"|_}</h3>

<form action="editAvatar" method="post" enctype="multipart/form-data">
  <p class="paragraphTitle">{"Profile picture"|_}</p>
  {include file="auth/avatar.tpl" user=$user}
  <label for="avatarFileName">{"File:"|_}</label>
  <input id="avatarFileName" type="file" name="avatarFileName">
  <input id="avatarSubmit" type="submit" name="submit" value="Edit">
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
