{assign var=i value=0}
{foreach from=$theHistoryEntries item=p}
	<h4><a href="{$wwwRoot}history_diff?id={$p->id}">{"Entry"|_}</a>{" by"|_}
        {$authorNames[$i]}
        {"on "|_}
        {$date[$i]}   
   	</h4>
   	{assign var=i value=$i+1}
{/foreach}