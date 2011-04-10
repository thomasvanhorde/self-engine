<ul id="main-nav">  <!-- Accordion Menu -->

				<li>
					<a href="/{$SYS_FOLDER}admin/" class="nav-top-item no-submenu"> <!-- Add the class "no-submenu" to menu items with no sub menu -->
						Administration
					</a>
				</li>

				<li>
					<a style="padding-right: 25px;" href="#" class="nav-top-item current"> <!-- Add the class "current" to current menu item -->
					Content Manager
					</a>
					<ul style="display: block;">
                        <li><a class="current" href="{ $SYS_FOLDER}admin/content-manager/structures/">Structures</a></li>
                        <li><a href="{ $SYS_FOLDER}admin/content-manager/contenus/">Contenus</a></li>
					</ul>
				</li>


			</ul> <!-- End #main-nav -->