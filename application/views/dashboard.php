<?php include('templates/header.php'); ?>

<div class="container-fluid" style="font-weight:bold">
        <br>
            <div class="row">
                <div class="col-xs-3 col-md-3">
                <div class="card" style="width: 18rem;">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">
                            <a href="/statCommandes">Statistiques</a>
                        </li>
                        <li class="list-group-item">
                            <a href="#cmde" onclick="commande()">Passer une commande</a>
                        </li>
                    </ul>
                </div>
                </div>
                <div class="col-xs-6 col-md-5" >
                    <!-- section statistiques -->
                    <section id="stat" style="display:none;margin-left:auto;margin-right:auto">
                        <div class="card">
                        <div class="card-header text-center" style="background-color: #293042;color: #c7c8c8;">
                            Vos statistiques
                        </div>
                        <div class="container-fluid card-body">
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <h5 class="card-title" style="font-weight: bold;">Historique de vos commandes</h5>
                                    <!-- filtrer l'historique -->
                                    <!-- background-color:orange;color:black;padding:10px; -->
                                    <div class="container-fluid" style="">
                                        <h6 class="card-title" style="font-weight: bolder;">Filtrer vos statistiques</h6>
                                        <table class="filterDate table table-responsive">
                                            
                                            <thead>
                                                
                                                <tr>
                                                    <th style="height:2%">Debut</th>
                                                    <th data-breakpoints="xs sm" style="height:2%">Fin</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <input type="date" id="du">
                                                    </td>
                                                    <td>
                                                        <input type="date" id="au">
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <button class="btn btn-success btn-sm" style="margin-bottom: 2em;" onclick="filtrer()">Filtrer</button>
                                        <span class="" id="filterError" style="background-color:white;color:red;margin-left:10px;"></span>
                                    </div>
                                </div>
                            </div>
                            <div id="stat-loading">
                                <div id="waiting">
                                    <span class="text-info float-right">chargement encours</span>
                                    <img src="assets/img/arrows64.gif" class="rounded float-right" alt="">
                                </div>
                                <table class="mytable table" data-paging="true" data-paging-size="4">
                                    <thead>
                                        <tr>
                                            <th>Commande &numero;</th>
                                            <th data-breakpoints="xs" data-type="date" data-format-string="YYYY-MM-DD">Date commande</th>
                                            <th data-breakpoints="xs sm">Montant HT</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tb">
                                    </tbody>
                                </table>
                            </div>

                            <!-- new pagination -->
                            <div>
                                <?php if(isset($stat)){?>
                                <table class="table table-responsive">
                                    <thead>
                                        <tr>
                                            <th>Commande &numero;</th>
                                            <th>Date commande</th>
                                            <th>Montant HT</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($stat as $key => $value) {?>
                                            <tr>
                                                <td><?php echo $value['numCmde']; ?></td>
                                                <td><?php echo $value['dateCmde']; ?></td>
                                                <td><?php echo (float)$value['montantHT']; ?></td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                                <?php } ?>   
                                <?php if(isset($pagination)){
                                        echo $pagination;
                                    }
                                ?>
                            </div>
                        </div>
                        </div>
                    </section>

                    <!-- section commande -->
                    <section id="cmde">
                        <div class="card">
                        <div class="card-header" style="background-color: #293042;color: #c7c8c8;">
                            Preparer et envoyer une commande
                        </div>
                        <div class="card-body">
                            <a href="#aide" id="afficheAide" onclick="help()">Comment passer une commande?</a><br><br>
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <section id="aide" style="display:none;">
                                        <ul class="list-group ">
                                            <li class="list-group-item text-muted">
                                                <p>Selectionnez un article,précisez sa quantite puis cliquez sur le bouton <strong>Ajouter</strong>.
                                                Vos articles apparaissent dans un le tableau en-dessous et vous avez la possibilité de les retirer
                                                avec le bouton <strong>supprimer</strong>
                                                </p>
                                            </li>
                                            <li class="list-group-item text-muted">
                                                le montant total de la commande est affiche dans la zone de droite.
                                                
                                                il suffit de cliquer sur le bouton <strong>Valider</strong> pour envoyer votre commande.
                                            </li>
                                        </ul>
                                        <br>
                                        <button class="btn btn-dark btn-sm float-right" id="cacher" onclick="cacher()">Cacher</button>
                                    </section>
                                </div>
                            </div>

                            <!-- commande proprement dite -->
                            <section>
                                <div class="row card-body">
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                    <select data-placeholder="Selectionner un produit" class="chosen" style="min-width:200px;" id="prod"></select>
                                    </div>
                                </div>
                                
                                <input type="text" class="input-sm" id="entree" placeholder="Entrez la Quantite" style="border-radius:8px;">
                                <button class="myButton" id="target" onclick="save()">Ajouter</button>
                                <div class="alert alert-danger" id="error"></div>

                                <table class="purpleHorizon" id="tab" style="margin-top:3em;display: none;">
                                <thead>
                                <tr>
                                <th>ARTICLES</th>
                                <th>QUANTITE</th>
                                <th>PRIX UNITAIRE</th>
                                <th>SUPPRIMER</th>
                                </tr>
                                </thead>
                                <tfoot>
                                </tfoot>
                                <tbody id="cmdb">
                                </tbody>
                                </table>
                            </section>
                        </div>
                        </div>
                    </section>
                </div>

                <div class="col-xs-3 col-md-4">
                    <div id="infosup">
                        <div class="card">
                        <div class="card-header" style="background-color: #293042;color: #c7c8c8;">
                            Valorisation du panier
                        </div>
                        <div class="card-body">
                            <!-- <h5 class="card-title">Valorisation du panier</h5> -->
                            <div style="text-align: center;">
                                <p class="card-text" style="color: #3657cd;">Prix total HT: <span id="valeur">0</span> fcfa</p>
                            </div>
                            <div id="val" style="display:block;">

                            <!-- selection du client pour les commerciaux -->
                            <?php if($this->session->cat_Ref == 'COM'){ ?>
                                <div class="row card-body">
                                    <p class="text-info">Selectionner le client</p>
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <select data-placeholder="Selectionner un client" class="chosen" style="min-width:200px;" id="clientList">
                                            <option value="" selected="selected"></option>
                                        </select><span class="text-danger" style="padding: 1px;display: none;" id="cl_error"> vous devez selectionner un client
                                            pour l'envoi de votre commande</span>
                                    </div>
                                </div>
                                <!-- <div>
                                    <p>Selectionner le client</p>
                                    <div id="userinput">
                                        <select data-placeholder="Selectionner un client" class="chosen" style="min-width:180px;" id="clientList"></select>
                                    </div>
                                </div> -->
                            <?php } ?>

                            <button class="btn btn-success btn-sm float-right" style="marging-top:10px;" id="confirm" onclick="send()">Valider</button>
                            </div>
                            
                            <br>
                            <div id="pbar" style="margin-top:5px;display:none;">
                                <span class="text-info">Envoi encours...</span>
                                <img src="assets/img/loader32.gif" class="rounded float-right" alt="">
                            </div>
                            <div id="panierVide" style="display:none">
                            <p class="text-danger">Votre panier est vide</p>
                            </div>
                            <div style="margin-top:10px;">
                                <p id='sendResult' class="alert alert-success" style="display:none;">mail successfully sent</p>
                            </div>
                        </div>
                        </div>
                    </div>

                    <!-- sauvegarder la categorie de l'utilisateur connecte -->
                    
                    <?php if(isset($this->session->cat_Ref)){ ?>
                        <span id="user" name="<?php echo  $this->session->cat_Ref ?>" hidden></span>
                    <?php } ?>

                    <!-- <div class="container" id="userinput" style="display: none">
                    <form id="inputForm">
                        <input type="text" name="cname" class="form-control" placeholder="entrez le nom complet du client">
                        <input type="submit" name="submit" class="btn btn-sm">
                        <span class="text-danger" id="inputError" style="display: none;"> vous devez specifier le nom du client</span>
                    </form>
                  </div> -->

                    
                    <!-- details d'une commande -->
                    <div class="card" id="ligneCmde" style="display:none;">
                        <div class="card-body">
                            <h5 class="card-title text-success">Detail de la commande &numero; <span id="numero"></span> </h5>
                            <table class="tableligne table table-dark table-responsive" data-paging="true">
                                <thead>
                                    <tr>
                                        <th>Article</th>
                                        <th >Quantite</th>
                                    </tr>
                                </thead>
                                <tbody id="tbl">
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        <br>
    </div>  

    <!-- <script src="assets/js/commande.js"></script> -->
    <?php include('templates/footer.php'); ?>