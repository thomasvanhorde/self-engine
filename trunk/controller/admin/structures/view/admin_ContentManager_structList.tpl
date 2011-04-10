<table>
    <tr>
        <th>Nom</th>
        <th>Description</th>
        <th></th>
        <th></th>
        <th></th>
    </tr>
    {foreach from=$struct key=k item=element}
        <tr>
            <td>
                { $element.name }
            </td>
            <td>
                { $element.description|truncate:60:'..':true:true }
            </td>
            <td>
                {if $element.locked =="false"}
                    <a href="{ $k }/">Modifier</a>
                {else}
                    verrouiller
                {/if }
            </td>
            <td>
                <a href="clone/{ $k }/">Cloner</a>
            </td>
            <td>
                {if $element.locked =="false"}
                    <a href="delete/{ $k }/">Supprimer</a>
                {else}
                    verrouiller
                {/if }
            </td>
        </tr>
    {/foreach}
    <tr>
        <th>Nom</th>
        <th>Description</th>
        <th></th>
        <th></th>
        <th></th>
    </tr>    
</table>    

<br /><br />
<a href="ajouter/">Nouvelle structure</a>
<br /><br />