<h3>Liste des structures</h3>

<table>
    <tr>
        <th>Nom</th>
        <th>Description</th>
        <th colspan="3">Actions</th>
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
                    Verrouillé
                {/if }
            </td>
            <td>
                <a href="clone/{ $k }/">Clôner</a>
            </td>
            <td>
                {if $element.locked =="false"}
                    <a href="delete/{ $k }/">Supprimer</a>
                {else}
                    Verrouillé
                {/if }
            </td>
        </tr>
    {/foreach}
    <tr>
        <th>Nom</th>
        <th>Description</th>
        <th colspan="3">Actions</th>
    </tr>    
</table>    

<br /><br />
<a href="ajouter/">Nouvelle structure</a>
<br /><br />