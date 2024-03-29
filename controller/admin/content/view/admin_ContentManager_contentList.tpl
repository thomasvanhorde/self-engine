<h3>Liste des contenus</h3>
{foreach from=$typeList key=k item=type}
    {if $type.locked == "false" }
        <br /><h4 name="{$type.name}">{$type.name}</h4>
        <table>
            <tr>
                {foreach from=$type.indexName key=kI item=dataI}
                    <th>{$dataI}</th>
                {/foreach}
                <th></th>
                <th></th>
            </tr>

            {foreach from=$type.data key=k2 item=dataL}
            <tr>
                {foreach from=$dataL key=k3 item=dataLI}
                    {if in_array($k3, $type.index)}
                        <td>{$dataLI|truncate:100:'..':true:true}</td>
                    {/if}
                {/foreach}
                <td>
                    <a href="{$k2}/">Éditer</a>
                </td>
                <td>
                    <a href="delete/{$k2}/">Supprimer</a>
                </td>
            </tr>
            {/foreach}
        </table>
        <a href="ajouter/{$k}/#{$type.name}">Nouvelle {$type.name}</a><br /><br />
    {/if}
{/foreach}