<{if $breadcrumb|default:false}><div class="breadcrumb"><{$breadcrumb}></div><{/if}>
<div><{if isset($topicbanner)}><{$topicbanner}><{/if}></div>

<{if $displaynav == true}>
  <div style="text-align: center;">
    <{$topic_form.javascript}>
        <form name="<{$topic_form.name}>" id="<{$topic_form.name}>" action="<{$topic_form.action}>" method="<{$topic_form.method}>">
    <table id="topicform" cellspacing="0">
    <!-- start of form elements loop -->
    <tr valign="top">
    <td>
    <{foreach item=element from=$topic_form.elements}>
      <{if $element.hidden != true}>
            <{$element.body}>&nbsp;
      <{else}>
        <{$element.body}>
      <{/if}>
    <{/foreach}>
    </td>
    </tr>
    <!-- end of form elements loop -->
    </table>
  </form>
  <hr />
  </div>
<{/if}>

<div style="margin: 10px;"><{$pagenav}></div>
<table width="100%" border="0">
    <tr><td width="<{$columnwidth}>%"><ul>
        <!-- start news item loop -->
        <{counter assign=story_count start=0 print=false}>
        <{section name=i loop=$stories}>
            <li><a href="<{$xoops_url}>/modules/AMS/article.php?storyid=<{$stories[i].id}>"><{$stories[i].title}></a> (<{$stories[i].posttime}>)</li>
        <{counter}>
        <{/section}>
    </ul></td></tr>
</table>

<div style="text-align: right; margin: 10px;"><{$pagenav}></div>
<{include file='db:system_notification_select.tpl'}>
<br>
