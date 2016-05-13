<div class="row"
	 id="siteMenu">
	<div class="large-12 medium-12 small-12 columns">
		<div class="sticky">
			<nav class="top-bar"
				 data-topbar>
				<ul class="title-area">
					<li class="name"></li>
					<li class="toggle-topbar menu-icon">
						<a href="#">
							<span>
								Menu
							</span>
						</a>
					</li>
				</ul>

				<section class="top-bar-section">
					<!-- Left Nav Section -->
					<ul class="left">
						<li>
							<a href="index.php">
								Accueil
							</a>
						</li>
						<li class="has-dropdown">
							<a href="#">
								Gestion de la bibliothèque
							</a>
							<ul class="dropdown">
								<!-- AUTHOR MENU -->
								<li class="has-dropdown">
									<a href="#">Gestion des auteurs</a>
									<ul class="dropdown">
										<li>
											<a href="authorDisplay.php">
												Liste des auteurs
											</a>
										</li>
										<li>
											<a href="authorInsert.php">
												Ajouter un auteur
											</a>
										</li>
									</ul>
								</li>
								<!-- WORK MENU -->
								<li class="has-dropdown">
									<a href="#">Gestion des oeuvres</a>
									<ul class="dropdown">
										<li>
											<a href="workDisplay.php">
												Liste des oeuvres
											</a>
										</li>
										<li>
											<a href="workInsert.php">
												Ajouter une oeuvre
											</a>
										</li>
									</ul>
								</li>
								<!-- BOOK MENU -->
								<li class="has-dropdown">
									<a href="#">Gestion des exemplaires</a>
									<ul class="dropdown">
										<li>
											<a href="bookDisplay.php">
												Liste des exemplaires
											</a>
										</li>
										<li>
											<a href="bookInsert.php">
												Ajouter un exemplaire
											</a>
										</li>
									</ul>
								</li>
								<!-- USER MENU -->
								<li class="has-dropdown">
									<a href="#">Gestion des adhérents</a>
									<ul class="dropdown">
										<li>
											<a href="userDisplay.php">
												Liste des adhérents
											</a>
										</li>
										<li>
											<a href="userInsert.php">
												Ajouter un adhérent
											</a>
										</li>
									</ul>
								</li>
								<!-- BORROW MENU -->
								<li class="has-dropdown">
									<a href="#">Gestion des emprunts</a>
									<ul class="dropdown">
										<li>
											<a href="borrowDisplay.php">
												Liste des emprunts
											</a>
										</li>
										<li>
											<a href="borrowInsert.php">
												Ajouter un emprunt
											</a>
										</li>
									</ul>
								</li>
							</ul>
						</li>
					</ul>
					
					<!-- Right Nav Section -->
					<ul class="right">
						<li class="has-form">
							<form action="search.php"
								  method="post">
								<div class="row collapse">
									<div class="large-5 small-5 columns large-offset-3 small-offset-3">
										<label for="search">
											<input type="text"
												   id="search"
												   name="search"
												   placeholder="Rechercher..."
												   style="display: block;">
										</label>
									</div>
									<div class="large-2 small-2 columns">
										<a data-tooltip
										   aria-haspopup="true"
										   disabled=""
										   class="button tiny info
										   		  has-tip [tip-top tip-bottom tip-left tip-right] [radius round]"
										   title="Utilisez le caractère * pour personnaliser votre recherche :
												  Après un terme pour une recherche commençant par ce terme,
												  avant pour une recherche finissant par celui ci.">
											?
										</a>
									</div>
									<div class="large-2 small-2 columns">
										<input type="image"
											   src="img/search.svg"
											   class="button tiny"
											   style="display: block;">
									</div>
								</div>
							</form>
						</li>
					</ul>
				</section>
			</nav>
		</div>
	</div>
</div>