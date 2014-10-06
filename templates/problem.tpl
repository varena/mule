<h3>{$problem->name}</h3>

{if $canEdit}
<h5>
  <a href="{$wwwRoot}editProblem?id={$problem->id}"> {"Edit"|_} </a>
</h5>
{/if}

<h5>
  <a href="{$wwwRoot}attachments?id={$problem->id}">{"Attachments"|_}</a>
</h5>
<h4>
  {"Added by:"|_} 
  {if $author != null}
    {$author->getDisplayName()}
  {else}
    {"Unknown"|_}
  {/if}
</h4>

{$problem->statement}
<br> <br>
{if $user}

  <form action="" method="post" enctype="multipart/form-data">
    <label for="file">File:</label>
    <input type="file" name="file" id="file">
    <input class="btn_name" type="submit" name="submit" value="Submit"|_>
  </form>
  <br>

{else}
  <h4>
    {"You must log in to send sources."|_}
  <h4>
{/if}
