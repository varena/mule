<h3>{$problem->name}</h3>

<h4>
  {"Added by:"|_} 
  {if $author != null}
    {$author->getDisplayName()}
  {else}
    {"Unknown"|_}
  {/if}
</h4>

{$problem->statement}
