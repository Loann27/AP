let page = 0;
let preadmi;
let date_hospi;
let heure;
let medecin;
let civ;
let nom_nais;
let nom_ep = "";
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
show();
let xhttp = new XMLHttpRequest() // Utilisé pour AJAX
pages();


function getISODate(){
    const d = new Date();
    return d.getFullYear() + '-' + 
            ('0' + (d.getMonth()+1)).slice(-2) + '-' +
            ('0' + d.getDate()).slice(-2);
}


function pages() {
    if(page == 0) {
        document.getElementById("affichage").innerHTML = "<img src='../../images/Hospitalisation.png' class='center'>" + "<div id='bloc1'>" + "<form onsubmit='hospitalisation();return false'>" + "<label for='preadmi'>Pré-admission pour:*</label>" + "<select name='preadmi' id='preadmi' required>" + "<option value=''>Choix</option>" + "<option value='Ambulatoire chirurgie'>Ambulatoire chirurgie</option>" + "<option value='Hospitalisation'>Hospitalisation (au moins une nuit)</option>" + "</select><br><br>" + "<label for='date_hospi'>Date hospitalisation:* </label>" + "<input id='date_hospi' name='date_hospi' type='date' onchange='verif()' required><br/>" + "<label for='heure'>Heure de l'intervention (7:00 - 16:30):* </label>" + "<input id='heure' name='heure' type='time' placeholder='--:--' onchange='verif_time(this.value)' required><br><br>" + "<label for='medecin'>Nom du médecin*</label><br>" + "<select name='medecin' id='medecin' required>" + "<option value=''>Choix</option>" + "<option value='COVILLON'>Alexandrie COVILLON (Maxillo-facial)</option>" + "<option value='MARQUIS'>Françoise MARQUIS (Radiologue)</option>" + "<option value='FAURE'>Hugues FAURE (Neurologue)</option>" + "</select><br><br>" + "<input type='submit' id='submit' name='submit' value='Suivant >'>" + "</form>" + "</div>";
        document.getElementById('date_hospi').setAttribute('min',getISODate());
    } else if(page == 1) {
        document.getElementById("affichage").innerHTML = "<img src='../../images/Patient.png' class='center'>" + "<div id='bloc1'>" + "<h1>Informations concernant le patient</h1>" + "<form onsubmit='patients();return false'>" + "<label for='civ'>Civ. </label>" + "<select name='civ' id='civ' required>" + "<option value=''>Choix</option>" + "<option value='Homme'>Homme</option>" + "<option value='Femme'>Femme</option>" + "</select><br/>" + "<label for='nom_naissance'>Nom de naissance </label>" + "<input id='nom_naissance' name='nom_naissance' type='text' required><br/>" + "<label for='nom_epouse'>Nom d'épouse </label>" + "<input id='nom_epouse' name='nom_epouse' type='text'><br><br>" + "<label for='prenom'>Prénom </label>" + "<input type='text' id='prenom' name='prenom' required><br/>"  + "<label for='date_naissance'>Date de naissance </label>" + "<input type='date' id='date_naissance' name='date_naissance' required><br><br>" + "<label for='adresse'>Adresse </label>" + "<input type='text' id='adresse' name='adresse' required><br><br>" + "<label for='cp'>Code Postal </label>" + "<input type='tel' id='cp' name='cp' pattern='[0-9]{5}' required><br/>" + "<label for='ville'>Ville </label>" + "<input type='text' id='ville' name='ville' required><br><br>" + "<label for='email'>Email (.com, .fr, .en, .net, .co.uk)</label>" + "<input type='mail' id='email' name='email' required><br/><br/>" + "<label for='telephone'>Téléphone </label>" + "<input type='tel' id='telephone' name='telephone' pattern='[0-9]{10}' required><br><br>" + "<input type='submit' id='submit' name='submit' value='Suivant >'>" + "</form>" + "<input type='submit' onclick='precedent();return false' value='précédent'>" + "</div>";
        document.getElementById('date_naissance').setAttribute('max',getISODate());
    } else if(page == 2) {
        document.getElementById("affichage").innerHTML = "<img src='../../images/Patient.png' class='center'>" + "<div id='bloc1'>" + "<h1>Coordonnées personne à prévenir</h1>" + "<form onsubmit='prevenir();return false'>" + "<label for='nom_prev'>Nom </label>" + "<input type='text' name='nom_prev' id='nom_prev' required><br/>" + "<label for='pren_prev'>Prénom </label>" + "<input type='text' name='pren_prev' id='pren_prev' required><br/>" + "<label for='tel_prev'>Téléphone </label>" + "<input type='tel' name='tel_prev' id='tel_prev' pattern='[0-9]{10}' required><br/>" + "<label for='adr_prev'>Adresse</label>" + "<input type='text' name='adr_prev' id='adr_prev' required><br/>" + "<input type='submit' name='submit' id='submit' value='Suivant >'>" + "</form>" + "<input type='submit' onclick='precedent();return false' value='précédent'>" + "</div>";
    } else if(page == 3) {
        document.getElementById("affichage").innerHTML = "<img src='../../images/Patient.png' class='center'>" + "<div id='bloc1'>" + "<h1>Coordonnées personne de confiance</h1>" + "<form onsubmit='confiance();return false'>" + "<label for='nom_conf'>Nom </label>" + "<input type='text' name='nom_conf' id='nom_conf' required><br/>" + "<label for='pren_conf'>Prénom </label>" + "<input type='text' name='pren_conf' id='pren_conf' required><br/>" + "<label for='tel_conf'>Téléphone </label>" + "<input type='tel' name='tel_conf' id='tel_conf' pattern='[0-9]{10}' required><br/>" + "<label for='adr_conf'>Adresse</label>" + "<input type='text' name='adr_conf' id='adr_conf' required><br/>" + "<input type='submit' name='submit' id='submit' value='Suivant >'>" + "</form>" + "<input type='submit' onclick='precedent();return false' value='précédent'>" + "</div>";
    } else if(page == 4) {
        document.getElementById("affichage").innerHTML = "<img src='../../images/couvert_sociale.png' class='center'>" + "<div id='bloc1'>" + "<form onsubmit='couv_sociale();return false'>" + "<label for='orga'>Organisme de sécurité sociale / Nom de la caisse d'assurance maladie* </label>" + "<input type='text' name='orga' id='orga' placeholder='Ex: CPAM du Tarn et Garonne, CPAM du Lot, RSI, MSA...' required><br/>" + "<label for='num_secu'>Numéro de sécurité sociale* </label>" + "<input type='tel' name='num_secu' id='num_secu' pattern='[0-9]{15}' required><br/>" + "<label for='assure'>Le patient est-il assuré?* </label>" + "<select name='assure' id='assure' required>" + "<option value=''>Choix</option>" + "<option value='oui'>Oui</option>" + "<option value='non'>Non</option>" + "</select><br/>" + "<label for='ald'>Le patient est-il ALD?* </label>" + "<select name='ald' id='ald' required>" + "<option value=''>Choix</option>" + "<option value='oui'>Oui</option>" + "<option value='non'>Non</option>" + "</select><br/>" + "<label for='nom_mutu'>Nom de la mutuelle ou de l'assurance* </label>" + "<input type='text' name='nom_mutu' id='nom_mutu' required><br/>" + "<label for='num_adherent'>Numéro adhérent* </label>" + "<input type='tel' name='num_adherent' id='num_adherent' required><br/>" + "<label for='chambre_part'>Chambre particulière?* </label>" + "<select name='chambre_part' id='chambre_part' required>" + "<option value=''>Choix</option>" + "<option value='oui'>Oui</option>" + "<option value='non'>Non</option>" + "</select><br/>" + "<input type='submit' name='submit' id='submit' value='Suivant >'>" + "</form>" + "<input type='submit' value='précédent' onclick='precedent();return false'>" + "</div>";
    } else if(page == 5) {
        document.getElementById("affichage").innerHTML = "<img src='../../images/documents.png' class='center'>" + "<div id='bloc1'>" + "<form onsubmit='doc();return false'>" + "<label for='identity'>Carte d'identité (recto / verso):</label>" + "<input type='file' id='identity' accept='.jpg, .png, .pdf' required>" + "<br/>" + "<label for='carteVitale'>Carte vitale:</label>" + "<input type='file' id='carteVitale' accept='.jpg, .png, .pdf' required>" + "<br/>" + "<label for='mutuelle'>Carte de mutuelle:</label>" + "<input type='file' id='mutuelle' name='mutuelle' accept='.jpg, .png, .pdf' required>" + "<br/>" + "<label for='livretFamille'>Livret de famille (pour enfants mineurs):</label>" + "<input type='file' id='livretFamille' name='livretFamille' accept='.jpg, .png, .pdf'>" + "<br/>" + "<input type='submit' name='submit' id='submit' value='Valider'>" + "</form>" + "<input id='submit' name='submit' type='submit' value='précédent' onclick='precedent();return false'>" + "</div>";
    } else {
        document.getElementById("affichage").innerHTML = "<div id='bloc1'>" + "<form method='POST' action='hospitalisation.php'>" + "<input id='submit' name='submit' type='submit' value='Envoyer'>" + "</form>" + "</div>";
    }
}

function hospitalisation() {
    preadmi = document.getElementById("preadmi").value;
    date_hospi = document.getElementById("date_hospi").value;
    heure = document.getElementById("heure").value;
    medecin = document.getElementById("medecin").value;
    if(erreur == true) {
        message4();
        return;
    }
    page = page + 1;
    pages();
}

function log(value) {
    console.log(value);
}

function verif() {
    heure = document.getElementById("heure").value;
    verif_time(heure);
}

function verif_time(time) {
    let [hours, mins] = time.split(":");
    if((hours < 7) || (hours > 16) || (hours == 16 && mins > 30)) {
        erreur = true;
    } else {
        const d = new Date();
        const yyyy = d.getFullYear();
        let mm = d.getMonth() + 1;
        let dd = d.getDate();

        if (dd < 10) dd = '0' + dd;
        if (mm < 10) mm = '0' + mm;

        const Today = yyyy + "-" + mm + "-" + dd;
        const heures = d.getHours();
        const minutes = d.getMinutes();
        const date = document.getElementById("date_hospi").value;
        if((heures > hours || (heures == hours && minutes > mins)) && (Today == date)) {
            erreur = true;
        } else {
            erreur = false;
        }
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
    verif_patients();
    if(erreur == true) {
        return;
    }
    page = page + 1;
    pages();
}

function verif_patients() {
    if(email.includes("@") && (email.endsWith(".com") || email.endsWith(".fr") || email.endsWith(".en") || email.endsWith(".net") || email.endsWith(".co.uk"))) {
        if(email.endsWith("@.com") || email.endsWith("@.fr") || email.endsWith("@.en") || email.endsWith("@.net") || email.endsWith("@.co.uk")) {
            message6();
            erreur = true;
        } else {
            if(email.startsWith("@")) {
                message6();
                erreur = true;
            } else {
                erreur = false;
            }
        }
    } else {
        message6();
        erreur = true;
    }
}

function prevenir() {
    nom_prev = document.getElementById("nom_prev").value;
    pren_prev = document.getElementById("pren_prev").value;
    tel_prev = document.getElementById("tel_prev").value;
    adr_prev = document.getElementById("adr_prev").value;
    verif_prevenir();
    if(erreur == true) {
        message7();
        return;
    }
    page = page + 1;
    pages();
}

function verif_prevenir() {
    if(tel_prev == tel) {
        erreur = true;
    } else {
        erreur = false;
    }
}

function confiance() {
    nom_conf = document.getElementById("nom_conf").value;
    pren_conf = document.getElementById("pren_conf").value;
    tel_conf = document.getElementById("tel_conf").value;
    adr_conf = document.getElementById("adr_conf").value;
    verif_confiance();
    if(erreur == true) {
        message7();
        return;
    }
    page = page + 1;
    pages();
}

function verif_confiance() {
    if(tel_conf == tel) {
        erreur = true;
    } else {
        erreur = false;
    }
}

function couv_sociale() {
    orga = document.getElementById("orga").value;
    num_secu = document.getElementById("num_secu").value;
    assure = document.getElementById("assure").value;
    ald = document.getElementById("ald").value;
    nom_mutu = document.getElementById("nom_mutu").value;
    num_adherent = document.getElementById("num_adherent").value;
    chambre_part = document.getElementById("chambre_part").value;
    verif_num_secu();
    if(erreur == true) {
        return;
    }
    page = page + 1;
    pages();
}

function verif_num_secu() { // Vérification du numéro de sécurité sociale
    const first = num_secu.slice(0,1);
    const first_year = num_secu.slice(1,3);
    const first_month = num_secu.slice(3,5);
    const verif_cp = cp.slice(0,2);
    const data_birth = new Date(date_nais);
    const first_cp  = num_secu.slice(5,7);
    const y = data_birth.getFullYear().toString().slice(2,4);
    const x = (data_birth.getMonth() + 1).toString();
    if((first == 1 && civ != "Homme") || (first == 2 && civ != "Femme") || ((first != 1) && (first != 2))) {
        message();
        erreur = true;
    } else if(y != first_year) {
        message2();
        erreur = true;
    } else if(x != first_month) {
        message3();
        erreur = true;
    } else if(verif_cp != first_cp) {
        message5();
        erreur = true;
    } else {
        erreur = false;
    }
}

function doc() {
    doc_identite = document.getElementById("identity").value;
    doc_vitale = document.getElementById("carteVitale").value;
    doc_mutuelle = document.getElementById("mutuelle").value;
    doc_livret = document.getElementById("livretFamille").value;
    ajax();
    page = page + 1;
    pages();
}

function precedent() {
    page = page - 1;
    pages();
}

function message() {
    show();
    document.getElementById("erreur").innerHTML = "<img src='../../images/erreur.jpg' style='height: 50%; width: 50%;'><br/>" + "Numéro de sécurité sociale incompatible avec la civilté!<br/>" + "<input type='submit' onclick='cache_erreur();return false' value='OK'>";
}

function message2() {
    show();
    document.getElementById("erreur").innerHTML = "<img src='../../images/erreur.jpg' style='height: 50%; width: 50%;'><br/>" + "Numéro de sécurité sociale incompatible avec l'année de naissance!<br/>" + "<input type='submit' onclick='cache_erreur();return false' value='OK'>";
}

function message3() {
    show();
    document.getElementById("erreur").innerHTML = "<img src='../../images/erreur.jpg' style='height: 50%; width: 50%;'><br/>" + "Numéro de sécurité sociale incompatible avec le mois de naissance!<br/>" + "<input type='submit' onclick='cache_erreur();return false' value='OK'>";
}

function message4() {
    show();
    document.getElementById("erreur").innerHTML = "<img src='../../images/erreur.jpg' style='height: 50%; width: 50%;'><br/>" + "Heure d'intervention incorrecte!<br/>" + "<input type='submit' onclick='cache_erreur();return false' value='OK'>";
}

function message5() {
    show();
    document.getElementById("erreur").innerHTML = "<img src='../../images/erreur.jpg' style='height: 50%; width: 50%;'><br/>" + "Numéro de sécurité sociale incompatible avec le code postal!<br/>" + "<input type='submit' onclick='cache_erreur();return false' value='OK'>";
}

function message6() {
    show();
    document.getElementById("erreur").innerHTML = "<img src='../../images/erreur.jpg' style='height: 50%; width: 50%;'><br/>" + "Le mail est incorrect!<br/>" + "<input type='submit' onclick='cache_erreur();return false' value='OK'>";
}

function message7() {
    show();
    document.getElementById("erreur").innerHTML = "<img src='../../images/erreur.jpg' style='height: 50%; width: 50%;'><br/>" + "Le numéro de téléphone ne peut pas être celui du patient!<br/>" + "<input type='submit' onclick='cache_erreur();return false' value='OK'>";
}

function cache_erreur() {
    document.getElementById("erreur").innerHTML = "";
    show();
}

function show(){
    var stats =  document.getElementById("hide1").style.display;
      
    if (stats == "none"){
    document.getElementById("hide1").style.display = "inline-block";
    } else {
    document.getElementById("hide1").style.display = "none";  
    }
}

function ajax() {
    ajax1();
    ajax2();
    ajax3();
    ajax4();
    ajax5();
    ajax6();
    ajax7();
    ajax8();
    ajax9();
    ajax10();
    ajax11();
    ajax12();
    ajax13();
    ajax14();
    ajax15();
    ajax16();
    ajax17();
    ajax18();
    ajax19();
    ajax20();
    ajax21();
    ajax22();
    ajax23();
    ajax24();
    ajax25();
    ajax26();
    ajax27();
    ajax28();
    ajax29();
}

function ajax1() {
    return $.ajax({
        url: '../pages/PreAdmi/hospitalisation.php',
        type: 'POST',
        data: ({ preadmi_ajax: preadmi }),
        success: function(data) {
            console.log(data);
         }
    });
    
}

function ajax2() {
    return $.ajax({
        url: '../pages/PreAdmi/hospitalisation.php',
        type: 'POST',
        data: ({ date_hospi_ajax: date_hospi }),
        success: function(data) {
            console.log(data);
         }
    });
    
}

function ajax3() {
    return $.ajax({
        url: '../pages/PreAdmi/hospitalisation.php',
        type: 'POST',
        data: ({ heure_ajax: heure }),
        success: function(data) {
            console.log(data);
         }
    });
    
}

function ajax4() {
    return $.ajax({
        url: '../pages/PreAdmi/hospitalisation.php',
        type: 'POST',
        data: ({ medecin_ajax: medecin }),
        success: function(data) {
            console.log(data);
         }
    });
    
}

function ajax5() {
    return $.ajax({
        url: '../pages/PreAdmi/hospitalisation.php',
        type: 'POST',
        data: ({ civ_ajax: civ }),
        success: function(data) {
            console.log(data);
         }
    });
    
}

function ajax6() {
    return $.ajax({
        url: '../pages/PreAdmi/hospitalisation.php',
        type: 'POST',
        data: ({ nom_nais_ajax: nom_nais }),
        success: function(data) {
            console.log(data);
         }
    });
    
}

function ajax7() {
    return $.ajax({
        url: '../pages/PreAdmi/hospitalisation.php',
        type: 'POST',
        data: ({ nom_ep_ajax: nom_ep }),
        success: function(data) {
            console.log(data);
         }
    });
    
}

function ajax8() {
    return $.ajax({
        url: '../pages/PreAdmi/hospitalisation.php',
        type: 'POST',
        data: ({ pren_ajax: pren }),
        success: function(data) {
            console.log(data);
         }
    });
    
}

function ajax9() {
    return $.ajax({
        url: '../pages/PreAdmi/hospitalisation.php',
        type: 'POST',
        data: ({ date_nais_ajax: date_nais }),
        success: function(data) {
            console.log(data);
         }
    });
    
}

function ajax10() {
    return $.ajax({
        url: '../pages/PreAdmi/hospitalisation.php',
        type: 'POST',
        data: ({ adr_ajax: adr }),
        success: function(data) {
            console.log(data);
         }
    });
    
}

function ajax11() {
    return $.ajax({
        url: '../pages/PreAdmi/hospitalisation.php',
        type: 'POST',
        data: ({ cp_ajax: cp }),
        success: function(data) {
            console.log(data);
         }
    });
    
}

function ajax12() {
    return $.ajax({
        url: '../pages/PreAdmi/hospitalisation.php',
        type: 'POST',
        data: ({ ville_ajax: ville }),
        success: function(data) {
            console.log(data);
         }
    });
    
}

function ajax13() {
    return $.ajax({
        url: '../pages/PreAdmi/hospitalisation.php',
        type: 'POST',
        data: ({ email_ajax: email }),
        success: function(data) {
            console.log(data);
         }
    });
    
}

function ajax14() {
    return $.ajax({
        url: '../pages/PreAdmi/hospitalisation.php',
        type: 'POST',
        data: ({ tel_ajax: tel }),
        success: function(data) {
            console.log(data);
         }
    });
    
}

function ajax15() {
    return $.ajax({
        url: '../pages/PreAdmi/hospitalisation.php',
        type: 'POST',
        data: ({ nom_prev_ajax: nom_prev }),
        success: function(data) {
            console.log(data);
         }
    });
    
}

function ajax16() {
    return $.ajax({
        url: '../pages/PreAdmi/hospitalisation.php',
        type: 'POST',
        data: ({ pren_prev_ajax: pren_prev }),
        success: function(data) {
            console.log(data);
         }
    });
    
}

function ajax17() {
    return $.ajax({
        url: '../pages/PreAdmi/hospitalisation.php',
        type: 'POST',
        data: ({ tel_prev_ajax: tel_prev }),
        success: function(data) {
            console.log(data);
         }
    });
    
}

function ajax18() {
    return $.ajax({
        url: '../pages/PreAdmi/hospitalisation.php',
        type: 'POST',
        data: ({ adr_prev_ajax: adr_prev }),
        success: function(data) {
            console.log(data);
         }
    });
    
}

function ajax19() {
    return $.ajax({
        url: '../pages/PreAdmi/hospitalisation.php',
        type: 'POST',
        data: ({ orga_ajax: orga }),
        success: function(data) {
            console.log(data);
         }
    });
    
}

function ajax20() {
    return $.ajax({
        url: '../pages/PreAdmi/hospitalisation.php',
        type: 'POST',
        data: ({ num_secu_ajax: num_secu }),
        success: function(data) {
            console.log(data);
         }
    });
    
}

function ajax21() {
    return $.ajax({
        url: '../pages/PreAdmi/hospitalisation.php',
        type: 'POST',
        data: ({ assure_ajax: assure }),
        success: function(data) {
            console.log(data);
         }
    });
    
}

function ajax22() {
    return $.ajax({
        url: '../pages/PreAdmi/hospitalisation.php',
        type: 'POST',
        data: ({ ald_ajax: ald }),
        success: function(data) {
            console.log(data);
         }
    });
    
}

function ajax23() {
    return $.ajax({
        url: '../pages/PreAdmi/hospitalisation.php',
        type: 'POST',
        data: ({ nom_mutu_ajax: nom_mutu }),
        success: function(data) {
            console.log(data);
         }
    });
    
}

function ajax24() {
    return $.ajax({
        url: '../pages/PreAdmi/hospitalisation.php',
        type: 'POST',
        data: ({ num_adherent_ajax: num_adherent }),
        success: function(data) {
            console.log(data);
         }
    });
    
}

function ajax25() {
    return $.ajax({
        url: '../pages/PreAdmi/hospitalisation.php',
        type: 'POST',
        data: ({ chambre_part_ajax: chambre_part }),
        success: function(data) {
            console.log(data);
         }
    });
    
}

function ajax26() {
    return $.ajax({
        url: '../pages/PreAdmi/hospitalisation.php',
        type: 'POST',
        data: ({ doc_identite_ajax: doc_identite }),
        success: function(data) {
            console.log(data);
         }
    });
    
}

function ajax27() {
    return $.ajax({
        url: '../pages/PreAdmi/hospitalisation.php',
        type: 'POST',
        data: ({ doc_livret_ajax: doc_livret }),
        success: function(data) {
            console.log(data);
         }
    });
    
}

function ajax28() {
    return $.ajax({
        url: '../pages/PreAdmi/hospitalisation.php',
        type: 'POST',
        data: ({ doc_mutuelle_ajax: doc_mutuelle }),
        success: function(data) {
            console.log(data);
         }
    });
    
}

function ajax29() {
    return $.ajax({
        url: '../pages/PreAdmi/hospitalisation.php',
        type: 'POST',
        data: ({ doc_vitale_ajax: doc_vitale }),
        success: function(data) {
            console.log(data);
         }
    });
}