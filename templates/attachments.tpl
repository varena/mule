<h3>{"Attachments of problem"|_} {$problem->name}</h3>

<ul>
  {foreach from=$attaches item=a}
  <li><a href="{$wwwRoot}attachments.php?download={$a->id}">{$a->file}</a> Last modified: {$a->modified|varena_date_format:TimeUtil::FORMAT_FUZZY}</li>
  {/foreach}
</ul>

{if $showAttach}
<form action="" method="post"
enctype="multipart/form-data">
<label for="file">{"Filename: "|_}</label>
<input type="file" name="file[]" id="file" multiple="multiple"><br>


<select name="access_type" required>
  {foreach from=$posUploads key=i item=oneUpload}
    <option value="{$i}">{$oneUpload}</option>
  {/foreach}
</select><br>

<input type="submit" name="submit" value={"Submit"|_}>
</form>
{/if}

