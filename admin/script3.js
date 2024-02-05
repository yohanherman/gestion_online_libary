

// requete pour verifier si isbn existe en base de données
let btn22=document.querySelector("#ajouter");
// ici je desactive le bouton par defaut
btn22.disabled = true;

console.log(btn22);


function checkISBN(){

    const isbn=document.querySelector("#isbn").value;

    var xmlhttp=new XMLHttpRequest();

    xmlhttp.onreadystatechange = function(){
        if(this.readyState == 4 && this.status == 200){

            document.querySelector(".containerHtml").innerHTML=this.responseText;

            if(this.responseText.trim().includes("ISBN deja existant")){
                btn22.disabled=true;
            }else{
                btn22.disabled=false;
            }
        }
    }

    xmlhttp.onerror = function () {
        console.error("Erreur survenue durant la requete ajax.");
    };

    xmlhttp.open("POST","get_isbn.php",true);
    xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
    xmlhttp.send("isbn="+ isbn);
}




// activer le bouton avant de confirmer la modification si les deux mor de passe correspondent;

const presentpass=document.querySelector("#newpass");
const confirmpass=document.querySelector("#newpassconfirm");

const btn=document.querySelector(".btnverif");
const message=document.querySelector(".message");




function valid(){

confirmpass.addEventListener("keyup",()=>{

    if(confirmpass.value === presentpass.value){
        // return true
        btn.disabled=false
        message.innerHTML=" mots de passe identiques";
        message.style.color="green"
        confirmpass.style.border="solid 1px green"
        presentpass.style.border="solid 1px green"


    }else{ 
    //    return false;
        btn.disabled=true;
        message.innerHTML=" les mots de passe ne sont pas identiques";
        message.style.color="red"
        confirmpass.style.border="solid 1px red";
        presentpass.style.border="solid 1px red"

        // presentpass.style.border="red"
        
    }
})
}

valid();


// requete ajax pour recuperer le electeur

function recuplecteur(){

    const lecteurId=document.querySelector("#identifiant").value;
    let xmlhttp=new XMLHttpRequest();

    xmlhttp.onreadystatechange = function(){

        if(this.readyState == 4 && this.status==200){

            document.querySelector(".containerHTML").innerHTML=this.responseText;
          
        }
    }

    xmlhttp.open("POST","get_reader.php", true);
    xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
    xmlhttp.send("identifiant=" + lecteurId);
}



// requete ajax pour recuperer le livre

function recupLivre() {
    let titrelivre = document.querySelector("#isbn").value;

    const xmlhttp = new XMLHttpRequest();

    xmlhttp.onreadystatechange = function() {

        if (this.readyState == 4 && this.status == 200) {
            document.querySelector(".containerHTML2").innerHTML = this.responseText;
        }
    }

    xmlhttp.open("POST", "get_book.php", true);
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.send('isbn=' + titrelivre);
}


