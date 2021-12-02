{if $theme_path && !$ssx_disable_header}
	{include file="$theme_path/header.tpl"}
{/if}

{if $ssx_content_path}
	{include file=$ssx_content_path}
{/if}

{if $theme_path && !$ssx_disable_footer}
	{include file="$theme_path/footer.tpl"}
{/if}