<h3>{"Varena is working for you!"|_} {$smarty.now|vdf:TimeUtil::FORMAT_DAY:false}</h3>

{"Problems:"|_}

<ul>
  {foreach from=$problems item=p}
    <li><a href="{$wwwRoot}problem?id={$p->id}">{$p->name}</a></li>
  {/foreach}
</ul>
