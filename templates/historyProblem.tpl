{foreach from=$historyEntries key=i item=p}
  <h4>
    <a href="{$wwwRoot}historyDiff?id={$p->id}">{"Entry"|_}</a>{" by"|_}
    {$authorNames[$i]}
    {"on "|_}
    {$p->created|date_format:"%d.%m.%Y %H:%M"}
  </h4>
{/foreach}
