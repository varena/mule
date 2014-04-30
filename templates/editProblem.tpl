<form action="" method="post">
  
  <input type="text" {if !$canEditName }disabled{/if} name="problemName" value = "{$problem->name}">

  <textarea name="problemStatement" id="markdown" cols="80" rows="20">{$problem->statement}</textarea>

  <input type="submit" value='{"Submit"|_}'>
</form>