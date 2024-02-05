
    let Password = document.querySelector("#Password");
    let PasswordConfirm = document.querySelector("#PasswordConfirm");
    let btn = document.querySelector(".enregister");

function valid(){
// console.log(btn);

    PasswordConfirm.addEventListener("input",()=>{
        if(Password.value !== PasswordConfirm.value){
            btn.disabled=true;
            // return false;
          
        }else{
            btn.disabled=false;
    
            // return true;
        }
    })}

valid();



  // ma requete ajax

  function checkAvailability() {

    // je recupere ici la valeur de l'e-mail

    const email = document.getElementById("email").value;
     // je cree ensuite mon objet XMLHttpRequest
     
     const xmlhttp = new XMLHttpRequest();

    // Gestion des changements d'état

     xmlhttp.onreadystatechange = function() {

        if (this.readyState == 4 && this.status == 200) {

            // je Mets à jour le message d'affichage avec la réponse du serveur

           document.getElementById("messageaffichage").innerHTML = this.responseText;
           

         }
     };

     // Configuration de la requête POST

    xmlhttp.open("POST", "check_availability.php", true);

     xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

     // j'envoie données avec  POST

    xmlhttp.send("EmailId=" + email);
 
}




