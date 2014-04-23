<h3>{$theRound->name}</h3>
<h3>{"Start date: "|_} {$timeCreated}</h3>
<h3>{"Duration: "|_} {$theRound->duration}</h3>
<h3>
  {"Creator: "|_}
  {if $theCreator }
    {$theCreator->getDisplayName()}
  {else}
    {"Unknown"|_}
  {/if}
</h3>

{if $theProblems}
  <h3>{"Problems:"|_}</h3>
{/if}

<ul>
  {foreach from=$theProblems item=p}
    <li><a href="{$wwwRoot}problem?id={$p->id}">{$p->name}</a></li>
  {/foreach}
</ul>
