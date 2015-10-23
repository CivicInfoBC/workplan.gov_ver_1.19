<table align="center" width="95%" border="0" cellpadding="3" cellspacing="2">
    <tr valign="top">

{*{foreach item=Column from=$Columns}
        <td><b>{$Column->GetCaption()}</b></td>
{/foreach}*}

    <td><b>{$Columns[0]->GetCaption()}</b></td>
    <td><b>{$Columns[1]->GetCaption()}</b></td>
    <td><b>{$Columns[2]->GetCaption()}</b></td>
    <td><b>Task</b></td>
    <td><b>Date</b></td>
    </tr>

{foreach item=Row from=$Rows name=RowsGrid}
    <tr valign="top">
    <!---->
{*{foreach item=RowColumn from=$Row}
        <td>
            {$RowColumn}
        </td>
{/foreach}*}
    <!---->
    <td>{$Row[0]}</td>
    <td>{$Row[1]}</td>
    <td>{$Row[2]}</td>
    <td><b>{$Row[4]}</td>
    
    </tr>
{/foreach}

{if $Grid->HasTotals()}
    <tr>
    {foreach item=Total from=$Totals}
    {strip}
        <td>
        {if not $Total.IsEmpty}
            {if $Total.CustomValue}
                {$Total.UserHTML}
            {else}
                {$Total.Aggregate} = {$Total.Value}
            {/if}
        {/if}
        </td>
    {/strip}
    {/foreach}
    </tr>
{/if}

</table>

<p>
City of Courtenay sample timesheet.
</p>