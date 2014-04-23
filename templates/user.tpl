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
  {"Role:"|_}
  {if $theUser->admin }
 		{"administrator"|_}
  {else}
 	 	{"regular user"|_}
  {/if}
</h3>
{if $theProblems !=null}
  <h3>{"Problems submitted:"|_}</h3>
{/if}
<ul>
  {foreach from=$theProblems item=p}
    <li><a href="{$wwwRoot}problem?id={$p->id}">{$p->name}</a></li>
  {/foreach}
</ul>
