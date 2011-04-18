<ul id="main-nav">  <!-- Accordion Menu -->

    <li>
        <a href="{$SYS_FOLDER}admin/" class="{if $myCompletURL == 'admin'}current {/if}nav-top-item no-submenu"> <!-- Add the class "no-submenu" to menu items with no sub menu -->
            Administration
        </a>
    </li>
    <li>
        <a href="{$SYS_FOLDER}admin/media/" class="{if $myCompletURL == 'admin/media'}current {/if}nav-top-item no-submenu"> <!-- Add the class "no-submenu" to menu items with no sub menu -->
            Mediathèque
        </a>
    </li>

    <li>
        <a style="padding-right: 25px;" href="#" class="{if $myURL.1 == "content-manager"}current {/if}nav-top-item"> <!-- Add the class "current" to current menu item -->
        Content Manager
        </a>
        <ul style="display: block;">
            <li><a {if $myURL.1 == "content-manager" && $myURL.2 == "structures"}class="current"{/if} href="{ $SYS_FOLDER}admin/content-manager/structures/">Structures</a></li>
            <li><a {if $myURL.1 == "content-manager" && $myURL.2 == "contenus"}class="current"{/if} href="{ $SYS_FOLDER}admin/content-manager/contenus/">Contenus</a></li>
        </ul>
    </li>


</ul> <!-- End #main-nav -->