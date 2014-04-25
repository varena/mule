<h3>{$problem->name}</h3>

{if $canEdit}
<h5>
	<a href="{$wwwRoot}editProblem?id={$problem->id}"> {"Edit"|_} </a>
</h5>
{/if}

<h4>
	{"Added by:"|_} 
	{if $author != null}
	{$author->getDisplayName()}
	{else}
	{"Unknown"|_}
	{/if}
</h4>
<h5>
	<a href="{$wwwRoot}attachments?id={$problem->id}"> {"Attachments"|_} </a>
</h5>
{$problem->statement}
