<br />

<a href="ical.php?startdate={$Grid.Row.date_start.DisplayValue|date_format:'%Y%m%d'}&enddate={$Grid.Row.date_end.DisplayValue|date_format:'%Y%m%d'}&projectname={$Grid.Row.project_name.DisplayValue}&details={$Grid.Row.project_name.DisplayValue}&description={$Grid.Row.notes.DisplayValue|truncate:80}"><img src="images/ical.png" width="40" height="40"/>&nbsp;&nbsp;&nbsp;<b>Add Project Calendar to Outlook</b></a>

<br />

<br />
<p>



<div class="page-header">
    <h1>{$Grid.Row.project_name.DisplayValue}</h1>
</div>

<div class="container-fluid">

    <br>

    <div class="row-fluid">
        <div class="span6">
            <table class="table pgui-record-card">
                <tbody>
                    {foreach from=$Grid.Row item=Cell}
                    <tr>
                        <td>
                            <strong>{$Cell.Caption}</strong>
                        </td>
                        <td>
                            {$Cell.DisplayValue}
                        </td>
                    </tr>
                    {/foreach}
                </tbody>
            </table>
        </div>

    </div>
    <div class="row-fluid">
        <div class="btn-toolbar">
            <div class="btn-group">
                <a class="btn btn-primary" href="{$Grid.CancelUrl|escapeurl}">{$Captions->GetMessageString('BackToList')}</a>
            </div>

        {if count($Grid.Details) > 0}
            <div class="btn-group">
                <a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
                    {$Captions->GetMessageString('ManageDetails')}
                    <span class="caret"></span>
                </a>
                <ul class="dropdown-menu">
                    {foreach from=$Grid.Details item=Detail}
                    <li><a href="{$Detail.Link|escapeurl}">{$Detail.Caption|string_format:$Captions->GetMessageString('ManageDetail')}</a></li>
                    {/foreach}
                </ul>
            </div>
        {/if}

        {if $Grid.PrintOneRecord}
            <div class="btn-group">
                <a class="btn" href="{$Grid.PrintRecordLink|escapeurl}">
                    <i class="pg-icon-print-page icon-white"></i>
                    {$Captions->GetMessageString('PrintOneRecord')}
                </a>
            </div>
        {/if}



        </div>
    </div>
</div>

{*
<div align="center" style="width: auto">
    {if $PrintOneRecord}
    <div align="right" style="width: 500px; padding-bottom: 3px;" class="auxiliary_header_text">
        <a href="{$PrintRecordLink|escapeurl}">{$Captions->GetMessageString('PrintOneRecord')}</a>
    </div>
    {/if}
    <table class="grid" style="width: 500px">
        <tr><th dir="ltr" class="even" colspan=2>
            {$Title}
        </th></tr>
{section name=RowGrid loop=$ColumnCount}
        <tr class="{if $smarty.section.RowGrid.index is even}even{else}odd{/if}"{if $RowCssStyles[$smarty.foreach.RowsGrid.index] != ''} style="{$RowCssStyles[$smarty.foreach.RowsGrid.index]}"{/if}>
            <td class="odd" style="padding-left:20px;"><b>{$Columns[$smarty.section.RowGrid.index]->GetCaption()}</b></td>
            <td class="even" style="padding-left:10px;">
                {$Row[$smarty.section.RowGrid.index]}
            </td>
        </tr>
{/section}
        <tr height="40" class="editor_buttons"><td colspan="2" align="center" valign="middle">
            <input class="sm_button" type="button" value="{$Captions->GetMessageString('BackToList')}" onclick="window.location.href='{$Grid->GetReturnUrl()}'"/>
        </td></tr>
    </table>
</div>

*}