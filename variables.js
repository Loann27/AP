let page = 0;
let preadmi;
let date_hospi;
let heure;
let medecin;
let civ;
let nom_nais;
let nom_ep;
let pren;
let date_nais;
let adr;
let cp;
let ville;
let email;
let tel;
let nom_prev;
let pren_prev;
let tel_prev;
let adr_prev;
let nom_conf;
let pren_conf;
let tel_conf;
let adr_conf;
let orga;
let num_secu;
let assure;
let ald;
let nom_mutu;
let num_adherent;
let chambre_part;
let doc_identite;
let doc_vitale;
let doc_mutuelle;
let doc_livret;
let erreur = false;
pages();

function getISODate(){
    const d = new Date();
    return d.getFullYear() + '-' + 
            ('0' + (d.getMonth()+1)).slice(-2) + '-' +
            ('0' + d.getDate()).slice(-2);
}


function pages() {
    if(page == 0) {
        document.getElementById("affichage").innerHTML = "<img src='../../images/Hospitalisation.png' class='center'>" + "<div id='bloc1'>" + "<form onsubmit='hospitalisation();return false'>" + "<label for='preadmi'>Pré-admission pour:*</label>" + "<select name='preadmi' id='preadmi' required>" + "<option value=''>Choix</option>" + "<option value='Ambulatoire chirurgie'>Ambulatoire chirurgie</option>" + "<option value='Hospitalisation'>Hospitalisation (au moins une nuit)</option>" + "</select><br><br>" + "<label for='date_hospi'>Date hospitalisation:* </label>" + "<input id='date_hospi' name='date_hospi' type='date' required><br/>" + "<label for='heure'>Heure de l'intervention (7:00 - 16:30):* </label>" + "<input id='heure' name='heure' type='time' placeholder='--:--' onchange='verif_time(this.value)' required><br><br>" + "<label for='medecin'>Nom du médecin*</label><br>" + "<select name='medecin' id='medecin' required>" + "<option value=''>Choix</option>" + "<option value='Alexandrie Covillon'>Alexandrie COVILLON (Maxillo-facial)</option>" + "<option value='Françoise Marquis'>Françoise MARQUIS (Radiologue)</option>" + "<option value='Hugues Faure'>Hugues FAURE (Neurologue)</option>" + "</select><br><br>" + "<input type='submit' id='submit' name='submit' value='Suivant >'>" + "</form>" + "</div>" + "<div id='erreur'>" + "<p id='aff_erreur'>" + "</div>";
        document.getElementById('date_hospi').setAttribute('min',getISODate());
    } else if(page == 1) {
        document.getElementById("affichage").innerHTML = "<img src='../../images/Patient.png' class='center'>" + "<div id='bloc1'>" + "<h1>Informations concernant le patient</h1>" + "<form onsubmit='patients();return false'>" + "<label for='civ'>Civ. </label>" + "<select name='civ' id='civ' required>" + "<option value=''>Choix</option>" + "<option value='Homme'>Homme</option>" + "<option value='Femme'>Femme</option>" + "</select>" + "<label for='nom_naissance'>Nom de naissance </label>" + "<input id='nom_naissance' name='nom_naissance' type='text' required>" + "<label for='nom_epouse'>Nom d'épouse </label>" + "<input id='nom_epouse' name='nom_epouse' type='text'><br><br>" + "<label for='prenom'>Prénom </label>" + "<input type='text' id='prenom' name='prenom' required>"  + "<label for='date_naissance'>Date de naissance </label>" + "<input type='date' id='date_naissance' name='date_naissance' required><br><br>" + "<label for='adresse'>Adresse </label>" + "<input type='text' id='adresse' name='adresse' required><br><br>" + "<label for='cp'>Code Postal </label>" + "<input type='tel' id='cp' name='cp' pattern='[0-9]{5}' required>" + "<label for='ville'>Ville </label>" + "<input type='text' id='ville' name='ville' required><br><br>" + "<label for='email'>Email </label>" + "<input type='mail' id='email' name='email' required>" + "<label for='telephone'>Téléphone </label>" + "<input type='tel' id='telephone' name='telephone' pattern='[0-9]{10}' required><br><br>" + "<input type='submit' id='submit' name='submit' value='Suivant >'>" + "</form>" + "<input type='submit' onclick='precedent();return false' value='précédent'>" + "</div>";
        document.getElementById('date_naissance').setAttribute('max',getISODate());
    } else if(page == 2) {
        document.getElementById("affichage").innerHTML = "<img src='../../images/Patient.png' class='center'>" + "<div id='bloc1'>" + "<h1>Coordonnées personne à prévenir</h1>" + "<form onsubmit='prevenir();return false'>" + "<label for='nom_prev'>Nom </label>" + "<input type='text' name='nom_prev' id='nom_prev'>" + "<label for='pren_prev'>Prénom </label>" + "<input type='text' name='pren_prev' id='pren_prev'>" + "<label for='tel_prev'>Téléphone </label>" + "<input type='tel' name='tel_prev' id='tel_prev' pattern='[0-9]{10}'><br>" + "<label for='adr_prev'>Adresse</label>" + "<input type='text' name='adr_prev' id='adr_prev'>" + "<input type='submit' name='submit' id='submit' value='Suivant >'>" + "</form>" + "<input type='submit' onclick='precedent();return false' value='précédent'>" + "</div>";
    } else if(page == 3) {
        document.getElementById("affichage").innerHTML = "<img src='../../images/Patient.png' class='center'>" + "<div id='bloc1'>" + "<h1>Coordonnées personne de confiance</h1>" + "<form onsubmit='confiance();return false'>" + "<label for='nom_conf'>Nom </label>" + "<input type='text' name='nom_conf' id='nom_conf'>" + "<label for='pren_conf'>Prénom </label>" + "<input type='text' name='pren_conf' id='pren_conf'>" + "<label for='tel_conf'>Téléphone </label>" + "<input type='tel' name='tel_conf' id='tel_conf' pattern='[0-9]{10}'><br>" + "<label for='adr_conf'>Adresse</label>" + "<input type='text' name='adr_conf' id='adr_conf'>" + "<input type='submit' name='submit' id='submit' value='Suivant >'>" + "</form>" + "<input type='submit' onclick='precedent();return false' value='précédent'>" + "</div>";
    } else if(page == 4) {
        document.getElementById("affichage").innerHTML = "<img src='../../images/couvert_sociale.png' class='center'>" + "<div id='bloc1'>" + "<form onsubmit='couv_sociale();return false'>" + "<label for='orga'>Organisme de sécurité sociale / Nom de la caisse d'assurance maladie* </label>" + "<input type='text' name='orga' id='orga' placeholder='Ex: CPAM du Tarn et Garonne, CPAM du Lot, RSI, MSA...' required><br>" + "<label for='num_secu'>Numéro de sécurité sociale* </label>" + "<input type='tel' name='num_secu' id='num_secu' pattern='[0-9]{13}' required><br>" + "<label for='assure'>Le patient est-il assuré?* </label>" + "<select name='assure' id='assure' required>" + "<option value=''>Choix</option>" + "<option value='oui'>Oui</option>" + "<option value='non'>Non</option>" + "</select>" + "<label for='ald'>Le patient est-il ALD?* </label>" + "<select name='ald' id='ald' required>" + "<option value=''>Choix</option>" + "<option value='oui'>Oui</option>" + "<option value='non'>Non</option>" + "</select><br><br>" + "<label for='nom_mutu'>Nom de la mutuelle ou de l'assurance* </label>" + "<input type='text' name='nom_mutu' id='nom_mutu' required>" + "<label for='num_adherent'>Numéro adhérent* </label>" + "<input type='tel' name='num_adherent' id='num_adherent' required>" + "<label for='chambre_part'>Chambre particulière?* </label>" + "<select name='chambre_part' id='chambre_part' required>" + "<option value=''>Choix</option>" + "<option value='oui'>Oui</option>" + "<option value='non'>Non</option>" + "</select><br>" + "<input type='submit' name='submit' id='submit' value='Suivant >'>" + "</form>" + "<input type='submit' value='précédent' onclick='precedent();return false'>" + "</div>" + "<div id='erreur'>" + "<p id='aff_erreur'>" + "</div>";
    } else if(page == 5) {
        document.getElementById("affichage").innerHTML = "<img src='../../images/documents.png' class='center'>" + "<div id='bloc1'>" + "<form onsubmit='doc();return false'>" + "<label for='identity'>Carte d'identité (recto / verso):</label>" + "<input type='file' id='identity' accept='.jpg, .png, .pdf' required>" + "<br/>" + "<label for='carteVitale'>Carte vitale:</label>" + "<input type='file' id='carteVitale' accept='.jpg, .png, .pdf' required>" + "<br/>" + "<label for='mutuelle'>Carte de mutuelle:</label>" + "<input type='file' id='mutuelle' name='mutuelle' accept='.jpg, .png, .pdf' required>" + "<br/>" + "<label for='livretFamille'>Livret de famille (pour enfants mineurs):</label>" + "<input type='file' id='livretFamille' name='livretFamille' accept='.jpg, .png, .pdf'>" + "<br/>" + "<input type='submit' name='submit' id='submit' value='Envoyer'>" + "</form>" + "<input type='submit' value='précédent' onclick='precedent();return false'>" + "</div>";
    }
}

function hospitalisation() {
    preadmi = document.getElementById("preadmi").value;
    date_hospi = document.getElementById("date_hospi").value;
    heure = document.getElementById("heure").value;
    medecin = document.getElementById("medecin").value;
    if(erreur == true) {
        alert("Une erreur est survenue!");
        return;
    }
    page = page + 1;
    pages();
}

function verif_time(time) {
    let [hours, mins] = time.split(":");
    if((hours < 7) || (hours > 16) || (hours == 16 && mins > 30)) {
        message4();
        erreur = true;
    } else {
        document.getElementById("aff_erreur").innerHTML = "";
        erreur = false;
    }
}

function patients() {
    civ = document.getElementById("civ").value;
    nom_nais = document.getElementById("nom_naissance").value;
    nom_ep = document.getElementById("nom_epouse").value;
    pren = document.getElementById("prenom").value;
    date_nais = document.getElementById("date_naissance").value;
    adr = document.getElementById("adresse").value;
    cp = document.getElementById("cp").value;
    ville = document.getElementById("ville").value;
    email = document.getElementById("email").value;
    tel = document.getElementById("telephone").value;
    page = page + 1;
    pages();
}

function prevenir() {
    nom_prev = document.getElementById("nom_prev").value;
    pren_prev = document.getElementById("pren_prev").value;
    tel_prev = document.getElementById("tel_prev").value;
    adr_prev = document.getElementById("adr_prev").value;
    page = page + 1;
    pages();
}

function confiance() {
    nom_conf = document.getElementById("nom_conf").value;
    pren_conf = document.getElementById("pren_conf").value;
    tel_conf = document.getElementById("tel_conf").value;
    adr_conf = document.getElementById("adr_conf").value;
    page = page + 1;
    pages();
}

function couv_sociale() {
    erreur = false;
    orga = document.getElementById("orga").value;
    num_secu = document.getElementById("num_secu").value;
    assure = document.getElementById("assure").value;
    ald = document.getElementById("ald").value;
    nom_mutu = document.getElementById("nom_mutu").value;
    num_adherent = document.getElementById("num_adherent").value;
    chambre_part = document.getElementById("chambre_part").value;
    verif_num_secu();
    if(erreur == true) {
        alert("Une erreur est survenue!");
        return;
    }
    page = page + 1;
    pages();
}

function verif_num_secu() { // Vérification du numéro de sécurité sociale
    const first = num_secu.slice(0,1);
    const first_year = num_secu.slice(1,3);
    const first_month = num_secu.slice(3,5);
    const data_birth = new Date(date_nais);
    const y = data_birth.getFullYear().toString().slice(2,4);
    const x = (data_birth.getMonth() + 1).toString();
    if((first == 1 && civ != "Homme") || (first == 2 && civ != "Femme") || ((first != 1) && (first != 2))) {
        message();
        erreur = true;
    }
    if(y != first_year) {
        message2();
        erreur = true;
    }
    if(x != first_month) {
        message3();
        erreur = true;
    }
}

function doc() {
    doc_identite = document.getElementById("identity").value;
    doc_vitale = document.getElementById("carteVitale").value;
    doc_mutuelle = document.getElementById("mutuelle").value;
    doc_livret = document.getElementById("livretFamille").value;
}

function precedent() {
    page = page - 1;
    pages();
}

function message() {
    document.getElementById("aff_erreur").innerHTML = "Numéro de sécurité sociale incompatible avec la civilté!";
}

function message2() {
    document.getElementById("aff_erreur").innerHTML = "Numéro de sécurité sociale incompatible avec l'année de naissance!";
}

function message3() {
    document.getElementById("aff_erreur").innerHTML = "Numéro de sécurité sociale incompatible avec le mois de naissance!";
}

function message4() {
    document.getElementById("aff_erreur").innerHTML = "Heure d'intervention incorrecte!";
}
