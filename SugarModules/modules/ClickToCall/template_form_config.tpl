<form method="POST" action="index.php" enctype="multipart/form-data">

    <input type="hidden" name="module" value="ClickToCall" />
    <input type="hidden" name="action" value="index" />

    <span class="error">{$error.main}</span>

    <table width="100%" cellpadding="0" cellspacing="0" border="0">
        <tr>
            <td>{$MOD.LBL_CLICKTOCALL_ASTERISK_IP}</td>
            <td>
                {if empty($config.clicktocall_asterisk_ip)}
                    {assign var='clicktocall_asterisk_ip' value=$clicktocall_config.clicktocall_asterisk_ip.default}
                {else}
                    {assign var='clicktocall_asterisk_ip' value=$config.clicktocall_asterisk_ip}
                {/if}
                <input
                    type="text"
                    name="clicktocall_asterisk_ip"
                    size="45"
                    value="{$clicktocall_asterisk_ip}"
                    placeholder="{$clicktocall_config.clicktocall_asterisk_ip.placeholder}" />
            </td>

            <td>{$MOD.LBL_CLICKTOCALL_ASTERISK_PORT}</td>
            <td>

                {if empty($config.clicktocall_asterisk_port)}
                    {assign var='clicktocall_asterisk_port' value=$clicktocall_config.clicktocall_asterisk_port.default}
                {else}
                    {assign var='clicktocall_asterisk_port' value=$config.clicktocall_asterisk_port}
                {/if}
                <input
                    type="text"
                    name="clicktocall_asterisk_port"
                    size="45"
                    value="{$clicktocall_asterisk_port}"
                    placeholder="{$clicktocall_config.clicktocall_asterisk_port.placeholder}" />

            </td>
        </tr>

    </table>

    <br />

    <div>
        <input title="{$APP.LBL_SAVE_BUTTON_TITLE}" class="button"  type="submit" name="save" value="{$APP.LBL_SAVE_BUTTON_LABEL}" />
        <input title="{$MOD.LBL_CANCEL_BUTTON_TITLE}" onclick="document.location.href='index.php?module=Administration&action=index'" class="button" type="button" name="cancel" value="{$APP.LBL_CANCEL_BUTTON_LABEL}" />
    </div>

</form>

