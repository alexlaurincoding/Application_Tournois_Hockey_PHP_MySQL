
function ajax(url, callback, httpMethod = 'GET', data = null) {

    var xhr = new XMLHttpRequest();

    xhr.onreadystatechange = callback;
    try
    {
        xhr.open(httpMethod, url, true);
    } catch (e)
    {
        alert(e);
    }
    xhr.send(data);
}


function ajoutEquipe(PATH) {
    
    var nom = document.getElementById('nomEquipeAjout').value;
    
    if (estVide(nom)){
        alert("Veuillez entrer un nom d'équipe.");
        return;
    }
    
    //Parcourir les noms des autres equipes, et s'assurer qu'une equipe avec le meme nom n'existe pas deja
    var lesNoms = document.getElementsByClassName("nomsEquipes");
    for (let i=0; i <lesNoms.length; i++){
        if (lesNoms[i].innerHTML == nom){
            alert("Une équipe avec ce nom existe déjà.");
            return;
        }
    }
    
    //Completer l'URL avec le nom d'Equipe entre par l'utilisateur
    var urlAjouter = PATH + "/Equipe/Ajouter?nomEquipe=" + nom;
    //Ajax pour ajouter l'equipe
    ajax(urlAjouter, function (evt) {
        var xhr = evt.target;
        if (xhr.readyState == 4 && xhr.status == 200)  //réponse OK
        {
            var reponseJSON = xhr.responseText;
            var rep = JSON.parse(reponseJSON);
            if (rep.reponse != 'OK') {
                alert('Ajout non effectué');

            } else {
                afficherEquipes(PATH);
            }
        }
    })
}

function afficherEquipes(PATH) {

    var urlListeEquipes = PATH + "/Equipe/Afficher";
    var tbodyAffichageEquipes = document.getElementById('tbodyAffichageEquipes');


    //Aller chercher la liste des equipes (par Ajax) pour l'afficher
    ajax(urlListeEquipes, function (evt) {
        var xhr = evt.target;
        if (xhr.readyState == 4 && xhr.status == 200)  //réponse OK
        {
            var reponseJSON = xhr.responseText;
            var rep = JSON.parse(reponseJSON);

            //Vider la liste d'equipes affichee actuellement
            tbodyAffichageEquipes.innerHTML = "";
            
            //Si on a au moins une equipe
            if (rep.nombre != "aucun"){
                
            
                rep.forEach(function (equipe) {

                    //Afficher les equipes une apres l'autre
                    var argumentsSupprimer = '(' + equipe.id_equipe + ', "' + PATH + '");';
                    var argumentsModifier = '(' + equipe.id_equipe + ', "' + equipe.nom_equipe + '", "' + PATH + '");';
                    tbodyAffichageEquipes.innerHTML += "<tr>\n\
                                <td class='nomsEquipes'>" + equipe.nom_equipe + "</td>\n\
                                <td></td>\n\
                                <td><input onclick='supprimerEquipe" + argumentsSupprimer + "' type='image'  src='" + PATH + "/Vues/Images/trash-icon.png' style='width: 20px;'>\n\
                                &nbsp&nbsp<input onclick='remplirModifEquipe" + argumentsModifier + "' type='image'  src='" + PATH + "/Vues/Images/edit-icon.jpg' style='width: 18px;'></td>\n\
                                </tr>";
                });

                //Ajouter la derniere section, pour ajouter des equipes.
                var argumentAjouter = '("' + PATH + '");';
                tbodyAffichageEquipes.innerHTML += "<tr><td><input type='text' name='nomEquipe' id='nomEquipeAjout' class='form-control' required></td>\n\
                            <td><button id='btnAjouterEquipe' class='btn btn-secondary' type='button'  onclick='ajoutEquipe" + argumentAjouter + "'>Ajouter</button></td>\n\
                            <td><button style='display:none;' id='btnAnnulerModifEquipe' class='btn btn-secondary' type='button'  onclick='annulerModifEquipe" + argumentAjouter + "'>Annuler</button></td></tr></tbody>";

            }
            //Si aucune equipe
            else{
                tbodyAffichageEquipes.innerHTML += "<tr>&nbsp&nbsp Aucune équipe</tr>";
                 //Ajouter la derniere section, pour ajouter des equipes.
                var argumentAjouter = '("' + PATH + '");';
                tbodyAffichageEquipes.innerHTML += "<tr><td><input type='text' name='nomEquipe' id='nomEquipeAjout' class='form-control' required></td>\n\
                            <td><button id='btnAjouterEquipe' class='btn btn-secondary' type='button'  onclick='ajoutEquipe" + argumentAjouter + "'>Ajouter</button></td>\n\
                            <td><button style='display:none;' id='btnAnnulerModifEquipe' class='btn btn-secondary' type='button'  onclick='annulerModifEquipe" + argumentAjouter + "'>Annuler</button></td></tr></tbody>";
                
            }
        }
    })
}

function supprimerEquipe(idEquipe, PATH) {
    var urlSupprimerEquipe = PATH + "/Equipe/Supprimer?idEquipe=" + idEquipe;
    
    var decision = confirm("En effaçant l'équipe, vous modifierez les parties et tournois dans lesquelles elle était impliquée.");
    
    if (decision == false){
        return;
    }

    ajax(urlSupprimerEquipe, function (evt) {
        var xhr = evt.target;
        if (xhr.readyState == 4 && xhr.status == 200)  //réponse OK
        {
            var reponseJSON = xhr.responseText;
            var rep = JSON.parse(reponseJSON);
            if (rep.reponse != 'OK') {
                alert('Suprresion non effectuée');


            } else {
                afficherEquipes(PATH);

            }
        }
    })
}

function remplirModifEquipe(idEquipe, nomEquipe, PATH) {
    var btnAjouter = document.getElementById("btnAjouterEquipe");
    var inputTexte = document.getElementById("nomEquipeAjout");
    var btnAnnuler = document.getElementById("btnAnnulerModifEquipe");
    
    inputTexte.value = nomEquipe;
    btnAjouter.innerHTML = "Modifier";
    
    btnAnnuler.style.display = "block";
    
    btnAjouter.setAttribute("class", "btn btn-warning");
    btnAjouter.setAttribute("onclick", "modifierEquipe(" + idEquipe+ ", '" + nomEquipe + "', '" + PATH + "')");
    
    //Methode pour amener le scroller au bouton
    btnAjouter.scrollIntoView(false);
    
}

function modifierEquipe(idEquipe, nomAChanger, PATH) {
    var nomEquipe = document.getElementById("nomEquipeAjout").value;
        
    if (estVide(nomEquipe)){
        alert("Veuillez entrer un nom d'équipe.");
        return;
    }
    
    //Parcourir les noms des autres equipes, et s'assurer qu'une equipe avec le meme nom n'existe pas deja
    var lesNoms = document.getElementsByClassName("nomsEquipes");
    for (let i=0; i <lesNoms.length; i++){
        if (lesNoms[i].innerHTML == nomEquipe && lesNoms[i].innerHTML != nomAChanger){
            alert("Une équipe avec ce nom existe déjà.");
            return;
        }
    }
    
    var top = document.getElementById("btnHeading1");

    var urlModifierEquipe = PATH + "/Equipe/Modifier?idEquipe=" + idEquipe + "&nomEquipe=" + nomEquipe;

    ajax(urlModifierEquipe, function (evt) {
        var xhr = evt.target;
        if (xhr.readyState == 4 && xhr.status == 200)  //réponse OK
        {
            var reponseJSON = xhr.responseText;
            var rep = JSON.parse(reponseJSON);
            if (rep.reponse != 'OK') {
                alert('Modification non effectuée');


            } else {
                afficherEquipes(PATH);
                //Apres affichage, nous ramener en haut
                 top.scrollIntoView(true);

            }
        }
    })
}

function annulerModifEquipe(PATH){
    var btnAnnuler = document.getElementById("btnAnnulerModifEquipe");

    btnAnnuler.style.display = "none";
    afficherEquipes(PATH);

    
}
function ajouterTournoi(PATH) {
    //Completer l'URL avec le nom d'Equipe entre par l'utilisateur
    var nom = document.getElementById('nomTournoiAjout').value;
    var min = document.getElementById('minTournoi').value;
    var max = document.getElementById('maxTournoi').value;
    var debut = document.getElementById('dateDebutTournoi').value;
    var fin = document.getElementById('dateFinTournoi').value;
    var limite = document.getElementById('dateLimiteInscription').value
    
        
    if (estVide(nom) || estVide(min) || estVide(max) || estVide(debut) || estVide(fin) || estVide(limite)){
        alert("Veuillez saisir tous les champs.");
        return;
    }
    
    if (isNaN(min) || isNaN(max)){
        alert("Veuillez entrer une valeur numérique pour le nombre minimum et maximum d'équipes.");
        return;
    }
    
    if (parseInt(min) < 2){
       alert("Il faut un minimum de 2 équipes.");
       return;
    }
    
    if (parseInt(max) < parseInt(min)){
        alert("Le maximum d'équipes ne peut être plus petit que le minimum.");
        return;
    }
    
    var dateDebut = new Date(debut);
    var dateFin = new Date(fin);
    var dateLimite = new Date(limite);
        
    if (dateDebut > dateFin){
        alert("La fin du tournoi ne peut être avant le début.");
        return;
    }
    
    if (dateLimite > dateDebut){
        alert("La date limite d'inscription ne peut être après le début du tournoi");
        return;
    }
    
    if (parseInt(dureeNecessaireTournoi(max)) > parseInt(dateDiff(dateDebut, dateFin))){
        alert("Le tournoi proposé durerait seulement " + dateDiff(dateDebut, dateFin) + " jours, ce qui est insuffisant. Pour un tournoi avec " + max +  " équipes, il faut un minimum de " + dureeNecessaireTournoi(max) + " jours pour que chaque équipe joue contre chaque autre équipe 2 fois, sans congé. Veuillez changer les dates ou le nombre maximum d'équipes.");
        return;
    }
       
    

    var urlAjouter = PATH + "/Tournoi/Ajouter?nom=" + nom + "&min=" + min + "&max=" + max + "&debut=" + debut + "&fin=" + fin + "&limite=" + limite;
    //Ajax pour ajouter l'equipe
    ajax(urlAjouter, function (evt) {
        var xhr = evt.target;
        if (xhr.readyState == 4 && xhr.status == 200)  //réponse OK
        {
            var reponseJSON = xhr.responseText;
            var rep = JSON.parse(reponseJSON);
            if (rep.reponse != 'OK') {
                alert('Ajout non effectué');

            } else {
                afficherTournois(PATH);

            }
        }
    })
}

function afficherTournois(PATH) {
    
    reinitialiserContenu(2, PATH, false);

    var urlListeTournois = PATH + "/Tournoi/Afficher";
    var tableAffichageTournois = document.getElementById('tableAffichageTournois');

    //Aller chercher la liste des equipes (par Ajax) pour l'afficher
    ajax(urlListeTournois, function (evt) {
        var xhr = evt.target;
        if (xhr.readyState == 4 && xhr.status == 200)  //réponse OK
        {
            var reponseJSON = xhr.responseText;
            var rep = JSON.parse(reponseJSON);
            
            //Vider la liste de tournois affichee actuellement
            tableAffichageTournois.innerHTML = "";
            
            //Si on a au moins un tournoi
            if (rep.nombre != "aucun"){
            
                rep.forEach(function (tournoi) {

                    //Afficher les equipes une apres l'autre
                    var argumentsSupprimer = '(' + tournoi.id_tournoi + ', "' + PATH + '");';
                    var argumentsModifier = '(' + tournoi.id_tournoi + ', "' + tournoi.nom_tournoi + '",' + tournoi.min + ',' + tournoi.max + ', "' + tournoi.debut + '", "' + tournoi.fin + '", "' + tournoi.inscription + '", "' + PATH + '");';
                    tableAffichageTournois.innerHTML += "<tr>\n\
                                <td>" + tournoi.nom_tournoi + "</td>\n\
                                <td></td>\n\
                                <td><input onclick='supprimerTournoi" + argumentsSupprimer + "' type='image'  src='" + PATH + "/Vues/Images/trash-icon.png' style='width: 20px;'>\n\
                                &nbsp&nbsp<input onclick='remplirModifTournoi" + argumentsModifier + "' type='image'  src='" + PATH + "/Vues/Images/edit-icon.jpg' style='width: 18px;'></td>\n\
                                </tr>";
                });
                tableAffichageTournois.innerHTML += "<br><br>";
            }
            
            //Si aucun tournoi
            else{
                tableAffichageTournois.innerHTML += "<tr>&nbsp&nbsp Aucun tournoi</tr><br><br><br>";
                
            }

        }
    })
}

function supprimerTournoi(idTournoi, PATH) {
    var urlSupprimerTournoi = PATH + "/Tournoi/Supprimer?idTournoi=" + idTournoi;


    var decision = confirm("En effaçant le tournoi, vous effacerai toutes les parties qui s'y trouvent.");
    
    if (decision == false){
        return;
    }
    
    //Aller effacer l'equipe par Ajax
    ajax(urlSupprimerTournoi, function (evt) {
        var xhr = evt.target;
        if (xhr.readyState == 4 && xhr.status == 200)  //réponse OK
        {
            var reponseJSON = xhr.responseText;
            var rep = JSON.parse(reponseJSON);
            if (rep.reponse != 'OK') {
                alert('Suprresion non effectuée');


            } else {
                afficherTournois(PATH);

            }
        }
    })
}

function remplirModifTournoi(idTournoi, nomTournoi, min, max, debut, fin, inscription, PATH){
    var btnAjouter = document.getElementById("btnAjouterTournoi");
    var titre = document.getElementById("titreTournoi");
    var inputNom = document.getElementById("nomTournoiAjout");
    var inputMin = document.getElementById('minTournoi');
    var inputMax = document.getElementById('maxTournoi');
    var inputDebut = document.getElementById('dateDebutTournoi');
    var inputFin = document.getElementById('dateFinTournoi');
    var inputLimite = document.getElementById('dateLimiteInscription');
    var btnAnnuler = document.getElementById("btnAnnulerModifTournoi");
   
    inputNom.value = nomTournoi;
    inputMin.value = min;
    inputMax.value = max;
    inputDebut.value = debut;
    inputFin.value = fin;
    inputLimite.value = inscription;
    btnAjouter.innerHTML = "Modifier";
    titre.innerHTML = "MODIFIER UN TOURNOI";
        
    btnAjouter.setAttribute("class", "btn btn-warning");
    btnAjouter.setAttribute("onclick", "modifierTournoi(" + idTournoi+ ", '" + PATH + "')");
    
    //Methode pour amener le scroller au bouton
    btnAjouter.scrollIntoView(false);
    
    btnAnnuler.style.display = "inline";

    
}

function modifierTournoi(idTournoi, PATH){
    var btnAnnuler = document.getElementById("btnAnnulerModifTournoi");
    var top = document.getElementById("btnHeading2");
    var nom = document.getElementById("nomTournoiAjout").value;
    var min = document.getElementById('minTournoi').value;
    var max = document.getElementById('maxTournoi').value;
    var debut = document.getElementById('dateDebutTournoi').value;
    var fin = document.getElementById('dateFinTournoi').value;
    var limite = document.getElementById('dateLimiteInscription').value;    
    var urlModifierTournoi = PATH + "/Tournoi/Modifier?idTournoi=" + idTournoi + "&nom=" + nom + "&min=" + min + "&max=" + max + "&debut=" + debut + "&fin=" + fin + "&limite=" + limite;

    if (estVide(nom) || estVide(min) || estVide(max) || estVide(debut) || estVide(fin) || estVide(limite)){
        alert("Veuillez saisir tous les champs.");
        return;
    }
    
    if (isNaN(min) || isNaN(max)){
        alert("Veuillez entrer une valeur numérique pour le nombre minimum et maximum d'équipes.");
        return;
    }
    
    if (parseInt(min) < 2){
       alert("Il faut un minimum de 2 équipes.");
       return;
    }
    
    if (parseInt(max) < parseInt(min)){
        alert("Le maximum d'équipes ne peut être plus petit que le minimum.");
        return;
    }
    
    var dateDebut = new Date(debut);
    var dateFin = new Date(fin);
    var dateLimite = new Date(limite);
    
        
    if (dateDebut > dateFin){
        alert("La fin du tournoi ne peut être avant le début.");
        return;
    }
    
    if (dateLimite > dateDebut){
        alert("La date limite d'inscription ne peut être après le début du tournoi");
        return;
    }
    
    if (parseInt(dureeNecessaireTournoi(max)) > parseInt(dateDiff(dateDebut, dateFin))){
        alert("Le tournoi proposé durerait seulement " + dateDiff(dateDebut, dateFin) + " jours, ce qui est insuffisant. Pour un tournoi avec " + max +  " équipes, il faut un minimum de " + dureeNecessaireTournoi(max) + " jours pour que chaque équipe joue contre chaque autre équipe 2 fois, sans congé. Veuillez changer les dates ou le nombre maximum d'équipes.");
        return;
    }
       
    
    
    ajax(urlModifierTournoi, function (evt) {
        var xhr = evt.target;
        if (xhr.readyState == 4 && xhr.status == 200)  //réponse OK
        {
            var reponseJSON = xhr.responseText;
            var rep = JSON.parse(reponseJSON);
            if (rep.reponse != 'OK') {
                alert('Modification non effectuée');


            } else {
                btnAnnuler.style.display = "none";
                afficherTournois(PATH);

                //Apres affichage, nous ramener en haut
                 top.scrollIntoView(true);

            }
        }
    })
    
}


function annulerModifTournoi(PATH){
    var btnAnnuler = document.getElementById("btnAnnulerModifTournoi");
    btnAnnuler.style.display = "none";
    afficherTournois(PATH);
    
}



function afficherParticipants(PATH, numSection) {
    var id = document.getElementById("selectTournoi"+numSection).value;

    var urlListeParticipants = PATH + "/Participant/Afficher?idTournoi=" + id;
    var urlListeNonParticipants = PATH + "/Participant/AfficherAutres?idTournoi=" + id;
    var urlListeEquipes = PATH + "/Equipe/Afficher";
    var tableParticipants = document.getElementById("afficherEquipes");
    var tbodyParticipants = document.getElementById("tbodyTableAfficherEquipes");
    
    //Commencer par tout effacer, pour ensuite reafficher
    tableParticipants.style.display = "none";
    //tableParticipants.getElementsByTagName("tbody")[0].innerHTML = tableParticipants.rows[0].innerHTML;
    
    tbodyParticipants.innerHTML = tableParticipants.rows[0].innerHTML;
    var compteurLigne = 1;
   
   //Si aucun tournoi selectionne, ne pas poursuivre
   if (id == "option1"){
       return;
   }
   
   //Si aucune equipe dans la ligue, l'afficher et quitter
    ajax(urlListeEquipes, function (evt) {
        var xhr = evt.target;
        if (xhr.readyState == 4 && xhr.status == 200)  //réponse OK
        {
            var reponseJSON = xhr.responseText;
            var rep = JSON.parse(reponseJSON);

            //Vider la liste d'equipes affichee actuellement
            tbodyAffichageEquipes.innerHTML = "";
            
            //Si on a au moins une equipe
            if (rep.nombre == "aucun"){
                alert("Il n'y a présentement aucune équipe dans la ligue");
                die();
            }
        }
    });
   
   
    //Commencer par afficher tous les participants (pour pouvoir les enlever)
    ajax(urlListeParticipants, function (evt) {
        var xhr = evt.target;
        if (xhr.readyState == 4 && xhr.status == 200)  //réponse OK
        {
            var reponseJSON = xhr.responseText;
            var rep = JSON.parse(reponseJSON);
            if (rep.nombre != "aucun") {
                //Pour chacun des participant
                rep.forEach(function (participant) {
                    //Creer une nouvelle ligne dans la table pour y inserer ce participant
                    var row = tableParticipants.insertRow(compteurLigne++);
                    var nomEquipe = row.insertCell(0);
                    nomEquipe.innerHTML = participant.nom_equipe;
                    var sectionImage = row.insertCell(1);
                    row.insertCell(2);
                    
                    var iconeEffacer = document.createElement("img");
                    iconeEffacer.src = PATH + "/Vues/Images/remove-icon.png";
                    iconeEffacer.style.width = "22px";
                    iconeEffacer.style.cursor = "pointer";
                    iconeEffacer.setAttribute("onclick", "retirerParticipant(" + participant.id_tournoi  + ", " + participant.id_equipe + ", '" + PATH + "', " + numSection + ")");
                    sectionImage.appendChild(iconeEffacer);
                });
            }
        }
    })


    //Puis, afficher les equipes qui ne sont pas participantes (pour pouvoir les ajouter)
    ajax(urlListeNonParticipants, function (evt) {

        var xhr = evt.target;
        if (xhr.readyState == 4 && xhr.status == 200)  //réponse OK
        {
            var reponseJSON = xhr.responseText;
            var rep = JSON.parse(reponseJSON);
            if (rep.nombre != "aucun") {
                //Pour chacun des participant
                rep.forEach(function (equipe) {

                    //Creer une nouvelle ligne dans la table pour y inserer ce participant
                    var row = tableParticipants.insertRow(compteurLigne++);
                    var nomEquipe = row.insertCell(0);
                    nomEquipe.innerHTML = equipe.nom_equipe;
                    nomEquipe.style.color = "grey";
                    var sectionImage = row.insertCell(1);
                    row.insertCell(2);
                    
                    var iconeEffacer = document.createElement("img");
                    iconeEffacer.src = PATH + "/Vues/Images/add-icon.png";
                    iconeEffacer.style.width = "22px";
                    iconeEffacer.style.cursor = "pointer";
                    iconeEffacer.setAttribute("onclick", "ajouterParticipant(" + equipe.id_tournoi  + ", " + equipe.id_equipe + ", '" + PATH + "', " + numSection + ")");
                    sectionImage.appendChild(iconeEffacer);
                });
            }
        }
    })
    
    //Terminer en affichant le tout
    var derniereLigne = tableParticipants.rows.length-1;
    tableParticipants.rows[derniereLigne].style.display = "none";
    tableParticipants.style.display = "block";
    
    
}

function ajouterParticipant(idTournoi, idEquipe, PATH, numSection){
     
    var urlAjouterParticipant = PATH + "/Participant/Ajouter?idTournoi=" + idTournoi +"&idEquipe="+idEquipe;

    
     ajax(urlAjouterParticipant, function (evt) {

        var xhr = evt.target;
        if (xhr.readyState == 4 && xhr.status == 200)  //réponse OK
        {
            var reponseJSON = xhr.responseText;
            var rep = JSON.parse(reponseJSON);
            if (rep.reponse != 'OK') {
                alert('Ajout non effectué');
            } else {
                afficherParticipants(PATH, numSection);
            }
           
        }
    })    
}


function retirerParticipant(idTournoi, idEquipe, PATH, numSection){
     var urlRetirerParticipant = PATH + "/Participant/Supprimer?idTournoi=" + idTournoi +"&idEquipe="+idEquipe;

     ajax(urlRetirerParticipant, function (evt) {

        var xhr = evt.target;
        if (xhr.readyState == 4 && xhr.status == 200)  //réponse OK
        {
            var reponseJSON = xhr.responseText;
            var rep = JSON.parse(reponseJSON);
            if (rep.reponse != 'OK') {
                alert('Retrait non effectué');
            } else {
                afficherParticipants(PATH, numSection);
            }     
        }
    })
}

function gererCalendrier(PATH, numSection){
    
    var idTournoi = document.getElementById("selectTournoi"+numSection).value;
    var urlObtenirCalendrier = PATH + "/Calendrier/ObtenirCalendrier?idTournoi=" + idTournoi;
    var urlChercherTournoi = PATH + "/Tournoi/ChercherTournoi?idTournoi=" + idTournoi;
    var sectionCreerCalendrier = document.getElementById("formulaireCreerCalendrier"); 
    var sectionParties = document.getElementById("affichageParties"); 
    var inputIdTournoiCalendrier = document.getElementById("inputIdTournoiCalendrier"); 
    var inputIdTournoiCreerParties = document.getElementById("inputIdTournoiCreerParties"); 

    
    reinitialiserContenu(numSection, PATH, false);
    
    //Si aucun tournoi selectionne, ne pas poursuivre
    if (idTournoi == "option1"){
        return;
    }

    ajax(urlObtenirCalendrier, function (evt) {

        var xhr = evt.target;
        if (xhr.readyState == 4 && xhr.status == 200)  //réponse OK
        {
            var reponseJSON = xhr.responseText;
            var rep = JSON.parse(reponseJSON);
            
            //S'il y deja un calendrier
            if (rep.reponse == 'OK') {
                
                //Cacher la section CreerCalendrier et afficher la section Parties - apres avoir inserer l'id du Tournoi comme value dans le "hidden input"
                inputIdTournoiCreerParties.value = idTournoi;
                sectionParties.style.display = "block";
                sectionCreerCalendrier.style.display = "none";
                
                //Afficher les parties
                afficherParties(PATH, numSection);
                var sectionModifier = document.getElementById("formModifierCalendrier");
                sectionModifier.style.display = "none";
                
                //Restreindre dates dans le datepicker en fonction des dates du calendrier
               //  var today = new Date().toISOString().split('T')[0];
                 //var maxDate = "2020-06-01";
                 document.getElementById("datePartieAjout").setAttribute('min', rep.debut);
                 document.getElementById("datePartieAjout").setAttribute('max', rep.fin);


                
            //S'il n'y a pas deja de calendrier
            } else {
                                
                //Cacher la section Parties et afficher la section CreerCalendrier - apres avoir inserer l'id du Tournoi comme value dans le "hidden input"
                inputIdTournoiCalendrier.value = idTournoi;
                sectionParties.style.display = "none";
                sectionCreerCalendrier.style.display = "block";
                
                //Aller chercher les details du tournoi pour restreindre les dates de creation du calendrier
                 ajax(urlChercherTournoi, function (evt) {

                    var xhr = evt.target;
                    if (xhr.readyState == 4 && xhr.status == 200)  //réponse OK
                    {
                        var reponseJSON = xhr.responseText;
                        var rep = JSON.parse(reponseJSON);

                        if (rep.reponse == 'OK') {
                            
                            document.getElementById("debutCalendrier").setAttribute('min', rep.debut);
                            document.getElementById("debutCalendrier").setAttribute('max', rep.fin);
                            document.getElementById("finCalendrier").setAttribute('min', rep.debut);
                            document.getElementById("finCalendrier").setAttribute('max', rep.fin);
                            
                            document.getElementById("debutModifCalendrier").setAttribute('min', rep.debut);
                            document.getElementById("debutModifCalendrier").setAttribute('max', rep.fin);
                            document.getElementById("finModifCalendrier").setAttribute('min', rep.debut);
                            document.getElementById("finModifCalendrier").setAttribute('max', rep.fin);
                            
                            alert("Les choix de dates disponibles pour la création du calendrier sont restreintes en fonction des dates choisies précédemment lors de la création du tournoi. Pour avoir accès à d'autres dates, veuillez retourner modifier les détails du tournoi.");
                        }
                    }
                });
            }
        }
    })    
}



function creerCalendrier(PATH, numSection){
    
    var idTournoi = document.getElementById("selectTournoi"+numSection).value;
    var nombre = document.getElementById("nbrEquipes").value;
    var debut = document.getElementById("debutCalendrier").value;
    var fin = document.getElementById("finCalendrier").value;   
    
    if (estVide(nombre) || estVide(debut) || estVide(fin)){
        alert("Veuillez remplir tous les champs");
        return;
    }
    
    var dateDebut = new Date(debut);
    var dateFin = new Date(fin);
            
    if (parseInt(dureeNecessaireTournoi(parseInt(nombre))) > parseInt(dateDiff(dateDebut, dateFin))){
        alert("Le calendrier proposé durerait seulement " + dateDiff(dateDebut, dateFin) + " jours, ce qui est insuffisant. Pour un calendrier avec " + nombre +  " équipes, il faut un minimum de " + dureeNecessaireTournoi(nombre) + " jours pour que chaque équipe joue contre chaque autre équipe 2 fois, sans congé. Veuillez changer les dates ou le nombre d'équipes.");
        return;
    }


    var urlCreerCalendrier = PATH + "/Calendrier/CreerCalendrier?idTournoi=" + idTournoi + "&nombre="+nombre + "&debut= " + debut + "&fin=" + fin;

    
     ajax(urlCreerCalendrier, function (evt) {

        var xhr = evt.target;
        if (xhr.readyState == 4 && xhr.status == 200)  //réponse OK
        {
            var reponseJSON = xhr.responseText;
            var rep = JSON.parse(reponseJSON);
            
            if (rep.reponse != 'OK') {
                
                if (rep.erreur == "nombre"){
                    alert("Le nombre d'équipes du calendrier doit se situer dans la fourchette fixée précédemment pour ce tournoi, soit entre " + rep.min + " et " + rep.max + " équipes. Changez le nombre d'équipe, ou modifier les détails du tournoi.");
                }
                else if (rep.erreur == "debut" || rep.erreur == "fin"){
                    alert("Les dates du calendrier doivent se situer entre celles précédemment fixées pour ce tournoi, soit entre le " + rep.debut + " et le " + rep.fin + ". Les dates entrees sont " + debut + "et " + fin + ". Changer les dates du calendrier ou celles du tournoi.");
                    
                }
            } else {
                 gererCalendrier(PATH, numSection);
            }
        }
    })
}

function remplirModifCalendrier(PATH, numSection){
    
    var sectionModif = document.getElementById("formModifierCalendrier");
    var nbrEquipesModifCalendrier = document.getElementById("nbrEquipesModifCalendrier");
    var debutModifCalendrier = document.getElementById("debutModifCalendrier");
    var finModifCalendrier = document.getElementById("finModifCalendrier");
    var idTournoi = document.getElementById("selectTournoi"+numSection).value;
    var btnAnnuler = document.getElementById("btnAnnulerModifCalendrier");
    var btnModif = document.getElementById("btnModifCal");

     
    var urlInfosCalendrier = PATH + "/Calendrier/ObtenirCalendrier?idTournoi=" + idTournoi;
    
    ajax(urlInfosCalendrier, function (evt) {

        var xhr = evt.target;
        if (xhr.readyState == 4 && xhr.status == 200)  //réponse OK
        {
            var reponseJSON = xhr.responseText;
            var rep = JSON.parse(reponseJSON);
            if (rep.reponse != 'OK') {
                alert('Ajout non effectué');
            } else {
                
                sectionModif.style.display = "block";
                nbrEquipesModifCalendrier.value = rep.nombre_equipes;
                debutModifCalendrier.value = rep.debut;
                finModifCalendrier.value = rep.fin;
                btnAnnuler.style.display = "inline";
                btnModif.innerHTML = "Modifier";
                btnModif.setAttribute("onclick", "modifierCalendrier(" + rep.id_calendrier +", '" + PATH + "', " + numSection + ")");
            }
        }
    })    
}


function modifierCalendrier(idCalendrier, PATH, numSection){
   
    var nombre = document.getElementById("nbrEquipesModifCalendrier").value;
    var debut = document.getElementById("debutModifCalendrier").value;
    var fin = document.getElementById("finModifCalendrier").value; 
   
    var urlModifierCalendrier = PATH + "/Calendrier/ModifierCalendrier?idCalendrier=" + idCalendrier + "&nombre=" + nombre + "&debut=" + debut + "&fin=" + fin;

    if (estVide(nombre) || estVide(debut) || estVide(fin)){
        alert("Veuillez remplir tous les champs");
        return;
    }
    
    var dateDebut = new Date(debut);
    var dateFin = new Date(fin);
            
    if (parseInt(dureeNecessaireTournoi(parseInt(nombre))) > parseInt(dateDiff(dateDebut, dateFin))){
        alert("Le calendrier proposé durerait seulement " + dateDiff(dateDebut, dateFin) + " jours, ce qui est insuffisant. Pour un calendrier avec " + nombre +  " équipes, il faut un minimum de " + dureeNecessaireTournoi(nombre) + " jours pour que chaque équipe joue contre chaque autre équipe 2 fois, sans congé. Veuillez changer les dates ou le nombre d'équipes.");
        return;
    }
    
    ajax(urlModifierCalendrier, function (evt) {
        var xhr = evt.target;
        if (xhr.readyState == 4 && xhr.status == 200)  //réponse OK
        {
            var reponseJSON = xhr.responseText;
            var rep = JSON.parse(reponseJSON);
            
            if (rep.reponse != 'OK') {
                alert('Modification non effectuée');


            } else {
                
                gererCalendrier(PATH, numSection);
            }
        }
    })
}


function creerPartie(PATH, numSection){
    
    var idTournoi = document.getElementById("selectTournoi"+numSection).value;
    var idEquipeA = document.getElementById("selectEquipesA").value;
    var idEquipeB = document.getElementById("selectEquipesB").value;
    var jour = document.getElementById("datePartieAjout").value;
    var heure = document.getElementById("heurePartieAjout").value;
    var idPatinoire = document.getElementById("selectPatinoire").value;

    var urlAjouterPartie = PATH + "/Calendrier/CreerPartie?idTournoi=" + idTournoi + "&idEquipeA="+idEquipeA + "&idEquipeB= " + idEquipeB + "&jour=" + jour + "&heure=" +heure + "&idPatinoire=" + idPatinoire;


    if (idEquipeA == "option1EquipeA" || idEquipeB == "option1EquipeB" || jour == "" || heure == "" || idPatinoire == "option1Patinoire"){
        alert("Veuillez remplir tous les champs");
        return;
    }
    
    if (idEquipeA == idEquipeB){
        alert("Vous avez choisi la même équipe deux fois.");
        return;
    }
     
    if (jour )
     ajax(urlAjouterPartie, function (evt) {

        var xhr = evt.target;
        if (xhr.readyState == 4 && xhr.status == 200)  //réponse OK
        {
            var reponseJSON = xhr.responseText;
            var rep = JSON.parse(reponseJSON);
            if (rep.reponse != 'OK') {
                alert('Ajout non effectué');
            } else {
                
                //Reinitialiser les champs du formulaire
                document.getElementById("selectEquipesA").value = "option1EquipeA";
                document.getElementById("selectEquipesB").value = "option1EquipeB";
                document.getElementById("datePartieAjout").value = "";
                document.getElementById("heurePartieAjout").value = "";
                document.getElementById("selectPatinoire").value = "option1Patinoire";

               
                //Modifier l'affichage des parties
                afficherParties(PATH, numSection);
                
                //Remonter en haut
                 var titre = document.getElementById("titreAjoutPartie");
                 titre.scrollIntoView(false);
            }
        }
    })
}

function afficherParties(PATH, numSection){

    var idTournoi = document.getElementById("selectTournoi"+numSection).value;
    var urlListeParties = PATH + "/Calendrier/AfficherParties?idTournoi="+idTournoi;
    var tableParties = document.getElementById("tableAfficherParties");
    var tbodyParties = document.getElementById("tbodyTableAfficherParties");
    var compteurLigne = 1;
    tbodyParties.innerHTML = tableParties.rows[0].innerHTML;
        
    //Remplir la liste d'options d'equipes (pour les Select dans la section pour creer une partie)
    afficherOptionsParticipants(PATH, numSection);
    
     //Ensuite, vider les parties qui s'y trouvent deja    
    tableParties.style.display = "none";
  

    ajax(urlListeParties, function (evt) {
        var xhr = evt.target;
        if (xhr.readyState == 4 && xhr.status == 200)  //réponse OK
        {
            var reponseJSON = xhr.responseText;
            var rep = JSON.parse(reponseJSON);
            
            if (rep.nombre == "aucun") {
                var row = tableParties.insertRow(1);
                //Jour
                row.innerHTML = "Aucune partie."
                                    
            }
            else{
                 
                //Pour chacun des participant
                rep.forEach(function (partie) {

                    //Creer une nouvelle ligne dans la table pour y inserer cette partie avec toutes ses infos
                    //jour, heure, nomA, nomB, nomPatinoire
                    var row = tableParties.insertRow(compteurLigne++);
                    //Jour
                    var jour = row.insertCell(0);
                    jour.innerHTML = partie.jour;
                    
                    
                    //Heure
                    var heure = row.insertCell(1);
                    heure.innerHTML = partie.heure;
                    
                    //Equipe A
                    var equipeA = row.insertCell(2);
                    equipeA.innerHTML = partie.nom_equipeA;
                    
                    //Equipe B
                    var equipeB = row.insertCell(3);
                    equipeB.innerHTML = partie.nom_equipeB;
                    
                    //Patinoire
                    var patinoire = row.insertCell(4);
                    patinoire.innerHTML = partie.nom_patinoire + ", " + partie.ville;
                    

                    //Image effacer
                    var sectionImage = row.insertCell(5);
                    var iconeEffacer = document.createElement("img");
                    iconeEffacer.src = PATH + "/Vues/Images/trash-icon.png";
                    iconeEffacer.style.width = "22px";
                    iconeEffacer.style.cursor = "pointer";
                    iconeEffacer.setAttribute("onclick", "supprimerPartie(" + partie.id_partie  + ",'" + PATH + "', "+numSection+")");
                    sectionImage.appendChild(iconeEffacer);
                    
                    //Image modifier
                    var sectionModif = row.insertCell(6);
                    var iconeModif = document.createElement("img");
                    iconeModif.src = PATH + "/Vues/Images/edit-icon.jpg";
                    iconeModif.style.width = "18px";
                    iconeModif.style.cursor = "pointer";
                    iconeModif.setAttribute("onclick", "remplirModifPartie(" + partie.id_partie + "," + partie.id_equipeA + "," + partie.id_equipeB + ", '" + partie.jour + "', '" + partie.heure + "', " + partie.id_patinoire + ", '" + PATH + "', "+numSection+ ")");
                    sectionModif.appendChild(iconeModif);
                });
            }
        }
    }) 
    
    //Afficher tout
    var derniereLigne = tableParties.rows.length-1;
    tableParties.rows[derniereLigne].style.display = "none";
    tableParties.style.display = "block";
}

function remplirModifPartie(idPartie, equipeA, equipeB, jour, heure, patinoire, PATH, numSection){
 
    var selectEquipesA = document.getElementById("selectEquipesA");
    var selectEquipesB = document.getElementById("selectEquipesB");
    var datePartieAjout = document.getElementById("datePartieAjout");
    var heurePartieAjout = document.getElementById("heurePartieAjout");
    var selectPatinoire = document.getElementById("selectPatinoire");
    var bouton = document.getElementById("btnCreerPartie");
    var btnAnnuler = document.getElementById("btnAnnulerModifPartie");
    var titre = document.getElementById("titreAjoutPartie");
    
    selectEquipesA.value = equipeA;
    selectEquipesB.value = equipeB;
    datePartieAjout.value = jour;
    heurePartieAjout.value = heure;
    selectPatinoire.value = patinoire;
    
    bouton.setAttribute("class", "btn btn-warning");
    bouton.setAttribute("onclick", "modifierPartie(" + idPartie+ ", '" + PATH + "', " + numSection + ")");

    bouton.innerHTML = "Modifier";
    titre.innerHTML = "<strong>MODIFIER UNE PARTIE</strong>";
    btnAnnuler.style.display = "inline";

    
    bouton.scrollIntoView(false);

}

function modifierPartie(idPartie, PATH, numSection){
    var top = document.getElementById("tbodyTableAfficherParties");
    var idEquipeA = document.getElementById("selectEquipesA").value;
    var idEquipeB = document.getElementById("selectEquipesB").value;
    var jour = document.getElementById("datePartieAjout").value;
    var heure = document.getElementById("heurePartieAjout").value;
    var idPatinoire = document.getElementById("selectPatinoire").value;
    var bouton = document.getElementById("btnCreerPartie");
    var boutonAnnuler = document.getElementById("btnAnnulerModifPartie");

    var titre = document.getElementById("titreAjoutPartie");

    if (idEquipeA == "option1EquipeA" || idEquipeB == "option1EquipeB" || jour == "" || heure == "" || idPatinoire == "option1Patinoire"){
        alert("Veuillez remplir tous les champs");
        return;
    }
    
    if (idEquipeA == idEquipeB){
        alert("Vous avez choisi la même équipe deux fois.");
        return;
    }


    var urlModifierPartie = PATH + "/Calendrier/ModifierPartie?idPartie=" + idPartie + "&idEquipeA="+idEquipeA + "&idEquipeB= " + idEquipeB + "&jour=" + jour + "&heure=" +heure + "&idPatinoire=" + idPatinoire;

    
     ajax(urlModifierPartie, function (evt) {

        var xhr = evt.target;
        if (xhr.readyState == 4 && xhr.status == 200)  //réponse OK
        {
            var reponseJSON = xhr.responseText;
            var rep = JSON.parse(reponseJSON);
            if (rep.reponse != 'OK') {
                alert('Ajout non effectué');
            } else {
                
                //Reinitialiser les champs du formulaire
                document.getElementById("selectEquipesA").value = "option1EquipeA";
                document.getElementById("selectEquipesB").value = "option1EquipeB";
                document.getElementById("datePartieAjout").value = "";
                document.getElementById("heurePartieAjout").value = "";
                document.getElementById("selectPatinoire").value = "option1Patinoire";

                bouton.innerHTML = "Ajouter";
                bouton.setAttribute("onclick", "creerPartie('"+ PATH + "', 4)");
                bouton.setAttribute("class", "btn btn-secondary");                
                titre.innerHTML = "<strong>AJOUTER UNE PARTIE</strong>";

                
                boutonAnnuler.style.display = "none";
                //Modifier l'affichage des parties
                afficherParties(PATH, numSection);
                
                //Remonter en haut
                 titre.scrollIntoView(false);
                
            }
        }
    })
    
}


function supprimerPartie(idPartie, PATH, numSection){
     var urlSupprimerPartie = PATH + "/Calendrier/SupprimerPartie?idPartie="+idPartie;
         
    var decision = confirm("Supprimer une partie supprimera ses résultats (si elle en a), ce qui modifiera la fiche et le classement de ses équipes.");     
    if (decision == false){
        return;
    }
     
     //Aller effacer l'equipe par Ajax
    ajax(urlSupprimerPartie, function (evt) {
        var xhr = evt.target;
        if (xhr.readyState == 4 && xhr.status == 200)  //réponse OK
        {
            var reponseJSON = xhr.responseText;
            var rep = JSON.parse(reponseJSON);
            if (rep.reponse != 'OK') {
                alert('Suprresion non effectuée');


            } else {
                afficherParties(PATH, numSection);

            }
        }
    })
     
     
    
}

function afficherOptionsParticipants(PATH, numSection){
     //Aller chercher les elements pour afficher les equipes
    var idTournoi = document.getElementById("selectTournoi"+numSection).value;
    var selectA = document.getElementById("selectEquipesA");
    var selectB = document.getElementById("selectEquipesB");
    var premiereOptionA = document.getElementById("option1EquipeA");
    var premiereOptionB = document.getElementById("option1EquipeB");
    var urlListeParticipants = PATH + "/Participant/Afficher?idTournoi="+idTournoi;

    
    //D'abord, vider ce qui s'y trouve deja
    while (selectA.firstChild) {            
        selectA.removeChild(selectA.lastChild);
    }
    selectA.appendChild(premiereOptionA);

    while (selectB.firstChild) {
        selectB.removeChild(selectB.lastChild);
    }
    selectB.appendChild(premiereOptionB);
    

    //Ensuite, aller chercher la liste des equipes pour les afficher comme option
    ajax(urlListeParticipants, function (evt) {
        var xhr = evt.target;
        if (xhr.readyState == 4 && xhr.status == 200)  //réponse OK
        {
            var reponseJSON = xhr.responseText;
            var rep = JSON.parse(reponseJSON);
            
            if (rep.nombre=="aucun"){
                alert("Ajoutez des équipes pour ce tournoi afin de créer des parties.");
                
            }
            else{
                //Pour chacun des tournois
                rep.forEach(function (participant) {
                    //Creer une nouvelle option a inserer dans le select, et y mette les infos du tournoi
                    var nouvelleOptionA = document.createElement("option");
                    var nouvelleOptionB = document.createElement("option");
                    nouvelleOptionA.value = participant.id_equipe;
                    nouvelleOptionB.value = participant.id_equipe;
                    nouvelleOptionA.innerHTML = participant.nom_equipe;
                    nouvelleOptionB.innerHTML = participant.nom_equipe;
                    selectA.appendChild(nouvelleOptionA);
                    selectB.appendChild(nouvelleOptionB);
                });
            }
        }
    })
}

function afficherResultats(PATH, numSection){
    
    var idTournoi = document.getElementById("selectTournoi"+numSection).value;
    var sectionPrincipale = document.getElementById("afficherPartiesSection5");
    var tableParties = document.getElementById("tableAfficherPartiesSection5");
    var tbodyParties = document.getElementById("tbodyAfficherPartiesSection5");
    var urlListeParties = PATH + "/Calendrier/AfficherParties?idTournoi="+idTournoi;
    
    reinitialiserContenu(numSection, PATH, false);
    
      //Si aucun tournoi selectionne, ne pas poursuivre
    if (idTournoi == "option1"){
        return;
    }

    
    var compteurLigne = 1;
    tbodyParties.innerHTML = tableParties.rows[0].innerHTML;
    
     //Ensuite, vider les parties qui s'y trouvent deja    
    tableParties.style.display = "none";
    
    //Aller chercher les parties a afficher et mettre leurs details
    ajax(urlListeParties, function (evt) {
        var xhr = evt.target;
        
        if (xhr.readyState == 4 && xhr.status == 200)  //réponse OK
        {
            var reponseJSON = xhr.responseText;
            var rep = JSON.parse(reponseJSON);
            
            //Si aucune partie...
            if (rep.nombre == "aucun") {
                var row = tableParties.insertRow(1);
                //Jour
                row.innerHTML = "Aucune partie."
                                    
            }
            
            //Sinon, s'il y a des parties
            else{
                 
                //Pour chaque partie
                
                rep.forEach(function (partie) {
                    
                    //Creer une nouvelle ligne dans la table pour y inserer cette partie avec toutes ses infos
              
                    var row = tableParties.insertRow(tableParties.rows.length);
                    compteurLigne++;
                    //Jour
                    var jour = row.insertCell(0);
                    jour.innerHTML = partie.jour;
                    
                    //Heure
                    var heure = row.insertCell(1);
                    heure.innerHTML = partie.heure;
                    
                    //Equipe A
                    var equipeA = row.insertCell(2);
                    equipeA.innerHTML = partie.nom_equipeA;
                    
                    //Equipe B
                    var equipeB = row.insertCell(3);
                    equipeB.innerHTML = partie.nom_equipeB;
                    
                    //Patinoire
                    var patinoire = row.insertCell(4);
                    patinoire.innerHTML = partie.nom_patinoire + ", " + partie.ville;
                    
                    //S'il n'y a pas de resultat, offrir de l'ajouter
                    
                    if (partie.buts_locaux == "null"){
                        var rowAjout = tableParties.insertRow(tableParties.rows.length);
                        rowAjout.insertCell(0);
                        rowAjout.insertCell(1);
                        
                         var selectA = document.createElement("select");
                         var sectionSelectA = rowAjout.insertCell(2);
                         var selectB = document.createElement("select");
                         var sectionSelectB = rowAjout.insertCell(3);
                         selectA.setAttribute("class", "custom-select my-1 mr-sm-2");
                         selectA.id = "selectButsA"+partie.id_partie;
                         selectB.setAttribute("class", "custom-select my-1 mr-sm-2");
                         selectB.id = "selectButsB"+partie.id_partie;



                         //Creer les options pour les 2 select
                         for (let i=0; i<21; i++){
                             var optionA = document.createElement("option");
                             var optionB = document.createElement("option");
                             optionA.value = i;
                             optionB.value = i;
                             optionA.innerHTML = i;
                             optionB.innerHTML = i;
                             selectA.appendChild(optionA);
                             selectB.appendChild(optionB);
                         }


                         sectionSelectA.appendChild(selectA);
                         sectionSelectB.appendChild(selectB);

                         //Creer le bouton Ajouter
                         var boutonAjout = document.createElement("button");
                         boutonAjout.setAttribute("class", "btn btn-primary");
                         boutonAjout.id = "btnAjoutResultat" +partie.id_partie;
                         boutonAjout.setAttribute("onclick", "ajouterResultat('" + PATH +"', " + partie.id_partie + ", "+ numSection + ")");
                         boutonAjout.innerHTML = "Ajouter";
                         var sectionBouton = rowAjout.insertCell(4);
                         sectionBouton.appendChild(boutonAjout);
                         rowAjout.insertCell(5);
                                                  
                        
                        
                    }
                    //Sinon, afficher le resultat
                    else{
                        var rowResultat = tableParties.insertRow(tableParties.rows.length);
                        rowResultat.setAttribute("class", "table-info");
                        var titre = rowResultat.insertCell(0);
                        titre.innerHTML = "RÉSULTAT:";
                        titre.style.fontWeight = "bold";
                        rowResultat.insertCell(1);
                        var scoreA = rowResultat.insertCell(2);
                        scoreA.innerHTML = "&nbsp&nbsp"+partie.buts_locaux;
                        scoreA.style.fontWeight = "bold";
                        var scoreB = rowResultat.insertCell(3);
                        scoreB.innerHTML = "&nbsp&nbsp"+partie.buts_adverses; 
                        scoreB.style.fontWeight = "bold";
                        
                        rowResultat.insertCell(4);
                        
                        //Bouton supprimer
                        var sectionSupprimer = rowResultat.insertCell(5);
                        var iconeEffacer = document.createElement("img");
                        iconeEffacer.src = PATH + "/Vues/Images/trash-icon.png";
                        iconeEffacer.style.width = "22px";
                        iconeEffacer.style.cursor = "pointer";
                        iconeEffacer.setAttribute("onclick", "supprimerResultat('" + PATH +"', " + partie.id_partie + ", "+ numSection + ")");
                        sectionSupprimer.appendChild(iconeEffacer);
                        
                         //Image modifier
                        var sectionModif = rowResultat.insertCell(6);
                        var iconeModif = document.createElement("img");
                        iconeModif.src = PATH + "/Vues/Images/edit-icon2.png";
                        iconeModif.style.width = "22px";
                        iconeModif.style.cursor = "pointer";
                        iconeModif.setAttribute("onclick", "remplirModifResultat(" + partie.id_partie + ", " + partie.buts_locaux + ", " + partie.buts_adverses + ",'" + PATH + "', "+numSection+ ", "+ (tableParties.rows.length-1) + ")");
                        sectionModif.appendChild(iconeModif);
                        
                        
                    }
                    
                    var ligneVide = tableParties.insertRow(tableParties.rows.length);
                    ligneVide.insertCell(0);
                    ligneVide.insertCell(1);
                    ligneVide.insertCell(2);
                    ligneVide.insertCell(3);
                    ligneVide.insertCell(4);
                    var ligneVide2 = tableParties.insertRow(tableParties.rows.length);
                    ligneVide2.insertCell(0);
                    ligneVide2.insertCell(1);
                    ligneVide2.insertCell(2);
                    ligneVide2.insertCell(3);
                    ligneVide2.insertCell(4);
                    var ligneVide3 = tableParties.insertRow(tableParties.rows.length);
                    ligneVide3.insertCell(0);
                    ligneVide3.insertCell(1);
                    ligneVide3.insertCell(2);
                    ligneVide3.insertCell(3);
                    ligneVide3.insertCell(4);
                    
                    
                })
            }
        }
    });
            
    //Afficher tout
    var derniereLigne = tableParties.rows.length-1;
    tableParties.rows[derniereLigne].style.display = "none";
    tableParties.style.display = "block";
    sectionPrincipale.style.display = "block";
    
}

function remplirModifResultat(idPartie, butsA, butsB, PATH, numSection, indiceLigne){
    var tableParties = document.getElementById("tableAfficherPartiesSection5");
    var ligne = tableParties.rows[indiceLigne];

    //Vider le contenu de la ligne.
    ligne.innerHTML = "";
      
    //Inserer le contenu pour modifier le Resultat
    ligne.insertCell(0);
    ligne.insertCell(1);

     var selectA = document.createElement("select");
     var sectionSelectA = ligne.insertCell(2);
     var selectB = document.createElement("select");
     var sectionSelectB = ligne.insertCell(3);
     selectA.setAttribute("class", "custom-select my-1 mr-sm-2");
     selectA.id = "selectButsA"+idPartie;
     selectB.setAttribute("class", "custom-select my-1 mr-sm-2");
     selectB.id = "selectButsB"+idPartie;



     //Creer les options pour les 2 select
     for (let i=0; i<21; i++){
         var optionA = document.createElement("option");
         var optionB = document.createElement("option");
         optionA.value = i;
         optionB.value = i;
         optionA.innerHTML = i;
         optionB.innerHTML = i;
         selectA.appendChild(optionA);
         selectB.appendChild(optionB);
     }

     //Pre-selectionner les buts de la partie
     selectA.value = butsA;
     selectB.value = butsB;

     sectionSelectA.appendChild(selectA);
     sectionSelectB.appendChild(selectB);

     //Creer le bouton Modifier
     var boutonAjout = document.createElement("button");
     boutonAjout.setAttribute("class", "btn btn-warning");
     boutonAjout.id = "btnAjoutResultat" +idPartie;
     boutonAjout.setAttribute("onclick", "modifierResultat('" + PATH +"', " + idPartie + "," + butsA + ", " + butsB + ", "+ numSection + ", " + indiceLigne + ")");
     boutonAjout.innerHTML = "Modifier";
     var sectionBouton1 = ligne.insertCell(4);
     sectionBouton1.appendChild(boutonAjout);
     
     //Creer le bouton Annuler
     var boutonAnnuler = document.createElement("button");
     boutonAnnuler.setAttribute("class", "btn btn-secondary");
     boutonAnnuler.id = "btnAnnulerModifResultat" +idPartie;
     boutonAnnuler.setAttribute("onclick", "afficherResultats('" + PATH +"', " +  numSection + ")");
     boutonAnnuler.innerHTML = "Annuler";
     var sectionBouton2 = ligne.insertCell(5);
     sectionBouton2.appendChild(boutonAnnuler);
     
}


function modifierResultat(PATH, idPartie, anciensButsA, anciensButsB, numSection, indiceLigne){

    var decision = confirm("Modifier un résultat modifiera la fiche et le classement des équipes si les gagnants et perdants ne sont plus les mêmes.");
    
    if (decision == false){
        afficherResultats(PATH, numSection);
        return;
    }
    var nouveauxButsLocaux = document.getElementById("selectButsA"+idPartie).value;
    var nouveauxButsAdverses = document.getElementById("selectButsB"+idPartie).value;
    
    
    var urlModifierResultat = PATH + "/Resultat/Modifier?idPartie="+idPartie + "&anciensLocaux="+anciensButsA + "&anciensAdverses=" + anciensButsB +"&nouveauxLocaux="+nouveauxButsLocaux+ "&nouveauxAdverses="+nouveauxButsAdverses;
    
    ajax(urlModifierResultat, function (evt) {
       var xhr = evt.target;
       if (xhr.readyState == 4 && xhr.status == 200)  //réponse OK
       {
           var reponseJSON = xhr.responseText;
           var rep = JSON.parse(reponseJSON);

           //Si aucun resultat, alors offrir d'ajouter un resultat
           if (rep.reponse == "OK") { 
               afficherResultats(PATH, numSection);
               
           }
       }
   });
    
}

function chercherResultat(PATH, idPartie){
    var urlChercherResultat = PATH + "/Resultat/Chercher?idPartie="+idPartie;
    var resultats = new Array();
                    
    ajax(urlChercherResultat, function (evt) {
       var xhr = evt.target;
       if (xhr.readyState == 4 && xhr.status == 200)  //réponse OK
       {
           var reponseJSON = xhr.responseText;
           var rep = JSON.parse(reponseJSON);

           //Si aucun resultat, alors offrir d'ajouter un resultat
           if (rep.reponse != "aucun") {           
                resultats.push(rep.buts_locaux);
                resultats.push(rep.buts_adverses);
           }
           
       }
              
   });

}

function ajouterResultat(PATH, idPartie, numSection){
    var butsLocaux = document.getElementById("selectButsA"+idPartie).value;
    var butsAdverses = document.getElementById("selectButsB"+idPartie).value;    
    var urlAjouterResultat = PATH + "/Resultat/Ajouter?idPartie="+idPartie+"&butsLocaux="+butsLocaux+ "&butsAdverses="+butsAdverses;
    
    ajax(urlAjouterResultat, function (evt) {
       var xhr = evt.target;
       if (xhr.readyState == 4 && xhr.status == 200)  //réponse OK
       {
           var reponseJSON = xhr.responseText;
           var rep = JSON.parse(reponseJSON);

           //Si aucun resultat, alors offrir d'ajouter un resultat
           if (rep.reponse == "OK") { 
               afficherResultats(PATH, numSection);
                
           }
           
       }
              
   });
    
}

function supprimerResultat(PATH, idPartie, numSection){
    
    var decision = confirm("Supprimer un résultat modifiera la fiche et le classement des équipes.");
    
    if (decision == false){
        return;
    }
    
    
    var urlSupprimerResultat = PATH + "/Resultat/Supprimer?idPartie="+idPartie;
    ajax(urlSupprimerResultat, function (evt) {
       var xhr = evt.target;
       if (xhr.readyState == 4 && xhr.status == 200)  //réponse OK
       {
           var reponseJSON = xhr.responseText;
           var rep = JSON.parse(reponseJSON);

           //Si aucun resultat, alors offrir d'ajouter un resultat
           if (rep.reponse == "OK") { 
               afficherResultats(PATH, numSection);
           }
       }
              
   });
    
}





//Fonctions pour affichage general

function afficherOptionsTournois(PATH, numSection) {
    //Aller chercher les elements pour afficher les tournois
    var select = document.getElementById("selectTournoi"+numSection);
    var premiereOption = document.getElementById("premiereOptionTournoi"+numSection);
    var urlListeTournois = PATH + "/Tournoi/Afficher";
    
    reinitialiserContenu(numSection, PATH);

    //Aller chercher la liste des tournois pour les afficher comme option
    ajax(urlListeTournois, function (evt) {
        var xhr = evt.target;
        if (xhr.readyState == 4 && xhr.status == 200)  //réponse OK
        {
            var reponseJSON = xhr.responseText;
            var rep = JSON.parse(reponseJSON);

            //Pour chacun des tournois
            rep.forEach(function (tournoi) {

                //Creer une nouvelle option a inserer dans le select, et y mette les infos du tournoi
                var nouvelleOption = document.createElement("option");
                nouvelleOption.value = tournoi.id_tournoi;
                nouvelleOption.innerHTML = tournoi.nom_tournoi;
                select.appendChild(nouvelleOption);
            });
        }
    })
}

function reinitialiserContenu(numSection, PATH, reinitialiserOptionsTournois=true){    
    
     var select = null;
     var premiereOption = null;

    if (reinitialiserOptionsTournois){
          select = document.getElementById("selectTournoi"+numSection);
          premiereOption = document.getElementById("premiereOptionTournoi"+numSection);

          while (select.firstChild) {
             select.removeChild(select.lastChild);
          }
          select.appendChild(premiereOption);
    }
    
    if (numSection == 2){      
        var btnAjouter = document.getElementById("btnAjouterTournoi");
        btnAjouter.innerHTML = "Ajouter";
        btnAjouter.setAttribute("class", "btn btn-secondary");
        btnAjouter.setAttribute("onclick", "ajouterTournoi('" + PATH + "')");
   
        var titre = document.getElementById("titreTournoi");
        titre.innerHTML = "<strong>AJOUTER UN TOURNOI</strong>";

        document.getElementById("nomTournoiAjout").value = "";
        document.getElementById('minTournoi').value = "";
        document.getElementById('maxTournoi').value = "";
        document.getElementById('dateDebutTournoi').value = "";
        document.getElementById('dateFinTournoi').value = "";
        document.getElementById('dateLimiteInscription').value = "";
        document.getElementById("btnAnnulerModifTournoi").style.display = "none";

    }
       
     
    if (numSection == 3){
        document.getElementById("afficherEquipes").style.display = "none";
    }

    else if (numSection == 4){
        document.getElementById("affichageParties").style.display = "none";
        document.getElementById("formulaireCreerCalendrier").style.display = "none";
        document.getElementById("btnAnnulerModifPartie").style.display = "none";
        document.getElementById("btnAnnulerModifCalendrier").style.display = "none";
        document.getElementById("selectEquipesA").value = "option1EquipeB";
        document.getElementById("selectEquipesB").value = "option1EquipeB";
        document.getElementById("datePartieAjout").value = "";
        document.getElementById("heurePartieAjout").value = "";
        document.getElementById("selectPatinoire").value = "option1Patinoire";
        document.getElementById("titreAjoutPartie").innerHTML = "<strong>AJOUTER UNE PARTIE</strong>";
        document.getElementById("formModifierCalendrier").style.display = "none";
        document.getElementById("nbrEquipesModifCalendrier").innerHTML = "";
        document.getElementById("debutModifCalendrier").innerHTML = "";
        document.getElementById("finModifCalendrier").innerHTML = ""; 
        
        var boutonAjouter = document.getElementById("btnModifCal");
        boutonAjouter.innerHTML = "Modifier le calendrier";
        boutonAjouter.setAttribute("onclick", "remplirModifCalendrier('"+ PATH + "', 4)");
    
        var btnAjouter2 = document.getElementById("btnCreerPartie");
        btnAjouter2.innerHTML = "Ajouter";
        btnAjouter2.setAttribute("class", "btn btn-secondary");
        btnAjouter2.setAttribute("onclick", "creerPartie('" + PATH + "', "+numSection + ")");        
    }
    
    else if (numSection == 5){
        document.getElementById("afficherPartiesSection5").style.display = "none";
        document.getElementById("tableAfficherPartiesSection5").style.display = "none";
    }
    
}

function estVide(str){
    return str === null || str.match(/^ *$/) !== null;
}

//Calculer la difference entre deux dates, en nombre de jours
function dateDiff(tot, tard) {
    return Math.round((tard-tot)/(1000*60*60*24));
}

function dureeNecessaireTournoi(nbrEquipes){
    
    //Nombre minimum de jours pour que chaque equipe joue 2 parties contre toutes les autres equipes, avec une journee de conge entre chaque
    return (nbrEquipes -1) * nbrEquipes;
}




                                                           