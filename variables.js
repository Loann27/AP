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
let erreur_time = false;
let erreur_patient = false;
let erreur_prevenir = false;
let erreur_confiance = false;
let erreur_secu = false;
show();
document.getElementById('date_hospi').setAttribute('min',getISODate());
document.getElementById('date_hospi').setAttribute('max',getNextISODate());
document.getElementById('date_naissance').setAttribute('max',getISODate());

function getISODate(){
    const d = new Date();
    return d.getFullYear() + '-' + 
            ('0' + (d.getMonth()+1)).slice(-2) + '-' +
            ('0' + d.getDate()).slice(-2);
}

function getNextISODate(){
    const d = new Date();
    return (d.getFullYear()+1) + '-' +
            ('0' + (d.getMonth()+1)).slice(-2) + '-' +
            ('0' + d.getDate()).slice(-2);
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
            erreur_time = true;
        } else {
            erreur_time = false;
        }
    }
}

function verif_patients() {
    email = document.getElementById('email').value;
    if(email.includes("@") && (email.endsWith(".com") || email.endsWith(".fr") || email.endsWith(".en") || email.endsWith(".net") || email.endsWith(".co.uk"))) {
        if(email.endsWith("@.com") || email.endsWith("@.fr") || email.endsWith("@.en") || email.endsWith("@.net") || email.endsWith("@.co.uk")) {
            erreur_patient = true;
        } else {
            if(email.startsWith("@")) {
                erreur_patient = true;
            } else {
                erreur_patient = false;
            }
        }
    } else {
        erreur_patient = true;
    }
}

function verif_prevenir() {
    tel = document.getElementById('telephone').value;
    tel_prev = document.getElementById('tel_prev').value;
    if(tel_prev == tel) {
        erreur_prevenir = true;
    } else {
        erreur_prevenir = false;
    }
}

function verif_confiance() {
    tel = document.getElementById('telephone').value;
    tel_conf = document.getElementById('tel_conf').value;
    if(tel_conf == tel) {
        erreur_confiance = true;
    } else {
        erreur_confiance = false;
    }
}

function verif_num_secu() { // Vérification du numéro de sécurité sociale
    num_secu = document.getElementById('num_secu').value;
    date_nais = document.getElementById('date_naissance').value;
    civ = document.getElementById('civ').value;
    const first = num_secu.slice(0,1);
    const first_year = num_secu.slice(1,3);
    const first_month = num_secu.slice(3,5);
    const data_birth = new Date(date_nais);
    const y = data_birth.getFullYear().toString().slice(2,4);
    const x = (data_birth.getMonth() + 1);
    let z = "";
    if(x < 10) {
        z = "0" + x.toString();
    } else {
        z = x.toString();
    }
    if((first == 1 && civ != "Homme") || (first == 2 && civ != "Femme") || ((first != 1) && (first != 2))) {
        erreur_secu = true;
    } else if(y != first_year) {
        erreur_secu = true;
    } else if(z != first_month) {
        erreur_secu = true;
    } else {
        erreur_secu = false;
    }
}

function message() {
    show();
    document.getElementById("erreur").innerHTML = "<img src='../../images/erreur.jpg' style='height: 50%; width: 50%;'><br/>" + "L'heure est incorrecte!<br/>" + "<input type='submit' onclick='cache_erreur();return false' value='OK'>";
}

function message2() {
    show();
    document.getElementById("erreur").innerHTML = "<img src='../../images/erreur.jpg' style='height: 50%; width: 50%;'><br/>" + "L'email du patient est incorrect!<br/>" + "<input type='submit' onclick='cache_erreur();return false' value='OK'>";
}

function message3() {
    show();
    document.getElementById("erreur").innerHTML = "<img src='../../images/erreur.jpg' style='height: 50%; width: 50%;'><br/>" + "Le téléphone de la personne à prévenir ne peut pas être celui du patient!<br/>" + "<input type='submit' onclick='cache_erreur();return false' value='OK'>";
}

function message4() {
    show();
    document.getElementById("erreur").innerHTML = "<img src='../../images/erreur.jpg' style='height: 50%; width: 50%;'><br/>" + "Le téléphone de la personne de confiance ne peut pas être celui du patient!<br/>" + "<input type='submit' onclick='cache_erreur();return false' value='OK'>";
}

function message5() {
    show();
    document.getElementById("erreur").innerHTML = "<img src='../../images/erreur.jpg' style='height: 50%; width: 50%;'><br/>" + "Le numéro de sécurité sociale est incorrect!<br/>" + "<input type='submit' onclick='cache_erreur();return false' value='OK'>";
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

document.getElementById("myForm").addEventListener("submit", function(event) {
    if(erreur_time == true) {
        message();
        event.preventDefault();
        return false;
    } else if(erreur_patient == true) {
        message2();
        event.preventDefault();
        return false;
    } else if(erreur_prevenir == true) {
        message3();
        event.preventDefault();
        return false;
    } else if(erreur_confiance == true) {
        message4();
        event.preventDefault();
        return false;
    } else if(erreur_secu == true) {
        message5();
        event.preventDefault();
        return false;
    }
});
