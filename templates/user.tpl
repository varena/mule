<h3>{$theUser->getDisplayName()}</h3>
<h3>{if $theUser->name !=null}
     {$theUser->name}
{/if}
</h3>

<h3>{if $theUser->email != null}
      {$theUser->email}
{/if}
</h3>
<h3> 
{if $theUser->admin != null }
	{if $theUser->admin == 1}
   		{"Administrator"|_}
    	 {else}
      	 	{"Normal User"|_}
	{/if}
    {else}
      {"Normal User null"|_}
{/if}
</h3>
<h3> {if $theProblems !=null}
    {"Probleme propuse:"|_} 
   {/if}
</h3>
<ul>
<ul>
  {foreach from=$theProblems item=p}
    <li><a href="{$wwwRoot}problem?id={$p->id}">{$p->name}</a></li>
  {/foreach}
</ul>
