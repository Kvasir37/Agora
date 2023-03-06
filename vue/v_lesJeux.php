<div class="col-sm-6">
	<section class="panel">
		<div class="chat-room-head">
			<h3><i class="fa fa-angle-right"></i> Gérer les Jeux</h3>
		</div>
		<div class="panel-body">
			<table class="table table-striped table-advance table-hover">
				<thead>
					<tr class="tableau-entete">

						<th><i class="fa fa-tag"></i> Reférence Jeux</th>
						<th><i class="fa fa-bookmark"></i> Nom</th>
						<th><i class="fa-solid fa-dollar-sign"></i> Prix</th>
						<th><i class="fa-light fa-child"></i> Pegis</th>
						<th><i class="fa-solid fa-game-console-handheld"></i> Plateforme</th>
						<th><i class="fa-solid fa-pegasus"></i> Marque</th>
						<th><i class="fa-solid fa-person-rifle"></i> Genre</th>
						<th><i class="fa fa-calendar"></i> Parution</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<form action="index.php?uc=gererJeu" method="post">
							<!-- <td>
								<input type="text" id="txtRefJeu" name="txtRefJeu" size="24" minlength="4" maxlength="24" placeholder="Référence" title="De 4 à 24 caractères" required />
							</td> -->
							<td>Nouveau jeu</td>
							<td>
								<input type="text" id="txtNomJeu" name="txtNomJeu" size="24" minlength="4" maxlength="24" placeholder="Nom du jeu" title="De 4 à 24 caractères" required />
							</td>
							<td>
								<input type="number" id="txtPrixJeu" name="txtPrixJeu" min="0" max="500" step="0.01" placeholder="Prix" />
							</td>
							<td>
								<input type="number" id="txtPegiJeu" name="txtPegiJeu" min="0" max="10" placeholder="Pegis" />
							</td>
							<td>
								<input type="number" id="txtPlatJeu" name="txtPLatJeu" min="0" max="20" placeholder="Plateforme" />
							</td>
							<td>
								<input type="number" id="txtMarqueJeu" name="txtMarquesJeu" min="0" max="30" placeholder="Marques" />
							</td>
							<td>
								<input type="number" id="txtGenreJeu" name="txtGenreJeu" min="0" max="20" placeholder="Genre" />
							</td>
							<td>
								<input type="date" id="txtDateParution" name="txtDateParution" value="2023-01-27" min="1972-01-01" max="2049-07-01" placeholder="Date de parution" />
							</td>
							<td>
								<button class="btn btn-primary btn-xs" type="submit" name="cmdAction" value="ajouterNouveauJeu" title="Enregistrer nouveau jeu"><i class="fa fa-save"></i></button>
								<button class="btn btn-info btn-xs" type="reset" title="Effacer la saisie"><i class="fa fa-eraser"></i></button>
							</td>
						</form>
					</tr>

					<?php
					foreach ($tbJeux as $jeu) {
					?>
						<tr>

						<!-- formulaire pour modifier et supprimer les genres-->
						<form action="index.php?uc=gererJeux" method="post">
						<td><?php echo $jeu->refJeu; ?><input type="hidden" name="txtRefJeu" value="<?php echo $jeu->refJeu; ?>" /></td>
						<td><?php
							if ($jeu->refJeu != $idJeuModif) {
								echo $jeu->nom;
								?>
								</td><td>
								<?php
									echo $jeu->prix;
								?>
								</td><td>
								<?php
									echo $jeu->idPegi;
								?>
								</td><td>
								<?php
									echo $jeu->idPlateforme;
								?>
								</td><td>
								<?php
									echo $jeu->idMarque;
								?>
								</td><td>
								<?php
									echo $jeu->idGenre;
								?>
								</td><td>
								<?php
									echo $jeu->dateParution;
								?>
								</td><td>
								<?php
									if ($notification != 'rien' && $jeu->identifiant == $idJeuNotif) {
										echo '<button class="btn btn-success btn-xs"><i class="fa fa-check"></i>' . $notification . '</button>';
									} 
								?>
								<button class="btn btn-primary btn-xs" type="submit" name="cmdAction" value="demanderModifierJeu" title="Modifier"><i class="fa fa-pencil"></i></button>
								<button class="btn btn-danger btn-xs" type="submit" name="cmdAction" value="supprimerJeu" title="Supprimer" onclick="return confirm('Voulez-vous vraiment supprimer ce jeu ?');"><i class="fa fa-trash-o "></i></button>
								</td>
							<?php
							} else {
							?>
								<input type="text" id="txtNomJeu" name="txtLibJeu" size="24" required minlength="4" maxlength="24" value="<?php echo $jeu->nom; ?>" />
								</td><td>
								<input type="number" id="txtPrixJeu" name="txtPrixJeu" min="0" max="500" step="0.01" value="<?php echo $jeu->prix; ?>" />
								</td><td>
								<input type="number" id="txtPegiJeu" name="txtPegiJeu" min="0" max="10" value="<?php echo $jeu->idPegi; ?>" />
								</td><td>
								<input type="number" id="txtPlatJeu" name="txtPLatJeu" min="0" max="20" value="<?php echo $jeu->idPlateforme; ?>" />
								</td><td>
								<input type="number" id="txtMarqueJeu" name="txtMarquesJeu" min="0" max="30" value="<?php echo $jeu->idMarque; ?>" />
								</td><td>
								<input type="number" id="txtGenreJeu" name="txtGenreJeu" min="0" max="20" value="<?php echo $jeu->idGenre; ?>" />
								</td><td>
								<input type="date" id="txtDateParution" name="txtDateParution" value="2023-01-27" min="1972-01-01" max="2049-07-01" value="<?php echo $jeu->dateParution; ?>" />
								</td><td>
								<button class="btn btn-primary btn-xs" type="submit" name="cmdAction" value="validerModifierJeu" title="Enregistrer"><i class="fa fa-save"></i></button>
								<button class="btn btn-info btn-xs" type="reset" title="Effacer la saisie"><i class="fa fa-eraser"></i></button>
								<button class="btn btn-warning btn-xs" type="submit" name="cmdAction" value="annulerModifierJeu" title="Annuler"><i class="fa fa-undo"></i></button>
								</td>
							<?php
							}
							?>
							</form>

						</tr>
					<?php
					}
					?>
				</tbody>
			</table>

		</div><!-- fin div panel-body-->
	</section><!-- fin section genres-->
</div><!--fin div col-sm-6-->